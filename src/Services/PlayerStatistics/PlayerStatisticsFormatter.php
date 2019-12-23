<?php

namespace App\Services\PlayerStatistics;

use Doctrine\ORM\PersistentCollection;

/**
 * Class PlayerStatisticsFormatter
 */
class PlayerStatisticsFormatter
{
    /**
     * @param array $playerStats
     *
     * @return array
     */
    public function statsFormatter(PersistentCollection $playerStats) : array
    {
        $playerStatsArray = $playerStats->getValues();
        $formattedStats = [];
        $currentYear = $playerStatsArray[0]->getYear();
        $arrayYear = [
            'year'               => $currentYear,
            'matchesClayPlayed'  => 0,
            'matchesClayWon'     => 0,
            'matchesGrassPlayed' => 0,
            'matchesGrassWon'    => 0,
            'matchesHardPlayed'  => 0,
            'matchesHardWon'     => 0,
        ];
        foreach ($playerStatsArray as $key => $stats) {
            if ($currentYear === $stats->getYear()) {
                if ($stats->getSurface() === 'Red clay') {
                    $arrayYear['matchesClayPlayed'] += $stats->getMatchesPlayed();
                    $arrayYear['matchesClayWon'] += $stats->getMatchesWon();
                } elseif ($stats->getSurface() === 'Grass') {
                    $arrayYear['matchesGrassPlayed'] += $stats->getMatchesPlayed();
                    $arrayYear['matchesGrassWon'] += $stats->getMatchesWon();
                } else {
                    $arrayYear['matchesHardPlayed'] += $stats->getMatchesPlayed();
                    $arrayYear['matchesHardWon'] += $stats->getMatchesWon();
                }
            } else {
                array_push($formattedStats, $arrayYear);
                $currentYear = $stats->getYear();
                $arrayYear = [
                    'year'               => $currentYear,
                    'matchesClayPlayed'  => 0,
                    'matchesClayWon'     => 0,
                    'matchesGrassPlayed' => 0,
                    'matchesGrassWon'    => 0,
                    'matchesHardPlayed'  => 0,
                    'matchesHardWon'     => 0,
                ];
                if ($stats->getSurface() === 'Red clay') {
                    $arrayYear['matchesClayPlayed'] += $stats->getMatchesPlayed();
                    $arrayYear['matchesClayWon'] += $stats->getMatchesWon();
                } elseif ($stats->getSurface() === 'Grass') {
                    $arrayYear['matchesGrassPlayed'] += $stats->getMatchesPlayed();
                    $arrayYear['matchesGrassWon'] += $stats->getMatchesWon();
                } else {
                    $arrayYear['matchesHardPlayed'] += $stats->getMatchesPlayed();
                    $arrayYear['matchesHardWon'] += $stats->getMatchesWon();
                }
            }
        }

        return $formattedStats;
    }
}
