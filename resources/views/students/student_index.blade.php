@extends("layouts.master")

@section("content")
    <div class="card">
        <div class="card-header">List of Students</div>
        <div class="card-body">
            @if (session("message"))
                <div class="alert alert-success mt-3">
                    <p>{{ session("message") }}</p>
                </div>
            @endif

            <table class="table">
                <tr>
                    <th>
                        <a
                            href="{{ route("students.index", array_merge(request()->all(), ["sort_by" => "id", "sort_order" => $sortBy === "id" && $sortOrder === "asc" ? "desc" : "asc"])) }}"
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
                            href="{{ route("students.index", array_merge(request()->all(), ["sort_by" => "name", "sort_order" => $sortBy === "name" && $sortOrder === "asc" ? "desc" : "asc"])) }}"
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
                            href="{{ route("students.index", array_merge(request()->all(), ["sort_by" => "matric_id", "sort_order" => $sortBy === "matric_id" && $sortOrder === "asc" ? "desc" : "asc"])) }}"
                        >
                            Matric Id
                            @if ($sortBy === "matric_id")
                                <span>
                                    {{ $sortOrder === "asc" ? "▲" : "▼" }}
                                </span>
                            @endif
                        </a>
                    </th>
                    <th>
                        <a
                            href="{{ route("students.index", array_merge(request()->all(), ["sort_by" => "email", "sort_order" => $sortBy === "email" && $sortOrder === "asc" ? "desc" : "asc"])) }}"
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
                            href="{{ route("students.index", array_merge(request()->all(), ["sort_by" => "year_of_study", "sort_order" => $sortBy === "year_of_study" && $sortOrder === "asc" ? "desc" : "asc"])) }}"
                        >
                            Year
                            @if ($sortBy === "year_of_study")
                                <span>
                                    {{ $sortOrder === "asc" ? "▲" : "▼" }}
                                </span>
                            @endif
                        </a>
                    </th>
                    <th>
                        <a
                            href="{{ route("students.index", array_merge(request()->all(), ["sort_by" => "program", "sort_order" => $sortBy === "program" && $sortOrder === "asc" ? "desc" : "asc"])) }}"
                        >
                            Program
                            @if ($sortBy === "program")
                                <span>
                                    {{ $sortOrder === "asc" ? "▲" : "▼" }}
                                </span>
                            @endif
                        </a>
                    </th>
                    <th class="text-center">Action</th>
                </tr>
                @foreach ($students as $student)
                    <tr>
                        <td>
                            {{ ($students->currentPage() - 1) * $students->perPage() + $loop->iteration }}
                        </td>
                        <!-- Increment number -->
                        <td>{{ $student->user->name }}</td>
                        <td>{{ $student->user->matric_id }}</td>
                        <td>{{ $student->user->email }}</td>
                        <td>{{ $student->year_of_study }}</td>
                        <td>{{ $student->program }}</td>
                        <td class="text-center">
                            <a
                                href="{{ route("students.edit", $student->id) }}"
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
                                data-id="{{ $student->id }}"
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
                                id="delete-form-{{ $student->id }}"
                                action="{{ route("students.destroy", $student->id) }}"
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
            <div class="d-flex justify-content-between justify-content-center">
                <div>
                    Showing {{ $students->firstItem() }} to
                    {{ $students->lastItem() }} of {{ $students->total() }}
                    results
                </div>
                <div>
                    {{ $students->links() }}
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
                var studentId = button.getAttribute('data-id');
                deleteForm = document.getElementById(
                    'delete-form-' + studentId,
                );
            });

            confirmDeleteBtn.addEventListener('click', function () {
                deleteForm.submit();
            });
        });
    </script>
@endsection
