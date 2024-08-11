@extends("layouts.master")

@section("content")
    <div class="card">
        <div class="card-header">Student Information</div>
        <div class="card-body">
            @if (session("message"))
                <div class="alert alert-success mt-3">
                    <p>{{ session("message") }}</p>
                </div>
            @endif

            <form action="">
                @method("PUT")
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
                            value="{{ $student->user->name }}"
                            disabled
                        />
                    </div>
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
                            value="{{ $student->user->matric_id }}"
                            disabled
                        />
                    </div>
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
                            value="{{ $student->user->email }}"
                            disabled
                        />
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="pak" class="col-sm-2 col-form-label">PAK</label>

                    <div class="col-md-6">
                        <input
                            type="text"
                            name="pak"
                            id="pak"
                            class="form-control"
                            value="{{ $student->lecturer->user->name }}"
                            disabled
                        />
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="year" class="col-sm-2 col-form-label">
                        Year
                    </label>

                    <div class="col-md-6">
                        <input
                            type="text"
                            name="year"
                            id="year"
                            class="form-control"
                            value="{{ $student->year_of_study }}"
                            disabled
                        />
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="program" class="col-sm-2 col-form-label">
                        Program
                    </label>

                    <div class="col-md-6">
                        <input
                            type="text"
                            name="program"
                            id="program"
                            class="form-control"
                            value="{{ $student->program }}"
                            disabled
                        />
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="status" class="col-sm-2 col-form-label">
                        Status
                    </label>
                    <div class="col-md-6">
                        <div class="form-check">
                            <input
                                class="form-check-input"
                                type="radio"
                                name="status"
                                id="unregistered"
                                value="unregistered"
                                {{ $student->status == "unregistered" ? "checked" : "" }}
                                disabled
                            />
                            <label class="form-check-label" for="unregistered">
                                Unregistered
                            </label>
                        </div>
                        <div class="form-check mt-2">
                            <!-- Added mt-2 for spacing -->
                            <input
                                class="form-check-input"
                                type="radio"
                                name="status"
                                id="registered"
                                value="registered"
                                {{ $student->status == "registered" ? "checked" : "" }}
                                disabled
                            />
                            <label class="form-check-label" for="registered">
                                Registered
                            </label>
                        </div>
                    </div>
                </div>
                <!-- Back Button -->
                <div class="d-flex justify-content-start mt-3">
                    <a
                        href="{{ route("students.index") }}"
                        class="btn btn-primary"
                    >
                        Back
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
