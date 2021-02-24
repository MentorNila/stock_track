<?php

namespace App\Modules\Company\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
