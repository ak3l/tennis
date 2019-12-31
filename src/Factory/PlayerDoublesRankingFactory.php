<?php

namespace App\Factory;

use App\Entity\Player;
use App\Entity\PlayerDoublesRanking;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class PlayerDoublesRankingFactory
 */
class PlayerDoublesRankingFactory
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * PlayerDoublesRankingFactory constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param Player $player
     * @param array  $rankingData
     *
     * @return PlayerDoublesRanking
     */
    public function create(Player $player, array $rankingData) : ?PlayerDoublesRanking
    {
        $doublesRanking = $player->getDoublesRanking();
        if (null === $doublesRanking) {
            $doublesRanking = new PlayerDoublesRanking();
        }
        if ('doubles' === $rankingData[0]['type']) {
            $doublesRanking
                ->setPlayer($player)
                ->setRank($rankingData[0]['rank'])
                ->setPoints($rankingData[0]['points'])
                ->setName($rankingData[0]['name']);
        } else {
            if (count($rankingData) > 1) {
                $doublesRanking
                    ->setPlayer($player)
                    ->setRank($rankingData[1]['rank'])
                    ->setPoints($rankingData[1]['points'])
                    ->setName($rankingData[1]['name']);
            } else {
                return null;
            }
        }
        $this->em->persist($doublesRanking);
        $this->em->flush();

        return $doublesRanking;
    }
}
