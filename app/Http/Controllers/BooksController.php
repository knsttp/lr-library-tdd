<?php

namespace App\Http\Controllers;

use App\Book;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    public function __construct() {
        $this->middleware('auth')->except(['index','show']);
    }    
    
    public function validateRequest() {
        return request()->validate([
            'title' => 'required',
            'author_id' => 'required'
        ]);
    }
    
    public function validateCheckoutRequest() {
        return request()->validate([
            'user_id' => 'required',
            'book_id' => 'required'
        ]);
    }
    
    public function index() {
       $books = Book::all(); 
       return view('books.index',compact('books'));
    }
    
    public function show(Book $book) {
       return view('books.show',compact('book'));
    }
    
    public function store(){
        $book = Book::create($this->validateRequest());
        return redirect('/books/'.$book->id);
    }
    
    public function update(Book $book) {
        $book->update($this->validateRequest());
        return redirect('/books/'.$book->id);
    }
    
    public function destroy(Book $book) {
        $book->delete();
        return redirect('/books');
    }
    
    // public function checkout(Book $book, User $user){
    public function checkout(){
        $user_id = request()->input('user_id');
        $book_id = request()->input('book_id');
        $user = User::find($user_id);
        $book = Book::find($user_id);
        $book->checkout($user);
        return redirect('/home');
    }
    
    public function checkin(Book $book, User $user){
        try{
            $book->checkin($user);
        } catch(\Exception $e){
            return response([],404);
        }
        return redirect('/books');
    }
    
}
