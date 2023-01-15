<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;
use Hash;
class UserImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
            'firstname'     => $row[0],
            'lastname'     => $row[1],
            'name'     => $row[0].' '.$row[1],
            'username'     => $row[0].' '.$row[1],
            'email'    => $row[2], 
            'gender'    => $row[4], 
            'empid'    => $row[6], 
            'password' => Hash::make($row[3]),
            'status' => '1',
            'verified' => '1',
            'role_id' =>  $row[5],
        ]);
        return $user;
    }

   
}
