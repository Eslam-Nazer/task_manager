<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Enum\StatusEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Task\CreateRequest;
use App\Http\Requests\Task\UpdateRequest;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::all();
        return view("dashboard", compact("tasks"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $status = StatusEnum::cases();
        return view("task.create", compact("status"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request)
    {
        // dd($request->all());
        Task::create($request->all());
        return redirect()->route("dashboard")->with("success", "Task created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $status = StatusEnum::cases();
        $task = Task::find($id);
        return view('task.edit', compact('status', 'task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        Task::find($id)->update($request->all());
        return redirect()->route('dashboard')->with('success', 'Task updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Task::find($id)->delete();
        return redirect()->route('dashboard')->with('delete', 'Task delete successfully!');
    }
}
