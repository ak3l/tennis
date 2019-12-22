<?php

namespace App\Factory;

use App\Entity\Player;
use App\Entity\PlayerStatistics;
use App\Repository\PlayerStatisticsRepository;

/**
 * Class PlayerStatisticsFactory
 */
class PlayerStatisticsFactory
{
    /**
     * @param Player                     $player
     * @param array                      $statsData
     * @param PlayerStatisticsRepository $repository
     *
     * @return array
     */
    public function create(Player $player, array $statsData, PlayerStatisticsRepository $repository) : array
    {
        $statsTotal = [];
        foreach ($statsData['periods'] as $year) {
            foreach ($year['surfaces'] as $surface) {
                $stats = $repository->findOneBy([
                    'player'  => $player->getId(),
                    'year'    => $year,
                    'surface' => $surface,
                ]);
                if (null === $stats) {
                    $stats = new PlayerStatistics();
                }
                $stats
                    ->setPlayer($player)
                    ->setYear($year)
                    ->setSurface($surface)
                    ->setTournamentPlayed($surface['tournament_played'])
                    ->setTournamentWon($surface['tournament_won'])
                    ->setMatchesPlayed($surface['matches_played'])
                    ->setMatchesWon($surface['matches_won']);
                $statsTotal = array_push($statsTotal, $stats);
            }
        }

        return $statsTotal;
    }
}
