<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends BaseResource
{
    public function __construct($resource, $errorCode, $errorMessage)
    {
        parent::__construct($resource, $errorCode, $errorMessage);
    }

}
