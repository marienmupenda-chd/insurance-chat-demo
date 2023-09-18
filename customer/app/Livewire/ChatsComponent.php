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
    public ?string $message = null;
    public int $httpStatus;
    public ?string $httpMessage;
    public array $data;

    public function mount(): void
    {
        $this->newChat = false;
        $this->chat = null;
    }

    #[On('echo:chats,ChatEvent')]
    public function notifyNewChat(): void
    {
        $this->newChat = true;
    }

    public function render(): Factory|\Illuminate\Foundation\Application|View|Application
    {
        return view('livewire.chats-component');
    }

    public function sendMessage(): void
    {
        $response = Http::acceptJson()
            ->withHeaders([
                'Authorization' => 'Bearer ' . env('AUTH_TOKEN'),
            ])
            ->asJson()
            ->post('http://ensurance-ms.test/api/app/chats/create', [
                'message' => $this->message,
            ]);

        $this->httpStatus = $response->status();
        $this->httpMessage = $response->body();

        if ($response->successful()) {
            $this->data = $response->json()['data'];
        }
    }
}
