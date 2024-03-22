<?php

namespace App\Infrastructure\Test\Adapter\Mailer;

use App\Domain\Shared\Mailer\MailerInterface;
use App\Domain\Shared\Mailer\MailStructureInterface;

class MailerTest implements MailerInterface
{
    public function sendMail(MailStructureInterface $mailStructure): void
    {
        // TODO: Implement sendMail() method.
    }
}
