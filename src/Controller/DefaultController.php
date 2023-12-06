<?php

namespace App\Controller;

use App\Service\LoadPostsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'app_default')]
    public function index(): Response
    {
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    // #[Route('/test', name: 'test')]
    // public function test(LoadPostsService $lp): Response
    // {
    //     dd($lp->loadPosts());//mmmyyy

    // }
}
