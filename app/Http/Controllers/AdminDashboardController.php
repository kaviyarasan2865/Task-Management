<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;

use App\Models\EmployeeDetail;
use App\Models\Task;
use App\Models\User;

use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function kmm(){
    $employee= EmployeeDetail::all();
    $task=Task::all();
    $user=User::all();
    $yts_TaskCount = Task::where('status', 'yet-to-start')->count();
    $pendingTaskCount = Task::where('status', 'pending')->count();
    $progressTaskCount = Task::where('status', 'in-progress')->count();
    $parkedTaskCount = Task::where('status', 'parked')->count();
    $completeTaskCount = Task::where('status', 'complete')->count();
        return view('dash',compact(['employee','task','user','yts_TaskCount','pendingTaskCount','progressTaskCount','parkedTaskCount','completeTaskCount']));
    }
}
