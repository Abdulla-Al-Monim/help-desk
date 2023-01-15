<?php

namespace App\Exports\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;

class UserImport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::all();
    }
}
