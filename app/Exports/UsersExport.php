<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return User::join('countries', 'users.country_id', '=', 'countries.id')
                    ->select('users.id', 'users.name as userName', 'countries.name as countryName', 'users.email', 'users.created_at', 'users.description')->get();
    }
}
