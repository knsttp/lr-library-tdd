<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Book extends Model
{
    protected $fillable = ['title','author_id'];
    
    public function checkout(User $user) {
        $reservation = $this->reservations()->where('user_id', $user->id)->first();
        
        if($reservation){
            throw new \Exception();
        }
        
        $this->reservations()->create([
            'user_id' => $user->id,
            'checked_out_at' => now(), 
        ]);
    }
    
    public function checkin(User $user) {
        $reservation = $this->reservations()->where('user_id', $user->id)
             ->whereNotNull('checked_out_at')
             ->whereNull('checked_in_at')
             ->first();
        
        if(is_null($reservation)){
            throw new \Exception();
        }
        
        $reservation->update([
            'checked_in_at' => now(), 
        ]);
    }
    
    public function canbecheckout(User $user) {
        // no reservation 
        $has_reservation = $this->reservations()->where('user_id', $user->id)->first();
        
        // already checkin
        $checkin = $this->reservations()->where('user_id', $user->id)
             ->whereNotNull('checked_out_at')
             ->whereNotNull('checked_in_at')
             ->first();
        
        return (!$has_reservation || $checkin) ? true : false;
        
    }

    public function users(){
        return $this->belongsToMany('App\User', 'reservations');
    }
    
    public function reservations() {
        return $this->hasMany(Reservation::class);
    }
    
    public function author() {
        return $this->belongsTo(Author::class);
    }

}
