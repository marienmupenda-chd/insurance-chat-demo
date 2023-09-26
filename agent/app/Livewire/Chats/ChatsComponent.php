<?php

namespace App\Livewire\Chats;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ChatsComponent extends Component
{
    public array $chat;
    public array $message;
    public array $messages = [];

    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('livewire.chats.chat-index-component');
    }


    public function getListeners(): array
    {
        return [
            "echo:chats,ChatEvent" => 'refreshChat',
            'refresh' => '$refresh',
        ];
    }

    public function refreshChat($data): void
    {

        $this->chat = $data['chat'];
        $this->message = $data['message'];

        // $this->dispatch('refresh');
    }

}
