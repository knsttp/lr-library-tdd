<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [ 'user_id', 'book_id', 'checked_out_at', 'checked_in_at' ];
}
