<div class="modal fade text-dark" id="taskModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"><span class="fw-bold">{{$task["name"]}}</span> - {{$task["description"]}}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

          <div class="modal-body d-flex flex-column">
            <form>
              <div class="form-group">
                <h1>Material</h1>
                @foreach($entries as $entry)
                  @if($entry["type"]=="text")
                    <p class="lead mb-4">{{$entry["entry"]}}</p>
                  @elseif($entry["type"]=="image")
                    <img src="{{$entry["location"]}}" class="mw-100 rounded mb-4"/>
                  @endif
                @endforeach
                <hr>
                <h1>Questions</h1>
                @foreach($questions as $question)
                  <span>Question <span class="text-primary">{{$loop->index+1}}</span></span> 
                  @if($question["type"]=="textinput")
                    <input name="q_{{$loop->index}}" type="text" class="form-control my-2 w-100" placeholder="{{$question["question"]}}"  maxlength="{{$question["maxlength"]}}" value="18" required/>
                  @elseif($question["type"]=="openinput")
                    <textarea name="q_{{$loop->index}}" class="form-control" placeholder="{{$question["question"]}}" rows="5" maxlength="{{$question["maxlength"]}}" required>s</textarea>
                  @elseif($question["type"]=="text")
                    <p>{{$question["question"]}}</p>
                  @endif
                @endforeach
                <hr>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="taskFinishButton">Finish</button>
          </div>
        </form>
      </div>
    </div>
  </div>