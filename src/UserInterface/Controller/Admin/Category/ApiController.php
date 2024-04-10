<?php

namespace App\UserInterface\Controller\Admin\Category;

use App\Domain\Category\Gateway\CategoryGatewayInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    #[Route('/admin/api/categories', name: 'api_category')]
    public function getTagsApi(CategoryGatewayInterface $categoryGateway): JsonResponse
    {
        return $this->json($categoryGateway->getAll(), 200, [], ['groups' => 'main']);
    }
}
