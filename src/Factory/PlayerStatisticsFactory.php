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
     * @var PlayerStatisticsRepository
     */
    private $statsRepo;

    /**
     * PlayerStatisticsFactory constructor.
     *
     * @param PlayerStatisticsRepository $statsRepo
     */
    public function __construct(PlayerStatisticsRepository $statsRepo)
    {
        $this->statsRepo = $statsRepo;
    }

    /**
     * @param Player $player
     * @param array  $statsData
     *
     * @return array
     */
    public function create(Player $player, array $statsData) : array
    {
        $statsTotal = [];
        foreach ($statsData['periods'] as $period) {
            foreach ($period['surfaces'] as $surface) {
                $stats = $this->statsRepo->findOneBy([
                    'player'  => $player->getId(),
                    'year'    => $period['year'],
                    'surface' => $surface['type'],
                ]);
                if (null === $stats) {
                    $stats = new PlayerStatistics();
                }
                $stats
                    ->setPlayer($player)
                    ->setYear($period['year'])
                    ->setSurface($surface['type'])
                    ->setTournamentPlayed($surface['statistics']['tournaments_played'])
                    ->setTournamentWon($surface['statistics']['tournaments_won'])
                    ->setMatchesPlayed($surface['statistics']['matches_played'])
                    ->setMatchesWon($surface['statistics']['matches_won']);
                array_push($statsTotal, $stats);
            }
        }

        return $statsTotal;
    }
}
