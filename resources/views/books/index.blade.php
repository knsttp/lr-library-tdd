@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <table class="table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                    </tr>
                </thead>    
                <tbody>
                @foreach ($books as $book)
                <tr>
                    <td><a href="{{ url('/books/'.$book->id) }}">{{ $book->title }}</a></td>
                    <td>{{ $book->author->name }}</td>
                </tr>
                @endforeach
                </tbody>    
            </table>
        </div>
    </div>
</div>
@endsection
