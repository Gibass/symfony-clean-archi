<?php

namespace App\Infrastructure\Adapter\Mailer;

use App\Domain\Shared\Mailer\MailStructureInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

readonly class MailStructure implements MailStructureInterface
{
    public function __construct(private TemplatedEmail $email)
    {
    }

    public function getRawMessage(): TemplatedEmail
    {
        return $this->email;
    }
}
