<!DOCTYPE html>


@extends('layouts.personal')

@include('modules.dashwidgets')

 
@section('title', 'Dashboard')



@section('content')

<div class="d-flex justify-content-center align-items-start flex-wrap">
  <div class="bg-body text-dark d-inline-flex flex-column justify-content-center border rounded-3 shadow shadow-lg mx-3 my-2 overflow-auto" style="min-width: 25rem">
    <span class="display-6 text-center px-4 py-2" id="tasksContainer">Tasks</span>
    @yield('task')
  </div>
  <div class="bg-body text-dark d-inline-flex flex-column justify-content-center border rounded-3 shadow shadow-lg mx-3 my-2 overflow-auto" style="min-width: 25rem">
    <span class="display-6 text-center px-4 py-2" id="feedbackContainer">Feedback</span>
    @yield('messages')
  </div>
  <div class="bg-body text-dark d-inline-flex flex-column justify-content-center border rounded-3 shadow shadow-lg mx-3 my-2 overflow-auto" style="min-width: 25rem">
    <span class="display-6 text-center px-4 py-2" id="leaderboardContainer">Leaderboard</span>
    @yield('leaderboard')
  </div>
  </div>

  <!--Modal space-->
  <div id="modal-space"></div>

  <!--Loading screen-->
  <div id="page-load">
      <div class="fixed-top mw-100 w-100 mh-100 h-100 bg-dark d-flex justify-content-center align-items-center" style="opacity: 0.8" id="loading-screen">
        <div class="spinner-border text-primary" style="width: 5rem; height: 5rem;" role="status"></div>
    </div>
  </div>

<!--Status toast--> 

@if($debug)
  @yield("statustoast")
@endif

@endsection



