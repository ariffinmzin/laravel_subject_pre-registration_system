<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Lecturer;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

class LecturerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        // return view('lecturers.lecturer_index');

        // Eager load the 'user' relationship to avoid N+1 problem
        // $users = User::paginate(20);
        // $lecturers = Lecturer::with('user')->paginate(10);

        // Return the data to the view (or as JSON, depending on your needs)
        // return view('lecturers.lecturer_index', compact('lecturers'));
        // Or if it's an API
        // return response()->json($data);

        //---------------------------------------------------------------------------------------------//

        // Get the sort parameter or use 'name' as the default
        $sortBy = $request->get('sort_by', 'name');
        $sortOrder = $request->get('sort_order', 'asc');

        // Ensure we're sorting by a column in the users table
        if (in_array($sortBy, ['name', 'email', 'matric_id'])) {
            $lecturers = Lecturer::join('users', 'lecturers.user_id', '=', 'users.id')
                             ->orderBy("users.$sortBy", $sortOrder)
                             ->select('lecturers.*', 'users.name', 'users.email', 'users.matric_id')
                             ->paginate(10);
        } else {
            $lecturers = Lecturer::with('user')
                             ->orderBy($sortBy, $sortOrder)
                             ->paginate(10);
        }

        return view('lecturers.lecturer_index', compact('lecturers', 'sortBy', 'sortOrder'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('lecturers.lecturer_create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
       // Validate the request data and store the validated data in a variable
        $validated_data = $request->validate([
            'name' => 'required|string|max:255',
            'staff_no' => 'required|string|max:5|unique:users,matric_id',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'department' => 'required|string|max:255',
            'level' => 'required|in:Senior Lecturer,Head of Department,Dean,Deputy Dean',
        ]);

        // Create the user
        $user = new User();
        $user->name = $validated_data['name'];
        $user->matric_id = $validated_data['staff_no'];
        $user->email = $validated_data['email'];
        $user->password = Hash::make($validated_data['password']);
        $user->role = 'lecturer';
        // $user->last_login = now();
        $user->save();

        // Create the lecturer
        $lecturer = new Lecturer();
        $lecturer->user_id = $user->id;
        $lecturer->department = $validated_data['department'];
        $lecturer->lecturer_level = $validated_data['level'];
        $lecturer->save();

        // Redirect with success message
        return redirect()->route('lecturers.index')->with('message', 'Lecturer created successfully.');
    

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
        $lecturer = Lecturer::with('user')->findOrFail($id);

        return view('lecturers.lecturer_edit', compact('lecturer'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $lecturer = Lecturer::with('user')->findOrFail($id);

        $validated_data = $request->validate([
            'name' => 'required|string|max:255',
            'staff_no' => 'required|string|max:5|unique:users,matric_id,'. $lecturer->user->id,
            'email' => 'required|string|email|max:255|unique:users,email,'. $lecturer->user->id,
            'password' => 'nullable|string|min:8',
            'department' => 'required|string|max:255',
            'level' => 'required|in:Senior Lecturer,Head of Department,Dean,Deputy Dean',
        ]);

        $lecturer->user->name = $validated_data['name'];
        $lecturer->user->matric_id = $validated_data['staff_no'];
        $lecturer->user->email = $validated_data['email'];
        $lecturer->department = $validated_data['department'];
        $lecturer->lecturer_level = $validated_data['level'];

        if ($validated_data['password']) {
            $lecturer->user->password = Hash::make($validated_data['password']);
        }
        
        $lecturer->user->save();
        $lecturer->save();

        // Redirect with success message
        return redirect()->route('lecturers.index')->with('message', 'Lecturer has been updated successfully.');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $lecturer = Lecturer::with('user')->findOrFail($id);

        // Delete the associated user
        $lecturer->user->delete();
    
        // Delete the lecturer
        $lecturer->delete();

        return redirect()->route('lecturers.index')->with('message', 'Lecturer has been deleted successfully.');

    }

    public function find(Request $request)
    {
        if ($request->ajax()) {

            $lecturers = Lecturer::join('users', 'lecturers.user_id', '=', 'users.id')
                ->where(function($query) use ($request) {
                    $query->where('users.name', 'LIKE', "%{$request->search}%")
                        ->orWhere('users.matric_id', 'LIKE', "%{$request->search}%");
                })
                ->select('lecturers.*', 'users.name', 'users.email', 'users.matric_id')
                ->paginate(10);

            $output = '';
            $csrfToken = csrf_token();

            if ($lecturers->count() > 0) {
                $output .= '
                    <table class="table mt-3">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Staff No</th>
                                <th scope="col">Email</th>
                                <th scope="col">Department</th>
                                <th scope="col">Level</th>
                            </tr>
                        </thead>
                        <tbody>';
                
                foreach ($lecturers as $index => $lecturer) {
                    $output .= '
                        <tr>
                            <th scope="row">' . ($index + 1 + ($lecturers->currentPage() - 1) * $lecturers->perPage()) . '</th>
                            <td>' . $lecturer->name . '</td>
                            <td>' . $lecturer->matric_id . '</td>
                            <td>' . $lecturer->email . '</td>
                            <td>' . $lecturer->department . '</td>
                            <td>' . $lecturer->lecturer_level . '</td>
                            <td class="text-center">
                                <a href="' . route("lecturers.edit", $lecturer->id) . '" style="text-decoration: none">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-pencil">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4"/>
                                        <path d="M13.5 6.5l4 4"/>
                                    </svg>
                                </a>

                                <a href="javascript:void(0);" onclick="confirmDelete(' . $lecturer->id . ')" style="text-decoration: none">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-trash">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M4 7l16 0"/>
                                        <path d="M10 11l0 6"/>
                                        <path d="M14 11l0 6"/>
                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"/>
                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"/>
                                    </svg>
                                </a>
                                <form id="delete-form-' . $lecturer->id . '" action="' . route("lecturers.destroy", $lecturer->id) . '" method="POST" style="display: none;">
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
                                <div>Showing ' . $lecturers->firstItem() . ' to ' . $lecturers->lastItem() . ' of ' . $lecturers->total() . ' results</div>
                                <div>' . $lecturers->links() . '</div>
                            </div>';
            } else {
                $output .= 'No results';
            }

            // Add JavaScript for delete confirmation
            $output .= '
                <script>
                    function confirmDelete(lecturerId) {
                        if (confirm("Are you sure you want to delete this lecturer?")) {
                            document.getElementById("delete-form-" + lecturerId).submit();
                        }
                    }
                </script>';

            return $output;
        } else {
            // If it's not an AJAX request, just return the view
            return view('lecturers.lecturer_find');
        }
    }
}
