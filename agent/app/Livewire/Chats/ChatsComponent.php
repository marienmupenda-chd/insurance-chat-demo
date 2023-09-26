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

    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('livewire.chats.chat-index-component');
    }


    public function getListeners(): array
    {
        return [
            "echo:chats,ChatEvent" => 'newChat',
            'refresh' => '$refresh',
        ];
    }

    public function newChat($data): void
    {
        $this->newChat = $data;
    }

    public function openChat($chat_id): void
    {

        $response = Http::acceptJson()
            ->withHeaders([
                'Authorization' => 'Bearer ' . env('CHAT_AUTH_TOKEN'),
            ])
            ->asJson()
            ->post(env('CHAT_APP_URL') . "/chats/{$chat_id}/open", [
                'message' => $this->message
            ]);

        $this->httpStatus = $response->status();
        $this->httpMessage = $response->body();

        if ($response->successful()) {
            $this->data = $response->json();
        }
    }

}
