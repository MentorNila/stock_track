<?php

namespace App\Modules\Company\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
