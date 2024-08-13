@extends("layouts.master")

@section("content")
    <div class="card">
        <div class="card-header">Add Subject</div>
        <div class="card-body">
            @if (session("message"))
                <div class="alert alert-success mt-3">
                    <p>{{ session("message") }}</p>
                </div>
            @endif

            <form method="POST" action="{{ route("subjects.store") }}">
                @csrf
                <div class="mb-3 row">
                    <label for="subject_code" class="col-sm-2 col-form-label">
                        Subject Code
                    </label>
                    <div class="col-sm-10">
                        <input
                            type="text"
                            id="subject_code"
                            name="subject_code"
                            class="form-control"
                            value="{{ old("subject_code") }}"
                            oninput="this.value = this.value.toUpperCase().replace(/\s+/g, '')"
                        />
                    </div>
                    <!-- This regular expression (\s+) matches any whitespace character (including spaces, tabs, etc.) and replaces them with an empty string (''), effectively removing them from the input. -->
                    @error("subject_code")
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3 row">
                    <label for="subject_name" class="col-sm-2 col-form-label">
                        Subject Name
                    </label>
                    <div class="col-sm-10">
                        <input
                            type="text"
                            id="subject_name"
                            name="subject_name"
                            class="form-control"
                            value="{{ old("subject_name") }}"
                        />
                    </div>
                    @error("subject_name")
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="row mb-3">
                    <label for="subject_credit" class="col-sm-2 col-form-label">
                        Subject Credit
                    </label>

                    <div class="col-md-6">
                        <select
                            id="subject_credit"
                            class="form-control @error("subject_credit") is-invalid @enderror"
                            name="subject_credit"
                            required
                        >
                            <option value="" disabled selected>
                                Select Credit
                            </option>
                            @foreach ($credit_options as $value => $label)
                                <option
                                    value="{{ $value }}"
                                    {{ old("subject_credit") == $value ? "selected" : "" }}
                                >
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>

                        @error("subject_credit")
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label
                        for="subject_program"
                        class="col-sm-2 col-form-label"
                    >
                        Subject Program
                    </label>

                    <div class="col-md-6">
                        <select
                            id="subject_program"
                            class="form-control @error("subject_program") is-invalid @enderror"
                            name="subject_program"
                            required
                        >
                            <option value="" disabled selected>
                                Select Program
                            </option>
                            @foreach ($program_options as $value => $label)
                                <option
                                    value="{{ $value }}"
                                    {{ old("subject_program") == $value ? "selected" : "" }}
                                >
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>

                        @error("subject_program")
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="subject_year" class="col-sm-2 col-form-label">
                        Subject Year
                    </label>

                    <div class="col-md-6">
                        <select
                            id="subject_year"
                            class="form-control @error("subject_year") is-invalid @enderror"
                            name="subject_year"
                            required
                        >
                            <option value="" disabled selected>
                                Select Year
                            </option>
                            @foreach ($year_options as $value => $label)
                                <option
                                    value="{{ $value }}"
                                    {{ old("subject_year") == $value ? "selected" : "" }}
                                >
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>

                        @error("subject_year")
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="status" class="col-sm-2 col-form-label">
                        Status
                    </label>

                    <div class="col-md-6 mt-2">
                        <div class="form-check form-switch">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                role="switch"
                                id="status"
                                name="status"
                                value="available"
                                {{ old("status", $subject->status ?? "not available") == "available" ? "checked" : "" }}
                                onchange="toggleStatusLabel()"
                            />
                            <label
                                class="form-check-label"
                                for="status"
                                id="status-label"
                            >
                                {{ old("status", $subject->status ?? "not available") == "available" ? "Available" : "Unavailable" }}
                            </label>
                        </div>
                        @error("status")
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
@endsection

@section("scripts")
    <script>
        function toggleStatusLabel() {
            const statusCheckbox = document.getElementById('status');
            const statusLabel = document.getElementById('status-label');

            if (statusCheckbox.checked) {
                statusLabel.textContent = 'Available';
            } else {
                statusLabel.textContent = 'Unavailable';
            }
        }

        // Initialize label on page load
        document.addEventListener('DOMContentLoaded', (event) => {
            toggleStatusLabel();
        });
    </script>
@endsection
