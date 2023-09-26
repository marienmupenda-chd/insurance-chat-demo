<div class="p-3">
    <h1 class="mb-5">Agent Chat</h1>
    <div class="row">
        <div class="col-md-6">
            <div class="card p-3">
                <h2>All chats</h2>
                <div>
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5>{{ $newChat['message']['body']??null }}</h5>
                            <p>
                                {{ $newChat['chat']['status']??null }} - {{ count($newChat['chat']['messages']??[]) }}
                                messages
                            </p>
                        </div>
                        <div>
                            <small>{{  $newChat['chat']['created_at']??null}}</small>
                        </div>
                    </div>
                    <div class="mt-3">
                        <input wire:model="message" type="text"
                               class="form-control mb-3 mt-3"
                               placeholder="Type your message here...">
                        <button wire:click="openChat('{{$newChat['chat']['id']??null}}')" class="btn btn-primary">Open
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-3">

                <h2>Ongoing Chat</h2>

                <ul class="list-group">
                    @foreach($chat['messages']??[] as $message)
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h5>{{ $message['body']}}</h5>
                                    <p>{{ $message['user_id']}}</p>
                                </div>
                                <div>
                                    <small>{{ $message['created_at'] }}</small>
                                </div>
                            </div>
                    @endforeach
                </ul>
                <div class="mt-3">
                    <input type="text" wire:model="message" class="form-control mb-3 mt-3"
                           placeholder="Type your message here...">
                    <button wire:click="sendMessage" class="btn btn-primary">Reply</button>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div>
        <h3> Chat Log</h3>
        Old Chat :
        <code>
            <pre>{{ json_encode($chat, JSON_PRETTY_PRINT) }}</pre>
        </code>
        New Chat :
        <code>

            <pre>{{ json_encode($newChat, JSON_PRETTY_PRINT) }}</pre>
        </code> {{-- Message:
         <pre>{{ json_encode($message, JSON_PRETTY_PRINT) }}</pre>--}}
    </div>
    <div>
        <h3>Request Log</h3>
        Status : {{ $httpStatus  }}<br>
        Message: {{ $httpMessage }}<br>
        Data:
        <code>
            <pre>{{ json_encode($data, JSON_PRETTY_PRINT) }}</pre>
        </code>
    </div>

</div>
