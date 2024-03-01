<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Models\EmployeeDetail;
use Illuminate\Support\Facades\Mail;
use App\Mail\TaskAssignedNotification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::all();
        return view('tasks.view_task', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = EmployeeDetail::all();
        return view('tasks.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


try{
        $currentDateTime = date('Y-m-d H:i:s');

        $validatedData = Validator::make($request->all(), [
            'category' => 'required',
            'subcategory' => 'required',
            'employee_id' => 'required',
            'employee_name' => 'required',
            'task_name' => 'required',
            'scheduled_time' => [
                'required',
                "after_or_equal:{$currentDateTime}",
            ],
        ], [
            'scheduled_time.after_or_equal' => "Scheduled time must be a date and time after the current date and time."
        ])->validate();

        Task::create($validatedData);

        $s="Is the Task Assigned to you";
        $task_name=$validatedData['task_name'];

         // Fetch the employee details
         $employee = EmployeeDetail::find($validatedData['employee_id']);

         // Send email notification to the employee
         if ($employee) {
         Mail::to($employee->employeeEmail)->send(new TaskAssignedNotification($task_name, $s));
         }
         return response()->json(['success' => true, 'message' => 'Task Assigned successfully!']);
        } catch (ValidationException $e) {
            $errors = $e->validator->errors()->all();
            return response()->json(['success' => false, 'errors' => $errors], 422);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $task = Task::find($id);
        return view('tasks.UpdateTask', ['task' => $task]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'status' => 'required|in:yet-to-start,pending,in-progress,parked,complete',
        ]);
        $task = Task::findOrFail($id);
        $task->status = $request->input('status');
        date_default_timezone_set('Asia/Kolkata');
        $task->updated_time = Carbon::now()->toDateTimeString();

         $task->save();

        return response()->json(['success' => true, 'message' => 'Task updated successfully!']);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $e=Task::find($id);
        $e->delete();
        return redirect()->back();
    }



    public function updateStatus($id, Request $request)
    {
        $task = Task::findOrFail($id); // Find the task by ID

        // Update the task status
        $task->status = $request->status; // Assuming the status is submitted via the form

        date_default_timezone_set('Asia/Kolkata');
        $task->updated_time = Carbon::now()->toDateTimeString();
        $task->save(); // Save the updated task

        return response()->json(['message' => 'Task status updated successfully']);
   }

    public function searchTasks(){
        return view('tasks.search_task');
    }
    public function search(Request $request)
    {
        // Retrieve search parameters from the request
        $task_name = $request->input('task_name');
        $employee_name = $request->input('employee_name');
        $status = $request->input('status');

        // Query tasks table based on search parameters
        $tasks = Task::query();

        if ($task_name) {
            $tasks->where('task_name', 'like', '%' . $task_name . '%');
        }

        if ($employee_name) {
            $tasks->where('employee_name', 'like', '%' . $employee_name . '%');
        }

        if ($status) {
            $tasks->where('status', $status);
        }

        // Execute the query and get the results
        $results = $tasks->get();

        // Return the results to the view
        return view('tasks.search_results', compact('results'));
    }

    /////
///////

public function showTask($employeeid)
{
    $tasks = Task::where('employee_id', $employeeid)->get();

    return view('employee.taskdetails', compact('tasks','employeeid'));
}
public function updateempStatus($id, Request $request)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['success' => false, 'message' => 'Task not found.'], 404);
        }

        // Validate the request data
        $request->validate([
            'status' => ['required', 'in:initiated,finished,pending'], // Add 'pending' to the allowed statuses
        ]);

        // Update the task status
        $task->status = $request->status;

        // Set Indian Standard Time (IST)
        $timezone = 'Asia/Kolkata';

        if ($request->status == 'initiated') {
            $task->initiated_time = Carbon::now($timezone);
        } elseif ($request->status == 'finished') {
            $task->finished_time = Carbon::now($timezone);
        } elseif ($request->status == 'pending') {
            // code to reset initiated/finished time if resetting to pending
            $task->initiated_time = null;
            $task->finished_time = null;
        }
        $task->save();
        return redirect()->back();
    }

}

