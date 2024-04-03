<?php

namespace App\Domain\CRUD\Request;

use App\Domain\CRUD\Entity\PostedData;

class UpdateRequest
{
    private PostedData $postedData;

    public function __construct(array $data)
    {
        $this->postedData = new PostedData($data);
    }

    public function getPostedData(): PostedData
    {
        return $this->postedData;
    }
}