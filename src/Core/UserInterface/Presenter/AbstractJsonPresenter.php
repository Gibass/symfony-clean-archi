<?php

declare(strict_types=1);

namespace App\Core\UserInterface\Presenter;

use Symfony\Component\HttpFoundation\JsonResponse;

class AbstractJsonPresenter extends AbstractPresenter
{
    protected function json(mixed $data, int $status = 200, array $headers = [], array $context = []): JsonResponse
    {
        $json = $this->getService('serializer')->serialize($data, 'json', array_merge([
            'json_encode_options' => JsonResponse::DEFAULT_ENCODING_OPTIONS,
        ], $context));

        return new JsonResponse($json, $status, $headers, true);
    }
}
