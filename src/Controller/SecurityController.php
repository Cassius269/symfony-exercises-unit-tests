<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

final class SecurityController extends AbstractController
{
    #[Route(
        path: '/inscription',
        name: 'inscription',
        methods: ['GET', 'POST']
    )]
    public function register(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        // Créer un nouvel objet utilisateur
        $author = new Author();

        // Créer le formulaire
        $form = $this->createForm(UserType::class, $author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $author->setPassword($userPasswordHasher->hashPassword($author, $author->getPassword()))
                ->setCreatedAt(new \DateTimeImmutable('now'))
                ->setRoles(['ROLE_AUTHOR']);

            // enregistrer le nouvel utilisateur en BDD
            $entityManager->persist($author);
            $entityManager->flush();

            $this->addFlash('success', 'Nouvel utilisateur créé');
            return $this->redirectToRoute('home', [], 201);
        }

        return $this->render("security/register.html.twig", [
            'form' => $form->createView()
        ]);
    }

    #[
        Route(
            path: '/login',
            name: 'login',
            methods: ['GET', 'POST']
        )
    ]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $username = $authenticationUtils->getLastUsername();

        if ($error) {
            $this->addFlash('error', 'Une erreur s\'est produite');
        }
        return $this->render('security/login.html.twig', [
            'error' => $error,
            'username' => $username
        ]);
    }


    #[Route(
        path: '/logout',
        name: 'logout'
    )]
    public function logout() {}
}
