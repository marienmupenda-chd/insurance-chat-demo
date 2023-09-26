<?php

namespace App\Livewire;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class ChatsComponent extends Component
{
    public bool $newChat = false;
    /**
     * @var null
     */
    public ?array $chat;
    public ?string $message = "Hello, I need help";
    public int $httpStatus;
    public ?string $httpMessage;
    public array $data;
    public string $channel = 'chats.01hb8mp8aykjnmxby48s7bw9vb';
    public string $event = 'ChatEvent';


    /*    public $listeners = [
            "echo:chats,ChatEvent" => 'newChat',
            'refresh' => '$refresh',
        ];*/

    public function mount(): void
    {
        $this->newChat = false;
        $this->chat = null;
        $this->listeners["echo:{$this->channel},{$this->event}"] = 'newMessage';
    }

    public function newMessage($data): void
    {
        dd($data);
    }

    public function render(): Factory|\Illuminate\Foundation\Application|View|Application
    {
        return view('livewire.chats-component');
    }

    public function sendMessage(): void
    {
        $response = Http::acceptJson()
            ->withHeaders([
                'Authorization' => 'Bearer ' . env('CHAT_AUTH_TOKEN'),
            ])
            ->asJson()
            ->post(env('CHAT_APP_URL'), [
                'message' => $this->message,
            ]);

        $this->httpStatus = $response->status();
        $this->httpMessage = $response->body();

        if ($response->successful()) {
            $this->data = $response->json()['data'];

            $this->channel = $this->data['channel'];
            $this->event = $this->data['event'];

            $this->listeners["echo:{$this->channel},{$this->event}"] = 'newMessage';

            //  dd($this->getListeners());
        }
    }
}
