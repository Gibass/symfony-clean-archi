<?php

namespace App\UserInterface\Controller\Admin\Article;

use App\Domain\Article\Gateway\ArticleGatewayInterface;
use App\Domain\CRUD\Exception\CrudEntityNotFoundException;
use App\Domain\CRUD\Request\DeleteRequest;
use App\Domain\CRUD\UseCase\Delete;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Attribute\Route;

class DeleteController extends AbstractController
{
    #[Route('/admin/delete/article/{id}', name: 'admin_delete_article')]
    public function delete(int $id, Delete $delete, ArticleGatewayInterface $gateway): RedirectResponse
    {
        $deleteRequest = new DeleteRequest($id);

        try {
            if ($delete->execute($deleteRequest, $gateway)) {
                $this->addFlash('success', 'The article have been deleted successfully');
            } else {
                $this->addFlash('error', 'An error was occurred during deleting article');
            }
        } catch (CrudEntityNotFoundException $e) {
            $this->addFlash('error', 'The article with id ' . $id . ' doesn\'t exist');
        }

        return $this->redirectToRoute('admin_listing_articles');
    }
}
