<?php

namespace App\Http\Controllers;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $task = Task::latest()->get();
        return response()->json(['data' => $task], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',

        ]);

        $task = Task::create([
            'user_id' => 1,
            'title' => $validated['title'],
            'description' => $validated['description'],


        ]);
        return response()->json(['data' => $task], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = Task::where('id', $id)->find($id);
        if (!$task) {
            return response()->json(['message' => 'task not exist'], 404);
        }
        return response()->json(['data' => $task], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $task = Task::where('id', $id)->find($id);
        if (!$task) {
            return response()->json(['message' => 'task not exist'], 404);
        }
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'status' => 'required|in:pending,in_progress,completed',
        ]);
        $task->update($validated);
        return response()->json(['data' => $task], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::where('id', $id)->find($id);
        if (!$task) {
            return response()->json(['message' => 'task not exist'], 404);
        }
        $task->delete();
        return response()->json(null, 204);
    }
}
