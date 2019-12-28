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
     * @Route("/rankings", name="rankings_index")
     *
     * @throws ExceptionInterface
     */
    public function index(APICall $apicall)
    {
        $url = 'https://api.sportradar.com/tennis-t2/en/players/rankings.json?api_key=';
/*        $rankings = $apicall->sportradarCall($url);*/

        return $this->render('rankings/index.html.twig', [
            'controller_name' => 'RankingsController',
        ]);
    }
}
