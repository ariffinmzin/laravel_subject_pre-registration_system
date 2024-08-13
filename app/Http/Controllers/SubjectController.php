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
