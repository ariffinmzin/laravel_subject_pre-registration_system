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
        return view('students.student_create', compact('year_options', 'program_options'));
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
            'program' => 'required|string|max:3|in:BIT,BIP,BIS,BIW,BIM',
            'password' => 'required|string|min:8|confirmed',
            'pak' => 'required|string|exists:users,name', // Ensure the PAK exists in the users table

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
        $student->lecturer_id = User::where('name', $validated_data['pak'])->firstOrFail()->id;
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
        $student = Student::with(['user', 'lecturer.user'])->findOrFail($id);
        return view('students.student_show', compact('student'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $year_options = Student::YEAR_OPTIONS;
        $program_options = Student::PROGRAM_OPTIONS;

        // Load the student along with the associated user and lecturer (assuming `lecturer_id` is related to `User`)
        $student = Student::with(['user', 'lecturer.user'])->findOrFail($id);

        //  tells Eloquent to join the users table based on the relationship defined in the Student model.
        // $student = Student::with('user')->findOrFail($id);  

        return view('students.student_edit', compact('student', 'year_options', 'program_options'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //

        $student = Student::with('user')->findOrFail($id);

        $validated_data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $student->user->id,
            'matric_id' => 'required|string|max:255|unique:users,matric_id,' . $student->user->id,
            'year' => 'required|integer',
            'program' => 'required|string|max:255',
            'pak' => 'required|string|exists:users,name', // Ensure the PAK exists in the users table
            'status' => 'required|string|in:unregistered,registered',
        ]);

        // Update the user's details
        $student->user->name = $validated_data['name'];
        $student->user->email = $validated_data['email'];
        $student->user->matric_id = $validated_data['matric_id'];

        // Update the student's details
        $student->year_of_study = $validated_data['year'];
        $student->program = $validated_data['program'];
        $student->status = $validated_data['status'];

        // Update the lecturer ID
        $lecturer = User::where('name', $validated_data['pak'])->firstOrFail();
        $student->lecturer_id = $lecturer->lecturer->id;

        // Update the password if provided
        if (!empty($validated_data['password'])) {

            $student->user->password = bcrypt($validated_data['password']);
        }

        // Save the user and student
        $student->user->save();
        $student->save();

        return redirect()->route('students.index')->with('message', 'Student has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $student = Student::with('user')->findOrFail($id);

        // Delete the associated user
        $student->user->delete();

        // Delete the student
        $student->delete();

        return redirect()->route('students.index')->with('message', 'Student has been deleted successfully.');
    }

    public function find(Request $request)
    {
        if ($request->ajax()) {

            $students = Student::join('users', 'students.user_id', '=', 'users.id')
                ->where(function ($query) use ($request) {
                    $query->where('users.name', 'LIKE', "%{$request->search}%")
                        ->orWhere('users.matric_id', 'LIKE', "%{$request->search}%");
                })
                ->select('students.*', 'users.name', 'users.email', 'users.matric_id')
                ->paginate(10);

            $output = '';
            $csrfToken = csrf_token();

            if ($students->count() > 0) {
                $output .= '
                    <table class="table mt-3">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Matric Id</th>
                                <th scope="col">Email</th>
                                <th scope="col">Year</th>
                                <th scope="col">Program</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>';

                foreach ($students as $index => $student) {
                    $output .= '
                        <tr>
                            <th scope="row">' . ($index + 1 + ($students->currentPage() - 1) * $students->perPage()) . '</th>
                            <td>' . $student->name . '</td>
                            <td>' . $student->matric_id . '</td>
                            <td>' . $student->email . '</td>
                            <td>' . $student->year_of_study . '</td>
                            <td>' . $student->program . '</td>
                            <td class="text-center">
                                <a href="' . route("students.edit", $student->id) . '" style="text-decoration: none">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-pencil">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4"/>
                                        <path d="M13.5 6.5l4 4"/>
                                    </svg>
                                </a>

                                <a href="javascript:void(0);" onclick="confirmDelete(' . $student->id . ')" style="text-decoration: none">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-trash">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M4 7l16 0"/>
                                        <path d="M10 11l0 6"/>
                                        <path d="M14 11l0 6"/>
                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"/>
                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"/>
                                    </svg>
                                </a>
                                <form id="delete-form-' . $student->id . '" action="' . route("students.destroy", $student->id) . '" method="POST" style="display: none;">
                                    <input type="hidden" name="_token" value="' . $csrfToken . '">
                                    <input type="hidden" name="_method" value="DELETE">
                                </form>
                            </td>
                        </tr>';
                }

                $output .= '
                        </tbody>
                    </table>';

                // Add pagination links if needed
                $output .= '<div class="d-flex justify-content-between justify-content-center">
                                <div>Showing ' . $students->firstItem() . ' to ' . $students->lastItem() . ' of ' . $students->total() . ' results</div>
                                <div>' . $students->links() . '</div>
                            </div>';
            } else {
                $output .= 'No results';
            }

            // Add JavaScript for delete confirmation
            $output .= '
                <script>
                    function confirmDelete(studentId) {
                        if (confirm("Are you sure you want to delete this student?")) {
                            document.getElementById("delete-form-" + studentId).submit();
                        }
                    }
                </script>';

            return $output;
        } else {
            // If it's not an AJAX request, just return the view
            return view('students.student_find');
        }
    }

    public function findPak(Request $request)
    {
        try {
            $pak = User::select("name")
                ->where("name", "LIKE", "%{$request->term}%")
                ->where("role", "lecturer")
                ->get();

            return response()->json($pak);
        } catch (\Exception $e) {
            // Log the error message
            \Log::error('Error in findPak: ' . $e->getMessage());

            // Optionally return a more detailed error message for debugging
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
