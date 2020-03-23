<?php

namespace App\Http\Controllers;

use App\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use App\User;
use App\Book;

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
            $booksEverCheckedOut = Book::doesntHave('reservations')->get();
            $booksCheckedOutNotIn = Book::whereHas('reservations', function(Builder $q){
                $q->whereNotNull('checked_out_at')->whereNotNull('checked_in_at');
            })->get();
            $books = $booksEverCheckedOut->merge($booksCheckedOutNotIn);
            $users = User::all();

            $reservations = Reservation::with('book')->with('user')->whereNull('checked_in_at')->orderBy('checked_in_at','asc')->get();
            return view('admin-dashboard/home', compact('reservations', 'books', 'users'));
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
