<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Author;

class AuthorController extends Controller
{
    public function validatedRequest() {
        return request()->validate([
           'name' => 'required', 
           'dob' => 'required' 
        ]);
    }
    
    public function show(Author $author){
        return view('author.show', compact('author'));
    }
    
    public function store() {
        $author = Author::create($this->validatedRequest());
        return redirect('/author/'.$author->id);
    }
}
