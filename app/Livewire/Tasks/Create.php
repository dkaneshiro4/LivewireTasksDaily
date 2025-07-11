<?php

namespace App\Livewire\Tasks;

use App\Models\Task;
use App\Models\TaskCategory;
use Illuminate\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('nullable|date')]
    public null|string $due_date = null;

    #[Validate('nullable|file|max:10240')]
    public $media;

    #[Validate([
        'selectedCategories' => ['nullable', 'array'],
        'selectedCategories.*' => ['exists:task_categories,id'],
    ])]
    public array $selectedCategories = [];

    public function save(): void
    {
        $this->validate();

        $task = Task::create([
            'name' => $this->name,
            'due_date' => $this->due_date,
        ]);

        if ($this->media) {
            $task->addMedia($this->media)->toMediaCollection();
        }

        $task->taskCategories()->sync($this->selectedCategories);

        session()->flash('success', 'Task successfully created.');

        $this->redirectRoute('tasks.index', navigate: true);;
    }

    public function render(): View
    {
        return view('livewire.tasks.create', [
            'categories' => TaskCategory::all()->sortBy('name'),
        ]);
    }
}
