@section('teachingGroups')
@foreach($teachingGroups->getGroups() as $teachingGroup)

<div class="px-3 py-2 m-2 rounded border item-box group-item-box" data-teachingGroup-id="{{$teachingGroup["ID"]}}">
<span class="fs-6">{{$teachingGroup["GroupName"]}}</span>
<span style="float: right;"><span class="fs-6 text-primary fw-light">{{count($teachingGroups->getStudents($teachingGroup["ID"]))}}</span> students</span>
</div>

<div class="modal fade text-dark" id="teachingGroupModal" tabindex="-1" aria-hidden="true" data-teachingGroup-id="{{$teachingGroup["ID"]}}">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="teachingGroupTitle">Manage Students</h2>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body d-flex flex-column">

          <!--Manage switch-->
          <span class="d-inline-flex justify-content-between my-3">
            <span class="mt-1">Displaying {{count($teachingGroups->getStudents($teachingGroup["ID"]))}} students</span>
            <button class="btn btn-outline-success text-right btn-manageGroups" data-bs-toggle="button">Manage</button>
          </span>

          <!--Add by email-->
          <div class="input-group mb-3 group-manage">
            <input type="email" class="form-control group-studentBox" placeholder="Student Email" name="studentEmail" aria-label="Email" aria-describedby="basic-addon1">
            <input type="button" class="btn btn-primary btn-addStudentToGroup" name="addStudentButton" value="Add">
          </div>
        
        
          <!--Students List-->
          <div class="list-group manage-group-list">
            @foreach($teachingGroups->getStudents($teachingGroup["ID"]) as $student)
              <div class="d-inline-flex align-items-center input-group mb-1" data-student-id={{$student["ID"]}}>
                <a href="#" class="list-group-item list-group-item-action form-control group-item-student-name">{{$student["StudentName"]}}</a>
                <!--Remove student button-->
                <button class="btn btn-outline-danger btn-sm group-manage btn-removeStudentFromGroup">
                  <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                  </svg>
                </button>
              </div>
            @endforeach
          </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success group-manage btn-sendForm" data-bs-dismiss="modal">Finalize</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-redir-loc="dashboard.php">Close</button>
          </div>
      </div>
  </div>
</div>

@endforeach

@if(!count($teachingGroups->getGroups()))

<div class="px-3 py-2 m-2 rounded border">
  <span class="fs-4">You have no teaching groups.</span>
</div>

@endif

<script id="group-list-item" type="text/html">

  <div class="d-inline-flex align-items-center input-group mb-1">
    <a href="#" class="list-group-item list-group-item-action form-control group-item-student-name">Name</a>
    <!--Remove student button-->
    <button class="btn btn-outline-danger btn-sm group-manage btn-removeStudentFromGroup">
      <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
      </svg>
    </button>
  </div>

</script>

<!--New Group Button-->
<div class="p-2">
  <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#newGroupModal">New Group</button>
</div>

<!--New Group Modal-->
<div class="modal fade" id="newGroupModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">New Group</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="text" class="form-control" id="newGroupName" placeholder="Group Name">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="btn-newGroupSave">Save changes</button>
      </div>
    </div>
  </div>
</div>

@endsection
