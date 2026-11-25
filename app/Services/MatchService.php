<?php

namespace App\Services;

use App\Models\Item;
use App\Models\ItemMatch;
use App\Models\AppNotification;

class MatchService
{
    // CTU Tuburan Campus Zones
    private array $zones = [
        'A' => [
            'TB1', 'TB2', 'TB3', 'TB4',
            'ASB1', 'ASMB', 'ASB2',
            'Library', 'CAS', 'COT', 'COED',
            'Speech Communication Lab',
            'Math Lab', 'ICT Lab',
        ],
        'B' => [
            'Administration Building',
            'SSFB', 'HMB', 'SAC',
            'Cafeteria', 'FIC', 'FabLab',
            'Guidance Office', 'SSC',
            'Cashier', 'Registrar',
        ],
        'C' => [
            'Men\'s Dormitory',
            'Women\'s Dormitory',
            'Hometel',
            'GAD & Pasalubong Center',
        ],
        'D' => [
            'Gate / Entrance',
            'Parking Area',
            'Security Office',
            'Bulawanong Tinubdan Cultural Center',
        ],
        'E' => [
            'Science Building',
            'Engineering Building',
            'Animal Science Building',
        ],
        'F' => [
            'Farmers Training Center',
            'COAgri',
        ],
    ];

    // Adjacent zones get 40% score
    private array $adjacentZones = [
        'A' => ['B', 'D'],
        'B' => ['A', 'C', 'D'],
        'C' => ['B', 'D'],
        'D' => ['A', 'B', 'C'],
        'E' => ['A', 'F'],
        'F' => ['E'],
    ];

    public function findMatches(Item $item): void
    {
        $oppositeType = $item->type === 'lost' ? 'found' : 'lost';

        $candidates = Item::where('type', $oppositeType)
            ->where('status', 'active')
            ->get();

        // New matches created just now that are worth notifying about
        $newMatches = [];

        foreach ($candidates as $candidate) {
            $locationScore  = $this->scoreLocation($item, $candidate);
            $dateTimeScore  = $this->scoreDateTime($item, $candidate);
            $categoryScore  = $this->scoreCategory($item, $candidate);

            $totalScore = ($locationScore * 0.40)
                        + ($dateTimeScore  * 0.30)
                        + ($categoryScore  * 0.30);

            $matchLevel = $this->getMatchLevel($totalScore);

            $lostId  = $item->type === 'lost' ? $item->id : $candidate->id;
            $foundId = $item->type === 'found' ? $item->id : $candidate->id;

            $match = ItemMatch::updateOrCreate(
                ['lost_item_id' => $lostId, 'found_item_id' => $foundId],
                [
                    'location_score'  => $locationScore,
                    'date_time_score' => $dateTimeScore,
                    'category_score'  => $categoryScore,
                    'total_score'     => $totalScore,
                    'match_level'     => $matchLevel,
                ]
            );

            // Notify only for new, good matches between two different users
            if ($match->wasRecentlyCreated
                && in_array($matchLevel, ['high', 'possible'])
                && $item->user_id !== $candidate->user_id) {
                $newMatches[] = ['match' => $match, 'candidate' => $candidate];
            }
        }

        $this->notifyLostUsers($item, $newMatches);
    }

    /**
     * Only the LOST user is notified, and only once per lost item.
     * - New LOST report  -> the reporter is told if items found by other users already match.
     * - New FOUND report -> the owner of each matching lost report is told.
     * The finder is not notified here.
     */
    private function notifyLostUsers(Item $item, array $newMatches): void
    {
        if (empty($newMatches)) {
            return;
        }

        // Group the new matches by the LOST item they belong to
        $byLostItem = [];

        foreach ($newMatches as $entry) {
            $lostItem = $item->type === 'lost' ? $item : $entry['candidate'];

            $byLostItem[$lostItem->id]['lost']      = $lostItem;
            $byLostItem[$lostItem->id]['matches'][] = $entry['match'];
        }

        foreach ($byLostItem as $data) {
            $lost = $data['lost'];

            // Skip if this owner was already told about this lost item
            $alreadyNotified = AppNotification::where('user_id', $lost->user_id)
                ->where('type', 'match')
                ->where(function ($q) use ($lost) {
                    $q->where('reference_id', $lost->id)
                      ->orWhere('message', 'like', '%your lost item "' . $lost->title . '"%');
                })
                ->exists();

            if ($alreadyNotified) {
                continue;
            }

            $count = count($data['matches']);

            $message = $count === 1
                ? 'Another user found an item that may match your lost item "' . $lost->title . '".'
                : $count . ' items found by other users may match your lost item "' . $lost->title . '".';

            AppNotification::create([
                'user_id'      => $lost->user_id,
                'title'        => 'Possible Match Found!',
                'message'      => $message,
                'type'         => 'match',
                'reference_id' => $lost->id,   // the LOST item, used to avoid duplicates
            ]);
        }
    }

    private function getZone(string $location): ?string
    {
        foreach ($this->zones as $zone => $locations) {
            if (in_array($location, $locations)) {
                return $zone;
            }
        }
        return null;
    }

    private function scoreLocation(Item $a, Item $b): float
    {
        // Exact same location = 100%
        if ($a->location === $b->location) return 100.0;

        $zoneA = $this->getZone($a->location);
        $zoneB = $this->getZone($b->location);

        // Same zone (adjacent buildings) = 70%
        if ($zoneA && $zoneB && $zoneA === $zoneB) return 70.0;

        // Adjacent zones = 40%
        if ($zoneA && $zoneB &&
            isset($this->adjacentZones[$zoneA]) &&
            in_array($zoneB, $this->adjacentZones[$zoneA])) {
            return 40.0;
        }

        // Far/different zones = 10%
        return 10.0;
    }

    private function scoreDateTime(Item $a, Item $b): float
    {
        $daysDiff = abs(
            strtotime($a->date_reported) - strtotime($b->date_reported)
        ) / 86400;

        // Same day = 100%
        if ($daysDiff == 0)  return 100.0;
        // 1 day apart = 80%
        if ($daysDiff <= 1)  return 80.0;
        // 3 days apart = 60%
        if ($daysDiff <= 3)  return 60.0;
        // 7 days apart = 40%
        if ($daysDiff <= 7)  return 40.0;
        // 14 days apart = 20%
        if ($daysDiff <= 14) return 20.0;
        // More than 14 days = 5% (not zero anymore!)
        return 5.0;
    }

    private function scoreCategory(Item $a, Item $b): float
    {
        return $a->category === $b->category ? 100.0 : 0.0;
    }

    private function getMatchLevel(float $score): string
    {
        if ($score >= 70) return 'high';
        if ($score >= 40) return 'possible';
        return 'low';
    }
}