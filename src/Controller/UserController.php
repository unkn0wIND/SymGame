<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\UserPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class UserController extends AbstractController
{
    #[Route('/utilisateur/edition/{id}', name: 'user_edit', methods: ['GET', 'POST'])]
    #[Security("is_granted('ROLE_USER') and user === currentUser ")] //  Que l'utilisateur courant
    public function edit(User $currentUser, Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $hasher): Response
    {


        // On crée le formulaire
        $form = $this->createForm(UserType::class, $currentUser);

        $form->handleRequest($request); // Appel d'handleRequest

        if ($form->isSubmitted() && $form->isValid()) { // Vérifier si le formulaire est soumis && si il est valide

            if ($hasher->isPasswordValid($currentUser, $form->getData()->getPlainPassword())) { // Vérifier si le mot de passe hasher est le même que le mot de passe inscrit

                $user = $form->getData(); // On récupère les données de l'utilistateur

                $manager->persist($user); // On persist les données
                $manager->flush(); // On push les données

                // Message de success
                $this->addFlash(
                    'success',
                    'Votre compte a bien été mis à jour !'
                );

                return $this->redirectToRoute('game_index'); // Redirection vers la page des jeux si le compte a bien été mis à jour  

            } else {
                // Message d'alerte
                $this->addFlash(
                    'warning',
                    'Le mot de passe renseigné est incorrect !'
                );
            }
        }

        return $this->render('pages/user/edit.html.twig', [
            'form' => $form->createView() // Renvoi du formulaire à la vue
        ]);
    }


    #[Route('/utilisateur/edition-mot-de-passe/{id}', name: 'user_pass_edit', methods: ['GET', 'POST'])]
    #[Security("is_granted('ROLE_USER') and user === currentUser ")] // Que l'utilisateur courant
    public function editPassword(User $currentUser, Request $request, UserPasswordHasherInterface $hasher, EntityManagerInterface $manager): Response
    {

        $form = $this->createForm(UserPasswordType::class); // Création du formulaire

        $form->handleRequest($request); // Appel de Request

        if ($form->isSubmitted() && $form->isValid()) { // SI le formulaire est soumis && valide
            if ($hasher->isPasswordValid($currentUser, $form->getData()['plainPassword'])) { // SI le mot de passe est valide alors on récupère PlainPassword

                $currentUser->setPassword($hasher->hashPassword($currentUser, $form->getData()['newPassword'])); // SET le nouveau mot de passe

                $manager->persist($currentUser);
                $manager->flush();



                // Message de succes
                $this->addFlash(
                    'success',
                    'Le mot de passe a bien été modifié !'
                );

                return $this->redirectToRoute('game_index');
            } else { // SINON

                // Message d'alerte
                $this->addFlash(
                    'warning',
                    'Le mot de passe renseigné est incorrect !'
                );
            }
        }



        return $this->render('pages/user/edit_password.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
