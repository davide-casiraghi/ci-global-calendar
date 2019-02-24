<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DonationOffer extends Model
{
    protected $fillable = [
        'name', 'surname', 'email', 'country_id', 'contact_trough_voip', 'language_spoken', 'offer_kind', 'gift_kind', 'gift_description', 'volunteer_kind', 'volunteer_description', 'other_description', 'suggestions', 'status'
    ];
}
