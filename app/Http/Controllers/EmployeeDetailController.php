<?php

namespace App\Http\Controllers;
use Illuminate\Validation\ValidationException;

use App\Models\EmployeeDetail;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use App\Mail\UserCredentialsMail;
use Illuminate\Support\Facades\Mail;

class EmployeeDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('add_employee');
    }

    /**
     * Store a newly created resource in storage.
     */

        public function store(Request $request)
        {
            try {
                $validatedData = $request->validate([
                    'employeeName' => 'required|string|max:255',
                    'employeeMobile' => 'required|string|regex:/^[0-9]{1,20}$/',
                    'employeeEmail' => 'required|email|max:255|unique:employee_details',
                    'employeeDOB' => 'required|date|before_or_equal:2003-12-31',
                    'employeeGender' => 'required|string|in:male,female,other',
                    'employeeDOJ' => 'required|date',
                    'employeeAddress' => 'required|string|max:255',
                    'employeePassword' => 'required|string|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}$/',
                    'employeeCategory' => 'required|string|in:hr,developer,tester',
                    'employeeSubcategory' => 'nullable|string|max:255',
                    'employeeProfileImage' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
                ], [
                    'employeeName.required' => 'Employee Name is required.',
                    'employeeMobile.required' => 'Mobile is required.',
                    'employeeMobile.regex' => 'Mobile must be numeric.',
                    'employeeEmail.required' => 'Email is required.',
                    'employeeEmail.email' => 'Please enter a valid email address.',
                    'employeeEmail.unique' => 'This email is already taken.',
                    'employeeDOB.required' => 'Date of Birth is required.',
                    'employeeDOB.before_or_equal' => 'Date of Birth should not be greater than 2003.',
                    'employeeGender.required' => 'Gender is required.',
                    'employeeDOJ.required' => 'Date of Joining is required.',
                    'employeeAddress.required' => 'Address is required.',
                    'employeePassword.required' => 'Password is required.',
                    'employeePassword.min' => 'Password must be at least 8 characters long.',
                    'employeePassword.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one special character.',
                    'employeeCategory.required' => 'Category is required',
                    'employeeSubCategory.required' => 'Category is required',
                ]);

                if ($request->hasFile('employeeProfileImage')) {
                    $path = $request->file('employeeProfileImage')->store('images', 'public');
                    $validatedData['employeeProfileImage'] = $path;
                }
                //password without hash
                $userDetails['password']=$validatedData['employeePassword'];

                // Hash password
                $validatedData['employeePassword'] = bcrypt($validatedData['employeePassword']);

                // Create to employee table
                EmployeeDetail::create($validatedData);

                // details to add on user table
                $userCredentials = [
                    'email' => $validatedData['employeeEmail'],
                    'password' => $validatedData['employeePassword'],
                ];

                //details to send for mail
                $sendDetails=[
                    'email' => $validatedData['employeeEmail'],
                    'password' => $userDetails['password'],
                ];


                $subject = "Message from Project Manager";

                Mail::to($validatedData['employeeEmail'])->send(new UserCredentialsMail($sendDetails,$subject));

                User::create($userCredentials);

                return response()->json(['success' => true, 'message' => 'Employee added successfully!']);
            } catch (ValidationException $e) {
                $errors = $e->validator->errors()->all();
                return response()->json(['success' => false, 'errors' => $errors], 422);
            }
        }



    /**
     * Display the specified resource.
     */
    public function show()
{
    $employees = EmployeeDetail::all();
    return view('view_employee', ['employees' => $employees])->with('success', 'Employee added successfully!');
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $employee = EmployeeDetail::findOrFail($id);
            return view('edit_employee', compact('employee'));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to retrieve employee data. Please try again.');
        }
    }

    /**
     * Update the specified resource in storage.
     */public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $request->validate([
            'editEmployeeName' => 'required|string|max:255',
            'editEmployeeMobile' => 'required|string|max:20',
            'editEmployeeEmail' => 'required|email|max:255',
            'editEmployeeDOB' => 'required|date',
            'editEmployeeGender' => 'required|in:male,female,other',
            'editEmployeeDOJ' => 'required|date',
            'editEmployeeAddress' => 'required|string|max:255',
            'editEmployeeCategory' => 'required|in:hr,developer,tester',
            'editEmployeeSubcategory' => 'nullable|string|max:255',
            'editEmployeePassword' => 'required|string|max:255',
            'editEmployeeProfileImage' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $employee = EmployeeDetail::findOrFail($id);

        $employee->employeeName = $request->editEmployeeName;
        $employee->employeeMobile = $request->editEmployeeMobile;
        $employee->employeeEmail = $request->editEmployeeEmail;
        $employee->employeeDOB = $request->editEmployeeDOB;
        $employee->employeeGender = $request->editEmployeeGender;
        $employee->employeeDOJ = $request->editEmployeeDOJ;
        $employee->employeeAddress = $request->editEmployeeAddress;
        $employee->employeeCategory = $request->editEmployeeCategory;
        $employee->employeeSubcategory = $request->editEmployeeSubcategory;
        $employee->employeePassword = $request->editEmployeePassword;

        // Handle profile image upload if provided
        if ($request->hasFile('editEmployeeProfileImage')) {
            $image = $request->file('editEmployeeProfileImage');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->storeAs('public', $imageName);
            $employee->employeeProfileImage = $imageName;
        }

        $employee->save();
        return redirect()->back()->with('success', 'Employee details updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy($id)
    {
         // Retrieve the employee record
    $employee = EmployeeDetail::find($id);

            // Check if the employee exists
    if ($employee) {
        // Retrieve the corresponding user by email
        $user = User::where('email', $employee->employeeEmail)->first();

        // Check if the user exists
        if ($user) {
            // Delete the user record
            $user->delete();
        }

        // Delete the employee record
        $employee->delete();

        return redirect()->route('dash')->with('success', 'Employee and corresponding user deleted successfully.');
    }
}

    public function searchemp()
    {
        return view('search_employee');
    }

    public function search(Request $request)
{

    $query = EmployeeDetail::query();

    // Search by name
    if ($request->filled('name')) {
        $query->where('employeeName', 'like', '%' . $request->input('name') . '%');
    }

    // Search by email
    if ($request->filled('email')) {
        $query->where('employeeEmail', 'like', '%' . $request->input('email') . '%');
    }

    // Search by mobile
    if ($request->filled('mobile')) {
        $query->where('employeeMobile', 'like', '%' . $request->input('mobile') . '%');
    }

    // Search by address
    if ($request->filled('address')) {
        $query->where('employeeAddress', 'like', '%' . $request->input('address') . '%');
    }

    // Search by gender
    if ($request->filled('gender')) {
        $query->where('employeeGender', $request->input('gender'));
    }

    // Search by category
    if ($request->filled('category')) {
        $query->where('employeeCategory', $request->input('category'));
    }

    // Search by subcategory
    if ($request->filled('subcategory')) {
        $query->where('employeeSubcategory', $request->input('subcategory'));
    }

     // Search by ID
    if ($request->filled('id')) {
        $query->where('id', $request->input('id'));
    }

    $employees = $query->get();

    return view('search_results', compact('employees'));
}



public function getEmployeesBySubcategory(Request $request, $subcategory)
{
    // Query the database to get employees based on the subcategory
    $employees = EmployeeDetail::where('employeeSubcategory', $subcategory)->get();

    // Build HTML options for the employees dropdown
    $options = '<option value="">Select Employee</option>';
    foreach ($employees as $employee) {
        $options .= '<option value="' . $employee->id . '">' . $employee->employeeName . '</option>';
    }

    // Return HTML options
    return $options;
}



/////emp dash side
public function showemp($id)
    {
        $employee = EmployeeDetail::find($id);
        if (!$employee) {
            return redirect()->back()->with('error', 'Employee not found.');
        }

        return view('employee.empdetails', compact('employee'));
    }

}
