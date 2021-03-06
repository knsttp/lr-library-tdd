@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ $book->title }}
                    <a href="{{ url('/books') }}" class="btn btn-primary float-right">Return</a>
                </div>
                <div class="card-body">
                    Author: {{ $book->author->name }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
