<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Student;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
         // Get the sort parameter or use 'name' as the default
         $sortBy = $request->get('sort_by', 'name');
         $sortOrder = $request->get('sort_order', 'asc');
 
         // Ensure we're sorting by a column in the users table
         if (in_array($sortBy, ['name', 'email', 'matric_id'])) {
             $students = Student::join('users', 'students.user_id', '=', 'users.id')
                              ->orderBy("users.$sortBy", $sortOrder)
                              ->select('students.*', 'users.name', 'users.email', 'users.matric_id')
                              ->paginate(10);
         } else {
             $students = Student::with('user')
                              ->orderBy($sortBy, $sortOrder)
                              ->paginate(10);
         }
 
         return view('students.student_index', compact('students', 'sortBy', 'sortOrder'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $year_options = Student::YEAR_OPTIONS;
        $program_options = Student::PROGRAM_OPTIONS;
        return view('students.student_create', compact('year_options','program_options'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated_data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'matric_id' => 'required|string|max:255|unique:users,matric_id',
            'year' => 'required|integer',
            'program' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        
        ]);

        $user = new User();
        $user->name = $validated_data['name'];
        $user->email = $validated_data['email'];
        $user->matric_id = $validated_data['matric_id'];
        $user->password = bcrypt($validated_data['password']);
        $user->role = 'student';
        $user->save();

        $student = new Student();
        $student->user_id = $user->id;
        $student->year_of_study = $validated_data['year'];
        $student->program = $validated_data['program'];
        $student->status = 'unregistered';
        $student->save();

        return redirect()->route('students.index')->with('message', 'Student created successfully.');
        
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
