<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Support\Facades\Auth;

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
    
    public function checkout(Book $book){
        $user = Auth::user();
        $book->checkout($user);
        return redirect('/books');
    }
    
    public function checkin(Book $book){
        $user = Auth::user();
        try{
            $book->checkin($user);
        } catch(\Exception $e){
            return response([],404);
        }
        return redirect('/books');
    }
    
}
