@can("is-admin")
    <a
        href="{{ route("admin.dashboard") }}"
        class="btn btn-success w-100 mb-2"
    >
        Home
    </a>

    <a href="{{ route("students.index") }}" class="btn btn-info w-100 mb-2">
        View Student
    </a>
    <a href="{{ route("students.create") }}" class="btn btn-info w-100 mb-2">
        Add Student
    </a>
    <a href="" class="btn btn-info w-100 mb-2">Find Student</a>

    <a href="{{ route("lecturers.index") }}" class="btn btn-dark w-100 mb-2">
        View Lecturer
    </a>
    <a href="{{ route("lecturers.create") }}" class="btn btn-dark w-100 mb-2">
        Add Lecturer
    </a>
    <a href="{{ route("lecturers.find") }}" class="btn btn-dark w-100 mb-2">
        Find Lecturer
    </a>
    <a href="" class="btn btn-primary w-100 mb-2">View Subject</a>
    <a href="" class="btn btn-primary w-100 mb-2">Add Subject</a>
    <a href="" class="btn btn-primary w-100 mb-2">Edit Subject</a>
    <a href="" class="btn btn-primary w-100 mb-2">Delete Subject</a>
@endcan

<a href="{{ route("profile.get") }}" class="btn btn-secondary w-100 mb-2">
    Profile
</a>
<!-- <a href="" class="btn btn-primary w-100 mb-2">Logout</a> -->
<button
    type="button"
    class="btn btn-danger w-100 mb-2"
    onclick="document.getElementById('logout-form').submit();"
>
    Logout
</button>
