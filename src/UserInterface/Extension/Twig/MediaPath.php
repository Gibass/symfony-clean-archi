<?php

namespace App\UserInterface\Extension\Twig;

use App\Domain\Article\Entity\Image;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class MediaPath extends AbstractExtension
{
    public function __construct(private string $uploadPath)
    {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('mediaPath', [$this, 'mediaPath']),
        ];
    }

    public function mediaPath(Image $media): string
    {
        return $this->uploadPath . $media->getPath();
    }
}
