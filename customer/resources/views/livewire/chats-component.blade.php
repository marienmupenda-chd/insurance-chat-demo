<div class="p-3">
    <h1>Customer Chat</h1>
    <ul class="list-group">
        @foreach($chat->messages??[] as $message)
            <li class="list-group-item">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5>{{ $message->user->name }}</h5>
                        <p>{{ $message->message }}</p>
                    </div>
                    <div>
                        <small>{{ $message->created_at->diffForHumans() }}</small>
                    </div>
                </div>
        @endforeach
    </ul>
    <div class="mt-3">
        <input type="text" wire:model="message" class="form-control mb-3 mt-3" placeholder="Type your message here...">
        <button wire:click="sendMessage" class="btn btn-primary">Send</button>
    </div>
    <div class="mt-3">
        Subscribed : <code>{{ $subscribed }}</code><br>
        Status : {{ $httpStatus  }}<br>
        Message: {{ $httpMessage }}<br>
        Data:
        <code>{{ json_encode($data, JSON_PRETTY_PRINT) }}</code>
    </div>
</div>
