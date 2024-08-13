@extends("layouts.master")

@section("content")
    <div class="card">
        <div class="card-header">List of Subjects</div>
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
                            href="{{ route("subjects.index", array_merge(request()->all(), ["sort_by" => "id", "sort_order" => $sortBy === "id" && $sortOrder === "asc" ? "desc" : "asc"])) }}"
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
                            href="{{ route("subjects.index", array_merge(request()->all(), ["sort_by" => "subject_code", "sort_order" => $sortBy === "subject_code" && $sortOrder === "asc" ? "desc" : "asc"])) }}"
                        >
                            Subject Code
                            @if ($sortBy === "subject_code")
                                <span>
                                    {{ $sortOrder === "asc" ? "▲" : "▼" }}
                                </span>
                            @endif
                        </a>
                    </th>
                    <th>
                        <a
                            href="{{ route("subjects.index", array_merge(request()->all(), ["sort_by" => "subject_name", "sort_order" => $sortBy === "subject_name" && $sortOrder === "asc" ? "desc" : "asc"])) }}"
                        >
                            Subject Name
                            @if ($sortBy === "subject_name")
                                <span>
                                    {{ $sortOrder === "asc" ? "▲" : "▼" }}
                                </span>
                            @endif
                        </a>
                    </th>
                    <th>
                        <a
                            href="{{ route("subjects.index", array_merge(request()->all(), ["sort_by" => "subject_credit", "sort_order" => $sortBy === "subject_credit" && $sortOrder === "asc" ? "desc" : "asc"])) }}"
                        >
                            Credit
                            @if ($sortBy === "subject_credit")
                                <span>
                                    {{ $sortOrder === "asc" ? "▲" : "▼" }}
                                </span>
                            @endif
                        </a>
                    </th>
                    <th>
                        <a
                            href="{{ route("subjects.index", array_merge(request()->all(), ["sort_by" => "subject_program", "sort_order" => $sortBy === "subject_program" && $sortOrder === "asc" ? "desc" : "asc"])) }}"
                        >
                            Program
                            @if ($sortBy === "subject_program")
                                <span>
                                    {{ $sortOrder === "asc" ? "▲" : "▼" }}
                                </span>
                            @endif
                        </a>
                    </th>
                    <th>
                        <a
                            href="{{ route("subjects.index", array_merge(request()->all(), ["sort_by" => "subject_year", "sort_order" => $sortBy === "subject_year" && $sortOrder === "asc" ? "desc" : "asc"])) }}"
                        >
                            Year
                            @if ($sortBy === "subject_year")
                                <span>
                                    {{ $sortOrder === "asc" ? "▲" : "▼" }}
                                </span>
                            @endif
                        </a>
                    </th>
                    <th>
                        <a
                            href="{{ route("subjects.index", array_merge(request()->all(), ["sort_by" => "status", "sort_order" => $sortBy === "status" && $sortOrder === "asc" ? "desc" : "asc"])) }}"
                        >
                            Status
                            @if ($sortBy === "status")
                                <span>
                                    {{ $sortOrder === "asc" ? "▲" : "▼" }}
                                </span>
                            @endif
                        </a>
                    </th>
                    <th class="text-center">Action</th>
                </tr>
                @foreach ($subjects as $subject)
                    <tr>
                        <td>
                            {{ ($subjects->currentPage() - 1) * $subjects->perPage() + $loop->iteration }}
                        </td>
                        <td>{{ $subject->subject_code }}</td>
                        <td>{{ $subject->subject_name }}</td>
                        <td>{{ $subject->subject_credit }}</td>
                        <td>{{ $subject->subject_program }}</td>
                        <td>{{ $subject->subject_year }}</td>
                        <td>
                            <div class="form-check form-switch">
                                <input
                                    class="form-check-input toggle-status"
                                    type="checkbox"
                                    role="switch"
                                    id="status-{{ $subject->id }}"
                                    data-id="{{ $subject->id }}"
                                    {{ $subject->status === "available" ? "checked" : "" }}
                                />
                            </div>
                        </td>
                        <td class="text-center">
                            <a
                                href="{{ route("subjects.edit", $subject->id) }}"
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
                                data-id="{{ $subject->id }}"
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
                                id="delete-form-{{ $subject->id }}"
                                action="{{ route("subjects.destroy", $subject->id) }}"
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
                    Showing {{ $subjects->firstItem() }} to
                    {{ $subjects->lastItem() }} of {{ $subjects->total() }}
                    results
                </div>
                <div>
                    {{ $subjects->links() }}
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
                    Are you sure you want to delete this subject?
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
                var subjectId = button.getAttribute('data-id');
                deleteForm = document.getElementById(
                    'delete-form-' + subjectId,
                );
            });

            confirmDeleteBtn.addEventListener('click', function () {
                deleteForm.submit();
            });
        });

        // Handle the status toggle
        document.querySelectorAll('.toggle-status').forEach(function (toggle) {
            toggle.addEventListener('change', function () {
                var subjectId = this.getAttribute('data-id');
                var status = this.checked ? 'available' : 'not available';

                // Make AJAX request to update the status
                console.log('Subject ID:', subjectId);
                console.log('Status:', status);

                fetch(`/subjects/${subjectId}/status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({ status: status }),
                })
                    .then((response) => response.json())
                    .then((data) => {
                        console.log('Response data:', data);
                        if (!data.success) {
                            alert('Failed to update status');
                        }
                    })
                    .catch((error) => console.error('Error:', error));
            });
        });
    </script>
@endsection
