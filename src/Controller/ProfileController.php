<?php
// src/Controller/ProfileController.php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profile", name="profile_edit")
     */
    public function edit(Request $request): Response
    {
        // 🔐 Only logged-in users can access this
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->getUser(); // ✅ gets current User object

        // Create form, pre-filled with current user data
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        // Handle form submission
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User $user */
            $user = $form->getData();

            // Handle avatar upload
            $avatarFile = $form->get('avatarFile')->getData();
            if ($avatarFile) {
                $user->setAvatarFile($avatarFile); // ← VichUploader will handle the rest
            }

            // Save to DB
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush(); // updateUser — no need for persist() since user is managed

            $this->addFlash('success', 'Your profile has been updated!');
            return $this->redirectToRoute('profile_edit');
        }

        return $this->render('profile/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}