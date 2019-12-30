<?php

namespace App\Controller;

use App\Services\API\APICall;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;

/**
 * Class RankingsController
 */
class RankingsController extends AbstractController
{
    /**
     * @param APICall $apicall
     *
     * @return Response
     *
     * @throws ExceptionInterface
     *
     * @Route("/rankings/official", name="rankings_official")
     */
    public function showOfficial(APICall $apicall)
    {
        $url = 'https://api.sportradar.com/tennis-t2/en/players/rankings.json?api_key=';
        $officialRankings = $apicall->sportradarCall($url);
        $wtaRankings = $officialRankings['rankings'][0];
        $atpRankings = $officialRankings['rankings'][1];

        return $this->render('rankings/official.html.twig', [
            'wtaRankings' => $wtaRankings,
            'atpRankings' => $atpRankings,
        ]);
    }

    /**
     * @return Response
     *
     * @Route("/rankings/live", name="rankings_live")
     */
    public function showLive() : Response
    {
        return $this->render('rankings/live.html.twig');
    }

    /**
     * @param APICall $apicall
     *
     * @return Response
     *
     * @throws ExceptionInterface
     *
     * @Route("/rankings/race", name="rankings_race")
     */
    public function showRace(APICall $apicall) : Response
    {
        $url = 'https://api.sportradar.com/tennis-t2/en/players/race_rankings.json?api_key=';
        $raceRankings = $apicall->sportradarCall($url);
        $wtaRankings = $raceRankings['rankings'][0];
        $atpRankings = $raceRankings['rankings'][1];

        return $this->render('rankings/race.html.twig', [
            'wtaRankings' => $wtaRankings,
            'atpRankings' => $atpRankings,
        ]);
    }
}
