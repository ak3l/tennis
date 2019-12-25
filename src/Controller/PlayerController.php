<?php

namespace App\Controller;

use App\Entity\PlayerStatistics;
use App\Factory\PlayerDoublesRankingFactory;
use App\Factory\PlayerFactory;
use App\Factory\PlayerSinglesRankingFactory;
use App\Factory\PlayerStatisticsFactory;
use App\Form\PlayerSearchType;
use App\Repository\PlayerRepository;
use App\Services\API\APICall;
use App\Services\PlayerStatistics\PlayerStatisticsFormatter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;

/**
 * Class PlayerController
 */
class PlayerController extends AbstractController
{
    /**
     * @var PlayerRepository
     */
    private $repository;

    /**
     * PlayerController constructor.
     *
     * @param PlayerRepository $repository
     */
    public function __construct(PlayerRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return Response
     *
     * @Route("/player", name="player_index")
     */
    public function index()
    {
        $formSearch = $this->createForm(PlayerSearchType::class);

        return $this->render('player/index.html.twig', [
            'formSearch' => $formSearch->createView(),
        ]);
    }

    /**
     * @param string                    $slug
     * @param int                       $apiIdInt
     * @param PlayerStatisticsFormatter $formatter
     *
     * @return Response
     *
     * @Route("/player/{slug}-{apiIdInt}", name="player_view", requirements={"apiIdInt":"\d+", "slug":"[a-z0-9\-]*"})
     */
    public function viewPlayer(string $slug, int $apiIdInt, PlayerStatisticsFormatter $formatter) : Response
    {
        $player = $this->repository->findOneBy([
            'apiId' => 'sr:competitor:'.$apiIdInt,
        ]);
        $formattedStats = $formatter->statsFormatter($player->getStatistics());
        $pictureExists = file_exists('../public/build/players/'.$player->getAbbreviation().'.jpg');

        return $this->render('player/view.html.twig', [
            'player'         => $player,
            'formattedStats' => $formattedStats,
            'picture'        => $pictureExists,
        ]);
    }

    /**
     * @param Request $request
     *
     * @Route("player/search/", name="player_search")
     *
     * @return Response
     */
    public function searchPlayer(Request $request) : Response
    {
        $playerSearch = $request->request->get('player_search')['playerSearch'];
        $players = null;
        if (strlen($playerSearch) > 1) {
            $players = $this->repository->searchPlayerByName($playerSearch);
        }

        return $this->render('player/search.html.twig', [
            'players' => $players,
        ]);
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
        $statsRepo = $this->getDoctrine()->getRepository(PlayerStatistics::class);
        $id = 14486;
        $url = 'https://api.sportradar.com/tennis-t2/fr/players/sr:competitor:'.$id.'/profile.json?api_key=';
        $playerArray = $apicall->sportradarCall($url);
        $player = $playerFactory->create($playerArray['player'], $this->repository);
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
}
