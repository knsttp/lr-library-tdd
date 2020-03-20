<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Book;
use App\User;

class Reservation extends Model
{
    protected $fillable = [ 'user_id', 'book_id', 'checked_out_at', 'checked_in_at' ];

    public function book() {
        return $this->belongsTo(Book::class);
    }    

    public function user() {
        return $this->belongsTo(User::class);
    }    
}
