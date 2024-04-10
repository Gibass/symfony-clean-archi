<?php

namespace App\UserInterface\Controller\Admin\Category;

use App\Domain\Category\Gateway\CategoryGatewayInterface;
use App\Domain\CRUD\Exception\CrudEntityNotFoundException;
use App\Domain\CRUD\Request\DeleteRequest;
use App\Domain\CRUD\UseCase\Delete;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;

class DeleteController extends AbstractController
{
    #[Route('/admin/delete/category/{id}', name: 'admin_delete_category', requirements: ['id' => Requirement::DIGITS])]
    public function delete(int $id, Delete $delete, CategoryGatewayInterface $gateway): RedirectResponse
    {
        $request = new DeleteRequest($id);
        try {
            if ($delete->execute($request, $gateway)) {
                $this->addFlash('success', 'The category have been deleted successfully');
            } else {
                $this->addFlash('error', 'An error was occurred during deleting category');
            }
        } catch (CrudEntityNotFoundException $e) {
            $this->addFlash('error', 'The category with id ' . $id . ' doesn\'t exist');
        }

        return $this->redirectToRoute('admin_listing_categories');
    }
}
