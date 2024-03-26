<?php

namespace App\Domain\CRUD\UseCase;

use App\Domain\CRUD\Gateway\CrudGatewayInterface;
use App\Domain\CRUD\Request\CreateRequest;
use App\Domain\CRUD\Response\CreateResponse;
use App\Domain\CRUD\Validator\CrudEntityValidatorInterface;
use Assert\AssertionFailedException;

class Create
{
    /**
     * @throws AssertionFailedException
     */
    public function execute(
        CreateRequest $request,
        CrudGatewayInterface $gateway,
        CrudEntityValidatorInterface $validator
    ): CreateResponse {
        $validator->validate($request->getPostedData());

        $entity = $gateway->create($request->getPostedData());

        return new CreateResponse($entity);
    }
}
