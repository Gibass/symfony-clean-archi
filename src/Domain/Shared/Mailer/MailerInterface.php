<?php

namespace App\Domain\Shared\Mailer;

interface MailerInterface
{
    public function sendMail(MailStructureInterface $mailStructure);
}
