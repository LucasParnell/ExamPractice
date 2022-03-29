@section('task')

@foreach($tasks as $task)

<div class="px-3 py-2 m-2 rounded border item-box" data-task-id="{{$task["id"]}}">
  <span><span class="fs-4 item-box-name">{{$task["name"]}}</span> - <a class="fw-bold fs-6" style="text-decoration: none; cursor: pointer;"> {{$task["setBy"]}} </a></span>
  <span style="float: right;"><span class="text-primary fs-6 fw-light">{{$task["points"]}}</span> points</span>
  <br>
  <span>{{$task["description"]}}</span>
  <span style="float: right;">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-alarm mb-1" viewBox="0 0 16 16">
      <path d="M8.5 5.5a.5.5 0 0 0-1 0v3.362l-1.429 2.38a.5.5 0 1 0 .858.515l1.5-2.5A.5.5 0 0 0 8.5 9V5.5z"/>
      <path d="M6.5 0a.5.5 0 0 0 0 1H7v1.07a7.001 7.001 0 0 0-3.273 12.474l-.602.602a.5.5 0 0 0 .707.708l.746-.746A6.97 6.97 0 0 0 8 16a6.97 6.97 0 0 0 3.422-.892l.746.746a.5.5 0 0 0 .707-.708l-.601-.602A7.001 7.001 0 0 0 9 2.07V1h.5a.5.5 0 0 0 0-1h-3zm1.038 3.018a6.093 6.093 0 0 1 .924 0 6 6 0 1 1-.924 0zM0 3.5c0 .753.333 1.429.86 1.887A8.035 8.035 0 0 1 4.387 1.86 2.5 2.5 0 0 0 0 3.5zM13.5 1c-.753 0-1.429.333-1.887.86a8.035 8.035 0 0 1 3.527 3.527A2.5 2.5 0 0 0 13.5 1z"/>
    </svg>
    <small class="@if($task["overdue"]) text-danger @else text-primary @endif fs-6 fw-light small">{{$task["dueBy"]}}</small></span>
  <br>

</div>

<div class="modal fade text-dark" id="taskInfoModal" tabindex="-1" aria-hidden="true" data-task-id="{{$task["id"]}}">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="taskInfoTitle">Would you like to start this task?</h2>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body d-flex flex-column">
        <h3 class="display-6">{{$task["name"]}}</h3>
        <span class="text-secondary fw-bold">Description: <span class="fw-light">{{$task["description"]}}</span></span>
        <span class="text-secondary fw-bold">Due date: <span class="fw-light">{{$task["dueBy"]}}</span></span>
        <span class="text-secondary fw-bold"><span class="fw-light text-primary">{{$task["points"]}}</span> Points</span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="taskInfoStartTaskButton">Start Task</button>
      </div>
    </div>
  </div>
</div>


@endforeach

@if(!count($tasks))

<div class="px-3 py-2 m-2 rounded border">
  <div class="fs-4 text-wrap" style="width: 20rem">You have no set tasks.</div>

</div>
@endif

@endsection

@section('messages')

<div class="px-3 py-2 m-2 rounded border">
  <div class="fs-4 text-wrap" style="width: 20rem">You have no new feedback.</div>

</div>

@endsection


@section('leaderboard')

<div class="px-3 py-2 m-2 rounded border">
  <span class="fs-4">Your class leaderboard is empty!</span>
</div>

@endsection



@section('statustoast')
<div class="position-fixed bottom-0 end-0 p-3 text-dark" style="z-index: 11">
  <div id="status-toast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
      <strong class="me-auto">Status</strong>
      <small>Now</small>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div id="status-toast-content" class="toast-body">
      Content
    </div>
  </div>
</div>
@endsection