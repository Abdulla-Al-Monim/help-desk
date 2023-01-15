<?php

namespace App\Models\Ticket;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ticket\Ticket;
use App\Models\Ticketnote;
use App\Models\Ticket\Category;
use App\Models\Ticket\Comment;
use App\Models\User;
class Ticket extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function ticketnote()
    {
        return $this->hasMany(Ticketnote::class, 'ticket_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function toassignuser()
    {
        return $this->belongsTo(User::class, 'toassignuser_id');
    }
    public function myassignuser()
    {
        return $this->belongsTo(User::class, 'myassignuser_id');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class)->latest('created_at');
    }


}
