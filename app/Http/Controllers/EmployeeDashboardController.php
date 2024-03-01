<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\EmployeeDetail;
use App\Models\Task;

class EmployeeDashboardController extends Controller
{
    public function index()
{
    // Retrieve the logged-in user's email
    $email = Auth::user()->email;

    // Retrieve employee details based on the email
    $employee = EmployeeDetail::where('employeeEmail', $email)->first();

    // Retrieve tasks assigned to the employee
    $tasks = Task::where('task_name', $employee)->get();

    // Pass employee details and tasks to the view
    return view('employee.employeedash', compact('employee', 'tasks'));
}
}
