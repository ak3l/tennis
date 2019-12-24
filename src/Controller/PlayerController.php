<?php

namespace App\Controller;

use App\Entity\Player;
use App\Entity\PlayerStatistics;
use App\Factory\PlayerDoublesRankingFactory;
use App\Factory\PlayerFactory;
use App\Factory\PlayerSinglesRankingFactory;
use App\Factory\PlayerStatisticsFactory;
use App\Services\API\APICall;
use App\Services\PlayerStatistics\PlayerStatisticsFormatter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;

/**
 * Class PlayerController
 */
class PlayerController extends AbstractController
{
    /**
     * @return Response
     *
     * @Route("/players", name="player_index")
     */
    public function index()
    {
        return $this->render('player/index.html.twig');
    }

    /**
     * @param APICall                     $apicall
     * @param EntityManagerInterface      $em
     * @param PlayerFactory               $playerFactory
     * @param PlayerSinglesRankingFactory $singlesRankingFactory
     * @param PlayerDoublesRankingFactory $doublesRankingFactory
     * @param PlayerStatisticsFactory     $statisticsFactory
     *
     * @return Response
     *
     * @Route("/addplayer/", name="player_add")
     *
     * @throws ExceptionInterface
     */
    public function addPlayer(APICall $apicall, EntityManagerInterface $em, PlayerFactory $playerFactory, PlayerSinglesRankingFactory $singlesRankingFactory, PlayerDoublesRankingFactory $doublesRankingFactory, PlayerStatisticsFactory $statisticsFactory) : Response
    {
        $playerRepo = $this->getDoctrine()->getRepository(Player::class);
        $statsRepo = $this->getDoctrine()->getRepository(PlayerStatistics::class);
        $id = 14486;
        $url = 'https://api.sportradar.com/tennis-t2/fr/players/sr:competitor:'.$id.'/profile.json?api_key=';
        $playerArray = $apicall->sportradarCall($url);
        $player = $playerFactory->create($playerArray['player'], $playerRepo);
        $singlesRanking = $singlesRankingFactory->create($player, $playerArray['rankings']);
        $doublesRanking = $doublesRankingFactory->create($player, $playerArray['rankings']);
        $statistics = $statisticsFactory->create($player, $playerArray['statistics'], $statsRepo);
        $em->persist($player);
        if (null !== $singlesRanking) {
            $em->persist($singlesRanking);
        }
        if (null !== $doublesRanking) {
            $em->persist($doublesRanking);
        }
        foreach ($statistics as $stats) {
            $em->persist($stats);
        }
        $em->flush();

        return $this->redirectToRoute('player_view', ['id' => $player->getId()]);
    }

    /**
     * @param Player                    $player
     * @param PlayerStatisticsFormatter $formatter
     *
     * @return Response
     *
     * @Route("/player/{id}", name="player_view", requirements={"id":"\d+"})
     */
    public function viewPlayer(Player $player, PlayerStatisticsFormatter $formatter) : Response
    {
        $formattedStats = $formatter->statsFormatter($player->getStatistics());
        $pictureExists = file_exists('../public/build/players/'.$player->getAbbreviation().'.jpg');

        return $this->render('player/view.html.twig', [
            'player'         => $player,
            'formattedStats' => $formattedStats,
            'picture'        => $pictureExists,
        ]);
    }
}
