<?php

namespace App\Livewire\TaskCategories;

use App\Models\TaskCategory;
use Livewire\Component;

class Index extends Component
{
    public function delete(int $id): void
    {
        $taskCategory = TaskCategory::find($id);

        if ($taskCategory->tasks()->count() > 0) {
            $taskCategory->tasks()->detach();
        }

        $taskCategory->delete();
    }
    public function render()
    {
        return view('livewire.task-categories.index', [
            'taskCategories' => TaskCategory::withCount('tasks')
                ->orderBy('name')
                ->paginate(5),
        ]);
    }
}
