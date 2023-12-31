<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/test', name: 'app_home_test')]
    public function testLink(): Response
    {
        return $this->render('home/test.html.twig');
    }

    #[Route('/test/doctrine', name: 'app_home_test_doctrine')]
    public function testLinkDoctrine(UserRepository $repository): Response
    {
        $users = $repository->findAll();
        return $this->render('home/testdoctrine.html.twig', [
            'users' => $users,
                ]
            );
    }

}
