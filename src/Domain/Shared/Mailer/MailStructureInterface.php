<?php

namespace App\Domain\Shared\Mailer;

interface MailStructureInterface
{
    public function getRawMessage(): mixed;
}
