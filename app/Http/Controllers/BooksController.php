<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;

class BooksController extends Controller
{
    public function validateRequest() {
        return request()->validate([
            'title' => 'required',
            'author' => 'required'
        ]);
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
    
}
