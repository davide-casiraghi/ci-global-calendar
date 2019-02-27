<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use App\EventCategory;
use App\EventVenue;

class Event extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'website_event_link' => $this->website_event_link,
            'facebook_event_link' => $this->facebook_event_link,
            'category' => EventCategory::getCategoryName($this->category_id),
            'teachers' => $this->teachers()->pluck('name','id'),
            'venue' => EventVenue::getVenueName($this->venue_id),
        ];
    }
}
