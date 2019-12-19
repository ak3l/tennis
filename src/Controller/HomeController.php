<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HomeController
 */
class HomeController extends AbstractController
{
    /**
     * @return Response
     *
     * @Route("/", name="home")
     */
    public function home() : Response
    {
        return $this->render('home/home.html.twig');
    }
}
