<?php
namespace App\UserInterface\Controller\Admin\Article;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
class CreateController extends AbstractController
{
    #[Route('/admin/create/article', name: 'create_article_admin')]
    public function createArticle(): Response
    {
        return $this->render('admin/pages/articles/create.html.twig');
    }
}