<?php

namespace App\UserInterface\Presenter\Web;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;

class RegisterPresenterHTML extends AbstractWebPresenter
{
    public function present(FormInterface $form): Response
    {
        return $this->render('admin/pages/security/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
