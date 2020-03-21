<?php

namespace App\Http\Controllers;

use App\Reservation;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        
        if( $user->is_admin ) {
            $reservations = Reservation::with('book')->with('user')->whereNull('checked_in_at')->orderBy('checked_in_at','asc')->get();
            return view('admin-dashboard/home', compact('reservations'));
        } else {
            $reservations = Reservation::with('book')->where('user_id', '=', $user->id)->whereNull('checked_in_at')->orderBy('checked_in_at','asc')->get();
            return view('user-dashboard/home', compact('reservations'));
        }

    }
    
    public function history(){
        $user = Auth::user();
        $reservations = Reservation::with('book')->where('user_id', '=', $user->id)->latest()->get();
        return view('user-dashboard/reservation-history', compact('reservations'));
    }

}
