@extends("layouts.master")

@section("content")
    <div class="card">
        <div class="card-header">Add Student</div>
        <div class="card-body">
            @if (session("message"))
                <div class="alert alert-success mt-3">
                    <p>{{ session("message") }}</p>
                </div>
            @endif

            <form method="POST" action="{{ route("students.store") }}">
                @csrf
                <div class="mb-3 row">
                    <label for="name" class="col-sm-2 col-form-label">
                        Name
                    </label>
                    <div class="col-sm-10">
                        <input
                            type="text"
                            id="name"
                            name="name"
                            class="form-control"
                            value="{{ old("name") }}"
                        />
                    </div>
                    @error("name")
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3 row">
                    <label for="matric_id" class="col-sm-2 col-form-label">
                        Matric Id
                    </label>
                    <div class="col-sm-10">
                        <input
                            type="text"
                            id="matric_id"
                            name="matric_id"
                            class="form-control"
                            value="{{ old("matric_id") }}"
                        />
                    </div>
                    @error("matric_id")
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3 row">
                    <label for="email" class="col-sm-2 col-form-label">
                        Email
                    </label>
                    <div class="col-sm-10">
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-control"
                            value="{{ old("email") }}"
                        />
                    </div>
                    @error("email")
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3 row">
                    <label for="password" class="col-sm-2 col-form-label">
                        Password
                    </label>
                    <div class="col-sm-10">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control"
                        />
                    </div>
                    @error("password")
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3 row">
                    <label
                        for="password_confirmation"
                        class="col-sm-2 col-form-label"
                    >
                        Confirm Password
                    </label>
                    <div class="col-sm-10">
                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            class="form-control"
                        />
                    </div>
                    @error("password_confirmation")
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="row mb-3">
                    <label for="pak" class="col-sm-2 col-form-label">PAK</label>

                    <div class="col-md-6">
                        <input
                            type="text"
                            name="pak"
                            id="pak"
                            class="form-control"
                            value="{{ old("pak") }}"
                            placeholder="Enter PAK name"
                        />

                        @error("pak")
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <!-- Year Select -->
                <div class="row mb-3">
                    <label for="year" class="col-sm-2 col-form-label">
                        Year
                    </label>

                    <div class="col-md-6">
                        <select
                            id="year"
                            class="form-control @error("year") is-invalid @enderror"
                            name="year"
                            required
                        >
                            <option value="" disabled selected>
                                Select Year
                            </option>
                            @foreach ($year_options as $value => $label)
                                <option
                                    value="{{ $value }}"
                                    {{ old("year") == $value ? "selected" : "" }}
                                >
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>

                        @error("year")
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <!-- Program Select -->
                <div class="row mb-3">
                    <label for="program" class="col-sm-2 col-form-label">
                        Program
                    </label>

                    <div class="col-md-6">
                        <select
                            id="program"
                            class="form-control @error("program") is-invalid @enderror"
                            name="program"
                            required
                        >
                            <option value="" disabled selected>
                                Select Program
                            </option>
                            @foreach ($program_options as $value => $label)
                                <option
                                    value="{{ $value }}"
                                    {{ old("program") == $value ? "selected" : "" }}
                                >
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>

                        @error("program")
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
@endsection

@section("scripts")
    <script type="text/javascript">
        $(document).ready(function () {
            $('#pak').autocomplete({
                source: function (request, response) {
                    $.ajax({
                        url: '/find-pak',
                        data: {
                            term: request.term,
                        },
                        dataType: 'json',
                        success: function (data) {
                            var resp = $.map(data, function (obj) {
                                return obj.name;
                            });
                            response(resp);
                        },
                    });
                },
                minLength: 2,
            });
        });
    </script>
@endsection
