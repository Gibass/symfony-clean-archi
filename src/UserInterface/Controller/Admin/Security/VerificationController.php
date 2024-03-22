<?php

namespace App\UserInterface\Controller\Admin\Security;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VerificationController extends AbstractController
{
    #[Route('/register/not-verified', name: 'user_not_verified')]
    public function notVerified(): Response
    {
        return $this->render('admin/pages/security/not-verified.html.twig');
    }
}