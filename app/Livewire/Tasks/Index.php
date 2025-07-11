<?php

namespace App\Livewire\Tasks;

use App\Models\Task;
use App\Models\TaskCategory;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[Url(as: 'categories', except: '')]
    public ?array $selectedCategories = [];

    public function delete(int $id): void
    {
        Task::where('id', $id)->delete();

        session()->flash('success', 'Task successfully deleted.');

        $this->redirectRoute('tasks.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.tasks.index', [
            'tasks' => Task::query()
                ->with('media', 'taskCategories')
                ->when($this->selectedCategories, function (Builder $query) {
                    $query->whereHas('taskCategories', function (Builder $query) {
                        $query->whereIn('task_categories.id', $this->selectedCategories);
                    });
                })
                ->paginate(3),
            'categories' => TaskCategory::all()->sortBy('name'),
        ]);
    }
}
