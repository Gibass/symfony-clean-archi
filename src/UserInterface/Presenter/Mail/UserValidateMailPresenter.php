<?php

namespace App\UserInterface\Presenter\Mail;

use App\Domain\Security\Presenter\UserValidatePresenterInterface;
use App\Domain\Security\Response\UserValidateResponse;
use App\Domain\Shared\Mailer\MailStructureInterface;
use App\Infrastructure\Adapter\Mailer\MailStructure;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class UserValidateMailPresenter implements UserValidatePresenterInterface
{
    public function present(UserValidateResponse $response): MailStructureInterface
    {
        $email = (new TemplatedEmail())
             ->from('unreplay@compte.com')
             ->to($response->getUser()->getEmail())
             ->subject('Activate your account on LogBook')
             ->htmlTemplate('admin/emails/register-validation.html.twig')
             ->context([
                 'user' => $response->getUser(),
                 'link' => 'https://link.com',
             ])
        ;

        return new MailStructure($email);
    }
}
