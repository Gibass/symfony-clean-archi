<?php

namespace App\Infrastructure\Adapter\Mailer;

use App\Domain\Shared\Mailer\MailerInterface;
use App\Domain\Shared\Mailer\MailStructureInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface as SymfonyMailer;

readonly class Mailer implements MailerInterface
{
    public function __construct(private SymfonyMailer $mailer)
    {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendMail(MailStructureInterface $mailStructure): void
    {
        $this->mailer->send($mailStructure->getRawMessage());
    }
}
