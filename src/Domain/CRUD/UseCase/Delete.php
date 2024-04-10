<?php

namespace App\Domain\CRUD\UseCase;

use App\Domain\CRUD\Exception\CrudEntityNotFoundException;
use App\Domain\CRUD\Gateway\CrudGatewayInterface;
use App\Domain\CRUD\Request\DeleteRequest;

class Delete
{
    /**
     * @throws CrudEntityNotFoundException
     */
    public function execute(DeleteRequest $request, CrudGatewayInterface $gateway): bool
    {
        $entity = $gateway->getByIdentifier($request->getIdentifier());

        if (!$entity) {
            throw new CrudEntityNotFoundException();
        }

        return $gateway->delete($entity);
    }
}
