<?php

namespace App\Factory;

use App\Entity\Player;
use App\Entity\PlayerSinglesRanking;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class PlayerSinglesRankingFactory
 */
class PlayerSinglesRankingFactory
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * PlayerSinglesRankingFactory constructor.
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
     * @return PlayerSinglesRanking
     */
    public function create(Player $player, array $rankingData) : ?PlayerSinglesRanking
    {
        $singlesRanking = $player->getSinglesRanking();
        if (null === $singlesRanking) {
            $singlesRanking = new PlayerSinglesRanking();
        }
        if ('singles' === $rankingData[0]['type']) {
            $singlesRanking
                ->setPlayer($player)
                ->setRank($rankingData[0]['rank'])
                ->setPoints($rankingData[0]['points'])
                ->setName($rankingData[0]['name']);
        } else {
            if (count($rankingData) > 1) {
                $singlesRanking
                    ->setPlayer($player)
                    ->setRank($rankingData[0]['rank'])
                    ->setPoints($rankingData[0]['points'])
                    ->setName($rankingData[0]['name']);
            } else {
                return null;
            }
        }
        $this->em->persist($singlesRanking);
        $this->em->flush();

        return $singlesRanking;
    }
}
