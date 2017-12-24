<?php

declare(strict_types=1);

namespace Bookshelf\Controller\User;

use Bookshelf\Form\ChangePasswordModel;
use Bookshelf\Form\ChangePasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class ChangePasswordController extends Controller {
    public function handleAction(Request $request, EncoderFactoryInterface $factory) {
        $user = $this->getUser();

        $form = $this->createForm(ChangePasswordType::class, new ChangePasswordModel());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->updatePassword($factory, $form->getData()->getNewPassword());
            $this->addFlash('success', 'Your password has been updated!');

            return $this->redirect($this->generateUrl('index'));
        } elseif ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash('danger', 'There was an problem with your submission!');
        }

        return $this->render('user/change_password.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }

    private function updatePassword(EncoderFactoryInterface $factory, $newPassword) {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $encoder = $factory->getEncoder($user);

        $hash = $encoder->encodePassword($newPassword, null);

        $user->setPassword($hash);
        $em->persist($user);
        $em->flush();
    }
}
