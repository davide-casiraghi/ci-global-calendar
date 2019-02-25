<?php

namespace App\Http\Resources;

use App\Country;

use Illuminate\Http\Resources\Json\JsonResource;

class Continent extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'active_countries' => Country::getActiveCountriesByContinent($this->id),
        ];
    }
}
