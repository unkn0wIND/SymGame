<?php

namespace App\Controller;

use App\Entity\Game;
use App\Form\GameType;
use App\Repository\GameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class GameController extends AbstractController
{

    /**
     * Ce controller permet d'afficher tous les jeux
     *
     * @param GameRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */

    #[Route('/mes-jeux', name: 'game_index')]
    #[IsGranted('ROLE_USER')] // Cette page est accessible si on est connecter
    public function index(GameRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {

        $games = $paginator->paginate( // Appel de Paginator(PaginatorInterface) ainsi que la méthode paginate()
            $repository->findBy(['user' => $this->getUser()]), // Requête pour récupérer les jeux relié à l'utilisateur connecter
            $request->query->getInt('page', 1), // Nombre de page
            10 //Limitation par page
        );

        return $this->render('pages/game/index.html.twig', [
            'games' => $games // Passage à la vue
        ]);
    }



    /**
     * Ce controller permet de crée un jeu
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/mes-jeux/ajouter', name: 'game_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')] // Cette page est accessible si on est connecter
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $game = new Game(); // Initialisation de la variable $game avec l'entité Game
        $form = $this->createForm(GameType::class, $game); // Initialisation du formulaire

        $form->handleRequest($request); // Appel de handleRequest

        //Si le forumaire a été soumis et qu'il est valide alors
        if ($form->isSubmitted() && $form->isValid()) {

            $game = $form->getData(); // Récupération des données du formulaire
            $game->setUser($this->getUser()); // Le jeu est relié à l'utilisateur connecter

            $manager->persist($game); //Persist qui est prêt à envoyer les données dans la BD (like commit)
            $manager->flush(); // Envoi des données à la DB (like push)

            // Message flash une fois que le jeu a été ajouter
            $this->addFlash(
                'success',
                'Le jeu a bien été ajouter !'
            );

            //Redirection vers la page des jeux
            return $this->redirectToRoute('game_index');
        }


        return $this->render(
            'pages/game/new.html.twig',
            [
                'form' => $form->createView() // Passage du formulaire à la vue
            ]
        );
    }


    /**
     * Ce controlleur permet de modifier un jeu
     */
    #[Route('/mes-jeux/modifier/{id}', name: 'game_edit', methods: ['GET', 'POST'])]
    #[Security("is_granted('ROLE_USER') and user === game.getUser()")] // Uniquement pour les utilisateurs & Utilisateur courant
    public function edit(Game $game, Request $request, EntityManagerInterface $manager): Response
    {

        $form = $this->createForm(GameType::class, $game); // Initialisation du formulaire

        $form->handleRequest($request); // Appel de handleRequest

        //Si le forumaire a été soumis et qu'il est valide alors
        if ($form->isSubmitted() && $form->isValid()) {

            $game = $form->getData(); // Récupération des données du formulaire

            $manager->persist($game); //Persist qui est prêt à envoyer les données dans la BD (like commit)
            $manager->flush(); // Envoi des données à la DB (like push)

            // Message flash une fois que le jeu a été modifier
            $this->addFlash(
                'success',
                'Le jeu a bien été modifier !'
            );

            //Redirection vers la page des jeux
            return $this->redirectToRoute('game_index');
        }


        return $this->render(
            'pages/game/edit.html.twig',
            [
                'form' => $form->createView() // Passage du formulaire à la vue
            ]
        );
    }


    /**
     * Ce controlleur permet de supprimer un jeu
     */
    #[Route('mes-jeux/supprimer/{id}', name: 'game_delete', methods: ['GET'])]
    #[Security("is_granted('ROLE_USER') and user === game.getUser()")] // Uniquement pour les utilisateurs & Utilisateur courant
    public function delete(Game $game, EntityManagerInterface $manager): Response
    {


        $manager->remove($game); // Utilisation de la fonction remove()
        $manager->flush(); // Envoi des données

        $this->addFlash(
            'success',
            'Le jeu a bien été supprimer !'
        );

        return $this->redirectToRoute('game_index'); // Redirection une fois le jeu supprimer
    }
}
