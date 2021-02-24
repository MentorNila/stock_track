<?php

namespace App\Modules\Filing\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FilingDataResource extends JsonResource
{
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
