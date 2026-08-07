<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route(
        path: '/',
        name: 'home',
        methods: ['GET']
    )]
    public function index(): Response
    {
        // Création d'un tableau d'utilisateurs 
        $users = [
            'user1' => 'Bob',
            'user2' => 'Bernard',
            'user3' => 'Bonnie'
        ];

        return $this->render('home/index.html.twig', [
            'users' => $users
        ]);
    }
}
