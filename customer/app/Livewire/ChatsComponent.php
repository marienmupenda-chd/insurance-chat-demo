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

    public ?array $chat;
    public ?string $message = "Hello, I need help";
    public int $httpStatus;
    public ?string $httpMessage;
    public array $data;
    public ?string $subscribed = null;
    public ?string $chatId;

    protected $listeners = [
        'refresh' => '$refresh',
    ];

    public function mount(string $chatId = null): void
    {
        $this->newChat = false;
        $this->chat = null;

        if ($chatId) {
            $this->chatId = $chatId;
            $this->subscribed = "Channel: chats.{$chatId}, Event: ChatEvent";
        }

    }

    public function getListeners(): array
    {
        if (!$this->chatId) {
            return [];
        }
        return [
            "echo:chats.{$this->chatId},ChatEvent" => 'newMessage',
            'refresh' => '$refresh',
        ];
    }

    public function newMessage($data): void
    {
        $this->chat = $data['chat'];
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

            $this->chatId = $this->data['chat_id'];


            $this->redirect(route('chats.show', [$this->chatId]));
        }
    }
}
