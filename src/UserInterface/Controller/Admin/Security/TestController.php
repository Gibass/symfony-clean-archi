<?php

namespace App\UserInterface\Controller\Admin\Security;

use App\Infrastructure\Adapter\Helper\JWTToken;
use App\Infrastructure\Adapter\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/test', name: 'test')]
    public function test(UserRepository $repository, JWTToken $JWTToken): void
    {
        $user = $repository->findOneBy(['email' => 'test@test.com']);
        $token = $JWTToken->generateUserToken($repository->convert($user));

        dd($token);
    }
}
