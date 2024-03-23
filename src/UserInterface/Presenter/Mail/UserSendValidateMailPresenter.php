<?php

namespace App\UserInterface\Presenter\Mail;

use App\Domain\Security\Presenter\UserSendValidatePresenterInterface;
use App\Domain\Security\Response\UserSendValidateResponse;
use App\Domain\Shared\Mailer\MailStructureInterface;
use App\Infrastructure\Adapter\Mailer\MailStructure;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

class UserSendValidateMailPresenter implements UserSendValidatePresenterInterface
{
    public function __construct(private RouterInterface $router)
    {
    }

    public function present(UserSendValidateResponse $response): MailStructureInterface
    {
        $email = (new TemplatedEmail())
             ->from('unreplay@compte.com')
             ->to($response->getUser()->getEmail())
             ->subject('Activate your account on LogBook')
             ->htmlTemplate('admin/emails/register-validation.html.twig')
             ->context([
                 'user' => $response->getUser(),
                 'link' => $this->router->generate(
                     'user_verify',
                     ['token' => $response->getToken()],
                     UrlGeneratorInterface::ABSOLUTE_URL
                 ),
             ])
        ;

        return new MailStructure($email);
    }
}
