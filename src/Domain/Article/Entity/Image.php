<?php

namespace App\Domain\Article\Entity;

class Image extends Media
{
    private ?string $path = null;

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(?string $path): Image
    {
        $this->path = $path;

        return $this;
    }
}
