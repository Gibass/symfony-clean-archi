<?php

namespace App\Domain\CRUD\UseCase;

use App\Domain\CRUD\Gateway\CrudGatewayInterface;
use App\Domain\CRUD\Request\UpdateRequest;
use App\Domain\CRUD\Response\UpdateResponse;
use App\Domain\CRUD\Validator\CrudEntityValidatorInterface;
use Assert\AssertionFailedException;

class Update
{
    /**
     * @throws AssertionFailedException
     */
    public function execute(UpdateRequest $request, CrudGatewayInterface $gateway, CrudEntityValidatorInterface $validator): UpdateResponse
    {
        $validator->validate($request->getPostedData());

        $entity = $gateway->update($request->getPostedData());

        return new UpdateResponse($entity);
    }
}
