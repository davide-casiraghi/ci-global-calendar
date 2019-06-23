<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use DavideCasiraghi\LaravelEventsCalendar\Models\EventVenue;
use DavideCasiraghi\LaravelEventsCalendar\Models\EventCategory;

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
        $venue = EventVenue::find($this->venue_id);

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'website_event_link' => $this->website_event_link,
            'facebook_event_link' => $this->facebook_event_link,
            'category' => EventCategory::getCategoryName($this->category_id),
            'teachers' => $this->teachers()->pluck('name', 'id'),
            'venue' => $venue->name,
            'start_repeat' => $this->start_repeat,
            'end_repeat' => $this->end_repeat,
            'image' => $this->image,
            'contact_email' => $this->contact_email,
            'repeat_type' => $this->repeat_type,
            'repeat_until' => $this->repeat_until,
            'repeat_monthly_on' => $this->repeat_monthly_on,
            'city' => $this->sc_city_name,
            'venue_address' => $venue->address,
            'zip_code' => $venue->zip_code,
        ];
    }
}
