<?php

namespace App\UserInterface\Controller\Admin\Tags;

use App\Domain\Tag\Gateway\TagGatewayInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class APIController extends AbstractController
{
    #[Route('/admin/api/tags', name: 'api_tags')]
    public function getTagsApi(TagGatewayInterface $tagGateway): JsonResponse
    {
        return $this->json($tagGateway->getAll(), 200, [], ['groups' => 'main']);
    }
}
