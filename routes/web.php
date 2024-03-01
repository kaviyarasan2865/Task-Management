<?php

use App\Http\Controllers\AdminDashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeDetailController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\EmployeeDashboardController;
use App\Models\EmployeeDetail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


//Login
Route::get('/', [AuthController::class,'showLoginForm'])->name('login');
Route::post('/', [AuthController::class,'login']);
Route::get('/logout',[AuthController::class, 'logout'])->name('logout');

//Admin Dashboard
route::get('/d',[AdminDashboardController::class,'kmm'])->name('dash');

//add employees by admin
Route::get('/add_employee', [EmployeeDetailController::class, 'create'])->name('employees.i');
Route::post('/add_employee', [EmployeeDetailController::class, 'store']);

//show employee details to admin
Route::get('/view_employee', [EmployeeDetailController::class, 'show'])->name('employees.index');

//Editing, updating, and deleting employee details
Route::get('/employee-details/{id}/edit', [EmployeeDetailController::class, 'edit'])->name('employees.edit');
Route::put('/employee-details/{id}', [EmployeeDetailController::class, 'update'])->name('employees.update');
Route::delete('/employee-details/{id}', [EmployeeDetailController::class, 'destroy'])->name('employees.destroy');

//search employee
Route::get('/employees/searchemp', [EmployeeDetailController::class,'searchemp'])->name('employees.searchemp');
Route::get('/employees/search', [EmployeeDetailController::class,'search'])->name('employees.search');


//task

//create
Route::get('/assign-task', [TaskController::class, 'create'])->name('tasks.create');
Route::post('/assign-task', [TaskController::class, 'store'])->name('tasks.store');
Route::get('/employees/{subcategory}', [EmployeeDetailController::class, 'getEmployeesBySubcategory'])->name('employees.subcategories');
Route::get('/employees/employees-by-subcategory', [EmployeeDetailController::class, 'getEmployeesBySubcategory'])->name('employees.employeesBySubcategory');

//view
Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');

Route::get('/tasks/update/{id}', [TaskController::class, 'show'])->name('tasks.showUpdateForm');
//update
Route::post('/tasks/{id}/update-status', [TaskController::class,'updateStatus'])->name('tasks.update');

//delete
Route::delete('/tasks/delete/{id}', [TaskController::class,'destroy'])->name('tasks.delete');

//search task
Route::get('/tasks/search', [TaskController::class,'searchTasks'])->name('task.search');
Route::get('/tasks/searched', [TaskController::class, 'search'])->name('task.searched');


///Employee Dashboard
Route::get('/employee/dashboard', [EmployeeDashboardController::class,'index'])->name('employee.dashboard');
Route::get('/employee/{id}', [EmployeeDetailController::class, 'showemp'])->name('employees.id');

//employee  dashboard routes task
Route::get('/employee.task/{id}', [TaskController::class, 'showTask'])->name('employees.id');
Route::get('/tasks/updatetask/{id}', [TaskController::class, 'showUpdate'])->name('tasks.showUpdate');
Route::post('/task/{id}/update-status', [TaskController::class,'updateempStatus'])->name('task.updateStatus');
