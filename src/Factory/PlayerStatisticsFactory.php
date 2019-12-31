<?php

namespace App\Factory;

use App\Entity\Player;
use App\Entity\PlayerStatistics;
use App\Repository\PlayerStatisticsRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;

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
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * PlayerStatisticsFactory constructor.
     *
     * @param PlayerStatisticsRepository $statsRepo
     * @param EntityManagerInterface     $em
     */
    public function __construct(PlayerStatisticsRepository $statsRepo, EntityManagerInterface $em)
    {
        $this->statsRepo = $statsRepo;
        $this->em = $em;
    }

    /**
     * @param Player $player
     * @param array  $statsData
     *
     * @return Collection
     */
    public function create(Player $player, array $statsData) : Collection
    {
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
                $player->addStatistic($stats);
                $stats
                    ->setYear($period['year'])
                    ->setSurface($surface['type'])
                    ->setTournamentPlayed($surface['statistics']['tournaments_played'])
                    ->setTournamentWon($surface['statistics']['tournaments_won'])
                    ->setMatchesPlayed($surface['statistics']['matches_played'])
                    ->setMatchesWon($surface['statistics']['matches_won']);
                $this->em->persist($stats);
            }
        }
        $this->em->flush();

        return $player->getStatistics();
    }
}
