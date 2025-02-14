<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;
use App\Http\Requests\Api\TaskRequest;
use App\Http\Resources\Api\TasksResource;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::all();
        return response()->json([
            'data' => TasksResource::collection($tasks),
            'status'    => HttpFoundationResponse::HTTP_OK,
        ], HttpFoundationResponse::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $request)
    {
        Task::create($request->validated());
        return response()->json([
            'message'   => 'Task created successfully',
            'status'    => HttpFoundationResponse::HTTP_OK,
        ], HttpFoundationResponse::HTTP_OK);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = Task::find($id);

        if ($task) {
            return response()->json([
                'data' => TasksResource::make($task),
                'status' => HttpFoundationResponse::HTTP_OK
            ], HttpFoundationResponse::HTTP_OK);
        }
        return response()->json([
            "message"   => "This task not found",
            "status" => HttpFoundationResponse::HTTP_NOT_FOUND,
        ], HttpFoundationResponse::HTTP_NOT_FOUND);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskRequest $request, string $id)
    {
        $task = Task::find($id);

        if ($task) {
            $task->update($request->validated());
            return response()->json([
                'message'   => 'Task updated successfully',
                'status'    => HttpFoundationResponse::HTTP_OK,
            ], HttpFoundationResponse::HTTP_OK);
        }
        return response()->json([
            'message'   => 'This task not found',
            'status'    => HttpFoundationResponse::HTTP_NOT_FOUND
        ], HttpFoundationResponse::HTTP_NOT_FOUND);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::find($id);
        if ($task) {
            $task->delete();
            return response()->json([
                'message'   => 'Task deleted successfully',
                'status'    => HttpFoundationResponse::HTTP_OK,
            ]);
        }
        return response()->json([
            "message"   => 'This task not found',
            'status'    => HttpFoundationResponse::HTTP_NOT_FOUND,
        ]);
    }
}
