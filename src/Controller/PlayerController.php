<?php

namespace App\Controller;

use App\Form\PlayerSearchType;
use App\Repository\PlayerRepository;
use App\Services\Players\AddPlayerService;
use App\Services\PlayerStatistics\PlayerStatisticsFormatter;
use App\Services\Search\SearchFormatter;
use App\Services\Search\SearchResultsToJson;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * @param AddPlayerService          $addPlayerService
     *
     * @return Response
     *
     * @Route("/player/{slug}-{apiIdInt}", name="player_view", requirements={"apiIdInt":"\d+", "slug":"[a-z0-9\-]*"})
     *
     * @throws ExceptionInterface
     */
    public function viewPlayer(string $slug, int $apiIdInt, PlayerStatisticsFormatter $formatter, AddPlayerService $addPlayerService) : Response
    {
        $player = $this->repository->findOneBy([
            'apiId' => 'sr:competitor:'.$apiIdInt,
        ]);
        if (null === $player) {
            $player = $addPlayerService->addPlayer($apiIdInt);
        }
        if ($player->getSlug() !== $slug) {
            return $this->redirectToRoute('player_view', [
                'apiIdInt' => $player->getApiIdInt(),
                'slug'     => $player->getSlug(),
            ], 301);
        }
        $formattedStats = $formatter->statsFormatter($player->getStatistics());

        return $this->render('player/view.html.twig', [
            'player'         => $player,
            'formattedStats' => $formattedStats,
        ]);
    }

    /**
     * @param Request         $request
     * @param SearchFormatter $formatter
     *
     * @Route("player/search/", name="player_search")
     *
     * @return Response
     */
    public function searchPlayer(Request $request, SearchFormatter $formatter) : Response
    {
        $playerSearch = $request->request->get('player_search')['playerSearch'];
        $searchArray = $formatter->formatSearch($playerSearch);
        $foundPlayers = $formatter->getSearchedPlayers($searchArray);

        if (count($foundPlayers) === 1) {
            return $this->redirectToRoute('player_view', [
                'apiIdInt' => $foundPlayers[0]->getApiIdInt(),
                'slug'     => $foundPlayers[0]->getSlug(),
            ]);
        }

        return $this->render('player/search.html.twig', [
            'players' => $foundPlayers,
        ]);
    }

    /**
     * @param Request             $request
     * @param SearchResultsToJson $searchResultsToJson
     * @param SearchFormatter     $formatter
     *
     * @return Response
     *
     * @Route("/player/livesearch", name="player_lsearch")
     */
    public function searchPlayerLive(Request $request, SearchResultsToJson $searchResultsToJson, SearchFormatter $formatter) : Response
    {
        $query = $request->query->get('query');
        $searchArray = $formatter->formatSearch($query);
        $foundPlayers = $formatter->getSearchedPlayers($searchArray);
        $jsonResponse = $searchResultsToJson->searchResultsToJson($foundPlayers);

        return new JsonResponse($jsonResponse, 200, [], true);
    }
}
