<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //3
        $tasks = Task::paginate(2   );
        return view('tasks', compact('tasks'));
    }
    public function search(Request $request)
    {
        // Get the search query from the request
        $query = $request->input('search');

        // Perform the search query on the tasks table
        $tasks = Task::where('title', 'like', '%' . $query . '%')->paginate(2   );




        return view('tasks', compact('tasks'));
    }


    public function store(TaskStoreRequest $request)
    {
        //

        $tasks = Task::create([

            'title'  => $request->title,
            'description'  => $request->description,
            'completed'  => $request->has('completed') ? 1 : 0,
        ]);
        return redirect()->route('tasks.index')->with('success', 'Task created successfully');
    }




    public function update(TaskUpdateRequest $request, Task $task)
    {
        //
        $task->update([
            'title'  => $request->title,
            'description'  => $request->description,
            'completed'  => $request->has('completed') ? 1 : 0 ,
        ]);
        return redirect()->route('tasks.index')->with('success', 'Task Updated successfully');

    }


    public function destroy(Task $task)
    {
        //
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully');
    }
}
