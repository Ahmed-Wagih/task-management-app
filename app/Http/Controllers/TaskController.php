<?php

namespace App\Http\Controllers;

use App\Repositories\TaskRepository;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    private $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 5);
        $query = $request->query('q', '');

        $tasks = $this->taskRepository->search($query, $perPage);

        return response()->json($tasks);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'nullable',
            'status' => 'nullable',
            'user_id' => 'nullable',
        ]);

        $task = $this->taskRepository->create($request->all());

        return response()->json($task, 201);
    }

    public function show($id)
    {
        $task = $this->taskRepository->findById($id);

        return response()->json($task);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'nullable',
            'status' => 'nullable',
            'user_id' => 'nullable',
        ]);

        $task = $this->taskRepository->findById($id);
        $task = $this->taskRepository->update($task, $request->all());

        return response()->json($task);
    }

    public function destroy($id)
    {
        $task = $this->taskRepository->findById($id);
        $this->taskRepository->delete($task);

        return response()->json(null, 204);
    }
}