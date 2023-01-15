<?php

namespace App\Models\Ticket;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ticket\Ticket;
use App\Models\Customer;
use App\Models\User;

class Comment extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function ticket()
    {
    return $this->belongsTo(Ticket::class);
    }
    public function cust()
    {
        return $this->belongsTo(Customer::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
