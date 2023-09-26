<?php

namespace App\Livewire\Chats;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class ChatsComponent extends Component
{
    public array $newChat = [];
    public ?string $message = "Hey, what can i do for you?";
    public int $httpStatus;
    public string $httpMessage;
    public ?array $data;
    public ?string $chatId = null;
    public array $chat;

    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('livewire.chats.chat-index-component');
    }


    public function getListeners(): array
    {
        $listeners = [
            "echo:chats,ChatEvent" => 'newChat',
            'refresh' => '$refresh',
        ];

        if ($this->chatId) {
            $listeners["echo:chats.{$this->chatId},ChatEvent"] = 'newMessage';
        }

        return $listeners;
    }

    public function newMessage($data): void
    {

        dd($data);
        $this->chat = $data['chat'];
    }

    public function newChat($data): void
    {
        $this->newChat = $data;
    }

    public function openChat($chatId): void
    {

        $response = Http::acceptJson()
            ->withHeaders([
                'Authorization' => 'Bearer ' . env('CHAT_AUTH_TOKEN'),
            ])
            ->asJson()
            ->post(env('CHAT_APP_URL') . "/chats/{$chatId}/open", [
                'message' => $this->message
            ]);

        $this->httpStatus = $response->status();
        $this->httpMessage = $response->body();

        if ($response->successful()) {
            $this->data = $response->json();
            $this->redirect(route('chats.show', [$chatId]));
        }
    }


    public function sendMessage(): void
    {
        $url = env('CHAT_APP_URL') . "/chats/{$this->chatId}/send";
        $response = Http::acceptJson()
            ->withHeaders([
                'Authorization' => 'Bearer ' . env('CHAT_AUTH_TOKEN'),
            ])
            ->asJson()
            ->post($url,
                [
                    'message' => $this->message,
                ]);

        $this->httpStatus = $response->status();
        $this->httpMessage = $response->body();


        $this->data = $response->json();
    }

}
