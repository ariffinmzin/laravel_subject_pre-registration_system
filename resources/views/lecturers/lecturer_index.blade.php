@extends("layouts.master")

@section("content")
    <div class="card">
        <div class="card-header">List of Lecturers</div>
        <div class="card-body">
            @if (session("message"))
                <div class="alert alert-success mt-3">
                    <p>{{ session("message") }}</p>
                </div>
            @endif

            <table class="table">
                <!-- <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Staff No</th>
                    <th>Email</th>
                    <th>Department</th>
                    <th>Level</th>
                    <th class="text-center">Action</th>
                </tr> -->

                <tr>
                    <th>
                        <a
                            href="{{ route("lecturers.index", array_merge(request()->all(), ["sort_by" => "id", "sort_order" => $sortBy === "id" && $sortOrder === "asc" ? "desc" : "asc"])) }}"
                        >
                            #
                            @if ($sortBy === "id")
                                <span>
                                    {{ $sortOrder === "asc" ? "▲" : "▼" }}
                                </span>
                            @endif
                        </a>
                    </th>
                    <th>
                        <a
                            href="{{ route("lecturers.index", ["sort_by" => "name", "sort_order" => $sortBy === "name" && $sortOrder === "asc" ? "desc" : "asc"]) }}"
                        >
                            Name
                            @if ($sortBy === "name")
                                <span>
                                    {{ $sortOrder === "asc" ? "▲" : "▼" }}
                                </span>
                            @endif
                        </a>
                    </th>
                    <th>
                        <a
                            href="{{ route("lecturers.index", array_merge(request()->all(), ["sort_by" => "matric_id", "sort_order" => $sortBy === "matric_id" && $sortOrder === "asc" ? "desc" : "asc"])) }}"
                        >
                            Staff No
                            @if ($sortBy === "matric_id")
                                <span>
                                    {{ $sortOrder === "asc" ? "▲" : "▼" }}
                                </span>
                            @endif
                        </a>
                    </th>
                    <th>
                        <a
                            href="{{ route("lecturers.index", array_merge(request()->all(), ["sort_by" => "email", "sort_order" => $sortBy === "email" && $sortOrder === "asc" ? "desc" : "asc"])) }}"
                        >
                            Email
                            @if ($sortBy === "email")
                                <span>
                                    {{ $sortOrder === "asc" ? "▲" : "▼" }}
                                </span>
                            @endif
                        </a>
                    </th>
                    <th>
                        <a
                            href="{{ route("lecturers.index", array_merge(request()->all(), ["sort_by" => "department", "sort_order" => $sortBy === "department" && $sortOrder === "asc" ? "desc" : "asc"])) }}"
                        >
                            Department
                            @if ($sortBy === "department")
                                <span>
                                    {{ $sortOrder === "asc" ? "▲" : "▼" }}
                                </span>
                            @endif
                        </a>
                    </th>
                    <th>
                        <a
                            href="{{ route("lecturers.index", array_merge(request()->all(), ["sort_by" => "lecturer_level", "sort_order" => $sortBy === "lecturer_level" && $sortOrder === "asc" ? "desc" : "asc"])) }}"
                        >
                            Level
                            @if ($sortBy === "lecturer_level")
                                <span>
                                    {{ $sortOrder === "asc" ? "▲" : "▼" }}
                                </span>
                            @endif
                        </a>
                    </th>
                    <th class="text-center">Action</th>
                </tr>
                @foreach ($lecturers as $lecturer)
                    <tr>
                        <td>
                            {{ ($lecturers->currentPage() - 1) * $lecturers->perPage() + $loop->iteration }}
                        </td>
                        <!-- Increment number -->
                        <td>{{ $lecturer->user->name }}</td>
                        <td>{{ $lecturer->user->matric_id }}</td>
                        <td>{{ $lecturer->user->email }}</td>
                        <td>{{ $lecturer->department }}</td>
                        <td>{{ $lecturer->lecturer_level }}</td>
                        <td class="text-center">
                            <a
                                href="{{ route("lecturers.edit", $lecturer->id) }}"
                                style="text-decoration: none"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icon-tabler-pencil"
                                >
                                    <path
                                        stroke="none"
                                        d="M0 0h24v24H0z"
                                        fill="none"
                                    />
                                    <path
                                        d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4"
                                    />
                                    <path d="M13.5 6.5l4 4" />
                                </svg>
                            </a>

                            <a
                                href="javascript:void(0);"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteModal"
                                data-id="{{ $lecturer->id }}"
                                style="text-decoration: none"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="icon icon-tabler icon-tabler-trash"
                                >
                                    <path
                                        stroke="none"
                                        d="M0 0h24v24H0z"
                                        fill="none"
                                    />
                                    <path d="M4 7l16 0" />
                                    <path d="M10 11l0 6" />
                                    <path d="M14 11l0 6" />
                                    <path
                                        d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"
                                    />
                                    <path
                                        d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"
                                    />
                                </svg>
                            </a>
                            <form
                                id="delete-form-{{ $lecturer->id }}"
                                action="{{ route("lecturers.destroy", $lecturer->id) }}"
                                method="POST"
                                style="display: none"
                            >
                                @csrf
                                @method("DELETE")
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
            <!-- Pagination links -->
            <!-- <div class="d-flex justify-content-center">
                {{ $lecturers->links() }}
            </div> -->

            <div class="d-flex justify-content-between justify-content-center">
                <div>
                    Showing {{ $lecturers->firstItem() }} to
                    {{ $lecturers->lastItem() }} of {{ $lecturers->total() }}
                    results
                </div>
                <div>
                    {{ $lecturers->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div
        class="modal fade"
        id="deleteModal"
        tabindex="-1"
        role="dialog"
        aria-labelledby="deleteModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">
                        Delete Confirmation
                    </h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this lecturer?
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >
                        Cancel
                    </button>
                    <button
                        type="button"
                        class="btn btn-danger"
                        id="confirmDeleteBtn"
                    >
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("scripts")
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var deleteModal = document.getElementById('deleteModal');
            var confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
            var deleteForm;

            deleteModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
                var lecturerId = button.getAttribute('data-id');
                deleteForm = document.getElementById(
                    'delete-form-' + lecturerId,
                );
            });

            confirmDeleteBtn.addEventListener('click', function () {
                deleteForm.submit();
            });
        });
    </script>
@endsection
