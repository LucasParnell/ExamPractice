@extends('layouts.login')
@section('title', "Logged Out")

@section('content')

@section('back-redir', 'login.php')

<!--Form-->
<div class="d-flex flex-column">
    <div class="container border rounded shadow-lg text-light mw-100 mh-100 h-50 w-50 mt-5">
        <h3 class="display-6 text-center mt-2">Thank You,</h3>
        <h3 class="lead text-center">You have logged out successfully! </h3>
        <div class="text-center mt-3 mb-4">
            <button class="btn btn-primary" data-redir-loc="index.php">Home Page</button>
        </div>
    </div>
</div>



@endsection