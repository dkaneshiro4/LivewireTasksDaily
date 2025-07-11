<?php

namespace App\Livewire\Tasks;

use App\Models\Task;
use Illuminate\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Create extends Component
{
    #[Validate('required|string|max:255')]
    public string $name = '';

    public function save(): void
    {
        $this->validate();

        Task::create([
            'name' => $this->name,
        ]);

        session()->flash('success', 'Task successfully created.');

        $this->redirectRoute('tasks.index', navigate: true);;
    }

    public function render(): View
    {
        return view('livewire.tasks.create');
    }
}
