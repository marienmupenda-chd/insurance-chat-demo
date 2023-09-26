<div class="p-3">
    <h1>Agent Chat</h1>
    <ul class="list-group">
        {{--  @foreach($messages as $message)--}}
        <li class="list-group-item">
            <div class="d-flex justify-content-between">
                <div>
                    <h5>{{ $message['body']??null }}</h5>
                    {{--   <p>{{ $message->message }}</p>--}}
                </div>
                <div>
                    <small>{{ $message['created_at']??null}}</small>
                </div>
            </div>
        {{-- @endforeach--}}
    </ul>
    <div class="mt-3">
        <input type="text" class="form-control mb-3 mt-3" placeholder="Type your message here...">
        <button class="btn btn-primary">Send</button>
    </div>
    <hr>
    <div>
        Chat :
        <pre>{{ json_encode($chat, JSON_PRETTY_PRINT) }}</pre>
        Message:
        <pre>{{ json_encode($message, JSON_PRETTY_PRINT) }}</pre>
    </div>

</div>
