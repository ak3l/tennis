<?php

namespace App\Controller;

use App\Entity\Player;
use App\Entity\PlayerDoublesRanking;
use App\Entity\PlayerSinglesRanking;
use App\Entity\PlayerStatistics;
use App\Factory\PlayerDoublesRankingFactory;
use App\Factory\PlayerFactory;
use App\Factory\PlayerSinglesRankingFactory;
use App\Factory\PlayerStatisticsFactory;
use App\Services\API\APICall;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

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
     * @param PlayerFactory               $playerFactory
     * @param PlayerSinglesRankingFactory $singlesRankingFactory
     * @param PlayerDoublesRankingFactory $doublesRankingFactory
     * @param PlayerStatisticsFactory     $statisticsFactory
     *
     * @Route("/addplayer/", name="player_add")
     *
     * @throws TransportExceptionInterface|ClientExceptionInterface|DecodingExceptionInterface|RedirectionExceptionInterface|ServerExceptionInterface
     *
     * @return Response
     */
    public function addPlayer(APICall $apicall, PlayerFactory $playerFactory, PlayerSinglesRankingFactory $singlesRankingFactory, PlayerDoublesRankingFactory $doublesRankingFactory, PlayerStatisticsFactory $statisticsFactory) : Response
    {
        $playerRepo = $this->getDoctrine()->getRepository(Player::class);
        $statsRepo = $this->getDoctrine()->getRepository(PlayerStatistics::class);
        $id = 18111;
        $url = 'https://api.sportradar.com/tennis-t2/en/players/sr:competitor:'.$id.'/profile.json?api_key=';
        $playerArray = $apicall->sportradarCall($url);
        $player = $playerFactory->create($playerArray['player'], $playerRepo);
        $singlesRanking = $singlesRankingFactory->create($player, $playerArray['rankings']);
        $doublesRanking = $doublesRankingFactory->create($player, $playerArray['rankings']);
        $statistics = $statisticsFactory->create($player, $playerArray['statistics'], $statsRepo);
        die;
        $player = $playerFactory->create($playerArray);

        return new Response($playerArray['player']['name']);
    }

    /**
     * @param Player $player
     *
     * @return Response
     *
     * @Route("/player/{id}", name="player_view", requirements={"id":"\d+"})
     */
    public function viewPlayer(Player $player) : Response
    {
        return $this->render('player/view.html.twig', [
            'player' => $player,
        ]);
    }
}
