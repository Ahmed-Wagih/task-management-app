<?php

namespace App\Repositories;

use App\Models\Task;

class TaskRepository
{
    public function create(array $data)
    {
        return Task::create($data);
    }

    public function update(Task $task, array $data)
    {
        $task->update($data);
        return $task;
    }

    public function delete(Task $task)
    {
        $task->delete();
    }

    public function findById($id)
    {
        return Task::findOrFail($id);
    }

    public function search($query, $perPage = 5)
    {
        return Task::where('title', 'like', "%$query%")
            ->orWhere('status', 'like', "%$query%")
            ->paginate($perPage);
    }
}