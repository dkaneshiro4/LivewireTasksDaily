<?php

namespace App\Livewire\Tasks;

use App\Models\Task;
use Livewire\Component;

class Index extends Component
{
    public function delete(int $id): void
    {
        Task::where('id', $id)->delete();

        session()->flash('success', 'Task successfully deleted.');
    }

    public function render()
    {
        return view('livewire.tasks.index', [
            'tasks' => Task::paginate(5),
        ]);
    }
}
