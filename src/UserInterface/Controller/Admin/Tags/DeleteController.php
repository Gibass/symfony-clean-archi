<?php

namespace App\UserInterface\Controller\Admin\Tags;

use App\Domain\CRUD\Exception\CrudEntityNotFoundException;
use App\Domain\CRUD\Request\DeleteRequest;
use App\Domain\CRUD\UseCase\Delete;
use App\Domain\Tag\Gateway\TagGatewayInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Requirement\Requirement;

class DeleteController extends AbstractController
{
    #[Route('/admin/delete/tag/{id}', name: 'admin_delete_tag', requirements: ['id' => Requirement::DIGITS])]
    public function delete(int $id, Delete $delete, TagGatewayInterface $gateway): RedirectResponse
    {
        $request = new DeleteRequest($id);
        try {
            if ($delete->execute($request, $gateway)) {
                $this->addFlash('success', 'The tag have been deleted successfully');
            } else {
                $this->addFlash('error', 'An error was occurred during deleting tag');
            }
        } catch (CrudEntityNotFoundException $e) {
            $this->addFlash('error', 'The tag with id ' . $id . ' doesn\'t exist');
        }

        return $this->redirectToRoute('admin_listing_tags');
    }
}
