<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        $reservations = Reservation::with('book')->where('user_id', '=', $user->id)->whereNull('checked_in_at')->orderBy('checked_in_at','asc')->get();
        return view('user-dashboard/home', compact('reservations'));
    }
    
    public function history(){
        $user = Auth::user();
        $reservations = Reservation::with('book')->where('user_id', '=', $user->id)->latest()->get();
        return view('user-dashboard/reservation-history', compact('reservations'));
    }

}
