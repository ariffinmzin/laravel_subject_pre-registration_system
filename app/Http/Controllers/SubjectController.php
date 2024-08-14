<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Get the sort parameters or use default values
        $sortBy = $request->get('sort_by', 'id');
        $sortOrder = $request->get('sort_order', 'asc');

        // Fetch subjects and apply sorting
        $subjects = Subject::orderBy($sortBy, $sortOrder)->paginate(10);

        // Pass data to the view
        return view('subjects.subject_index', compact('subjects', 'sortBy', 'sortOrder'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $credit_options = Subject::CREDIT_OPTIONS;
        $year_options = Subject::YEAR_OPTIONS;
        $program_options = Subject::PROGRAM_OPTIONS;
        return view('subjects.subject_create', compact('credit_options', 'year_options', 'program_options'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // dd($request);
        $validated_data = $request->validate([
            'subject_name' => 'required|string|max:255',
            'subject_code' => 'required|string|max:8|unique:subjects,subject_code',
            'subject_credit' => 'required|integer',
            'subject_year' => 'required|integer',
            'subject_program' => 'required|string|max:7|in:BIT,BIP,BIS,BIW,BIM,Faculty,PPUK,CLS',
            'status' => 'string|in:available,not available',
        ]);

        $subject = new Subject();
        $subject->subject_name = $validated_data['subject_name'];
        $subject->subject_code = $validated_data['subject_code'];
        $subject->subject_credit = $validated_data['subject_credit'];
        $subject->subject_year = $validated_data['subject_year'];
        $subject->subject_program = $validated_data['subject_program'];
        $subject->status = $request->input('status', 'not available'); // Default to "not available" if not checked;
        $subject->save();

        return redirect()->route('subjects.index')->with('message', 'Subject created successfully.');
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
        $credit_options = Subject::CREDIT_OPTIONS;
        $year_options = Subject::YEAR_OPTIONS;
        $program_options = Subject::PROGRAM_OPTIONS;
        $subject = Subject::findOrFail($id);

        return view('subjects.subject_edit', compact('subject', 'credit_options', 'year_options', 'program_options'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $subject = Subject::findOrFail($id);

        $validated_data = $request->validate([
            'subject_name' => 'required|string|max:255',
            'subject_code' => 'required|string|max:8|unique:subjects,subject_code,' . $subject->id,
            'subject_credit' => 'required|integer',
            'subject_year' => 'required|integer',
            'subject_program' => 'required|string|max:7|in:BIT,BIP,BIS,BIW,BIM,Faculty,PPUK,CLS',
            'status' => 'string|in:available,not available',
        ]);


        $subject->subject_name = $validated_data['subject_name'];
        $subject->subject_code = $validated_data['subject_code'];
        $subject->subject_credit = $validated_data['subject_credit'];
        $subject->subject_year = $validated_data['subject_year'];
        $subject->subject_program = $validated_data['subject_program'];
        $subject->status = $request->input('status', 'not available'); // Default to "not available" if not checked;
        $subject->save();

        return redirect()->route('subjects.index')->with('message', 'Subject updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $subject = Subject::findOrFail($id);

        // Delete the subject
        $subject->delete();

        return redirect()->route('subjects.index')->with('message', 'Subject has been deleted successfully.');
    }

    public function find(Request $request)
    {
        if ($request->ajax()) {

            $subjects = Subject::where('subject_code', 'LIKE', "%{$request->search}%")
                ->orWhere('subject_name', 'LIKE', "%{$request->search}%")->paginate(10);

            $output = '';
            $csrfToken = csrf_token();

            if ($subjects->count() > 0) {
                $output .= '
                    <table class="table mt-3">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Subject Code</th>
                                <th scope="col">Subject Name</th>
                                <th scope="col">Credit</th>
                                <th scope="col">Program</th>
                                <th scope="col">Year</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>';

                foreach ($subjects as $index => $subject) {
                    $output .= '
                        <tr>
                            <th scope="row">' . ($index + 1 + ($subjects->currentPage() - 1) * $subjects->perPage()) . '</th>
                            <td>' . $subject->subject_code . '</td>
                            <td>' . $subject->subject_name . '</td>
                            <td>' . $subject->subject_credit . '</td>
                            <td>' . $subject->subject_program . '</td>
                            <td>' . $subject->subject_year . '</td>
                            <td>
                                <div class="form-check form-switch">
                                    <input
                                        class="form-check-input toggle-status"
                                        type="checkbox"
                                        role="switch"
                                        id="status-' . $subject->id . '"
                                        data-id="' . $subject->id . '"
                                        ' . ($subject->status === "available" ? "checked" : "") . '
                                    />
                                </div>
                            </td>
                            <td class="text-center">
                                <a href="' . route("subjects.edit", $subject->id) . '" style="text-decoration: none">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-pencil">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4"/>
                                        <path d="M13.5 6.5l4 4"/>
                                    </svg>
                                </a>
    
                                <a href="javascript:void(0);" onclick="confirmDelete(' . $subject->id . ')" style="text-decoration: none">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-trash">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M4 7l16 0"/>
                                        <path d="M10 11l0 6"/>
                                        <path d="M14 11l0 6"/>
                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"/>
                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"/>
                                    </svg>
                                </a>
                                <form id="delete-form-' . $subject->id . '" action="' . route("subjects.destroy", $subject->id) . '" method="POST" style="display: none;">
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
                                <div>Showing ' . $subjects->firstItem() . ' to ' . $subjects->lastItem() . ' of ' . $subjects->total() . ' results</div>
                                <div>' . $subjects->links() . '</div>
                            </div>';
            } else {
                $output .= 'No results';
            }

            // Add JavaScript for delete confirmation and status toggle
            $output .= '
                <script>
                    function confirmDelete(subjectId) {
                        if (confirm("Are you sure you want to delete this subject?")) {
                            document.getElementById("delete-form-" + subjectId).submit();
                        }
                    }
    
                    // Handle the status toggle
                    document.querySelectorAll(".toggle-status").forEach(function (toggle) {
                        toggle.addEventListener("change", function () {
                            var subjectId = this.getAttribute("data-id");
                            var status = this.checked ? "available" : "not available";
    
                            // Make AJAX request to update the status
                            console.log("Subject ID:", subjectId);
                            console.log("Status:", status);
    
                            fetch("/subjects/" + subjectId + "/status", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                    "X-CSRF-TOKEN": "' . $csrfToken . '",
                                },
                                body: JSON.stringify({ status: status }),
                            })
                                .then((response) => response.json())
                                .then((data) => {
                                    console.log("Response data:", data);
                                    if (!data.success) {
                                        alert("Failed to update status");
                                    }
                                })
                                .catch((error) => console.error("Error:", error));
                        });
                    });
                </script>';

            return $output;
        } else {
            // If it's not an AJAX request, just return the view
            return view('subjects.subject_find');
        }
    }

    public function updateStatus(Request $request, Subject $subject)
    {
        $request->validate([
            'status' => 'required|string|in:available,not available',
        ]);

        $subject->status = $request->status;
        $subject->save();

        return response()->json(['success' => true]);
    }
}
