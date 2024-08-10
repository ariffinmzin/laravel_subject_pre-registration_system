@extends("layouts.master")

@section("content")
    <div class="card">
        <div class="card-header">Add Lecturer</div>
        <div class="card-body">
            @if (session("message"))
                <div class="alert alert-success mt-3">
                    <p>{{ session("message") }}</p>
                </div>
            @endif

            <form method="POST" action="{{ route("lecturers.store") }}">
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
                    <label for="staff_no" class="col-sm-2 col-form-label">
                        Staff No
                    </label>
                    <div class="col-sm-10">
                        <input
                            type="text"
                            id="staff_no"
                            name="staff_no"
                            class="form-control"
                            value="{{ old("staff_no") }}"
                        />
                    </div>
                    @error("staff_no")
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
                <div class="row mb-3">
                    <label for="department" class="col-sm-2 col-form-label">
                        Department
                    </label>

                    <div class="col-md-6">
                        <select
                            id="department"
                            class="form-control @error("department") is-invalid @enderror"
                            name="department"
                            required
                        >
                            <option value="" disabled selected>
                                Select Department
                            </option>
                            <option
                                value="Software Engineering"
                                {{ old("department") == "Software Engineering" ? "selected" : "" }}
                            >
                                Software Engineering
                            </option>
                            <option
                                value="Information Technology"
                                {{ old("department") == "Information Technology" ? "selected" : "" }}
                            >
                                Information Technology
                            </option>
                        </select>

                        @error("department")
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="level" class="col-sm-2 col-form-label">
                        Level
                    </label>

                    <div class="col-md-6">
                        <select
                            id="level"
                            class="form-control @error("level") is-invalid @enderror"
                            name="level"
                            required
                        >
                            <option value="" disabled selected>
                                Select Level
                            </option>
                            <option
                                value="Senior Lecturer"
                                {{ old("level") == "Senior Lecturer" ? "selected" : "" }}
                            >
                                Senior Lecturer
                            </option>
                            <option
                                value="Head of Department"
                                {{ old("level") == "Head of Department" ? "selected" : "" }}
                            >
                                Head of Department
                            </option>
                            <option
                                value="Dean"
                                {{ old("level") == "Dean" ? "selected" : "" }}
                            >
                                Dean
                            </option>
                            <option
                                value="Deputy Dean"
                                {{ old("level") == "Deputy Dean" ? "selected" : "" }}
                            >
                                Deputy Dean
                            </option>
                        </select>

                        @error("level")
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
