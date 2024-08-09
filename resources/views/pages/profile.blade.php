@extends("layouts.master")

@section("content")
    <div class="card">
        <div class="card-header">Profile</div>
        <div class="card-body">
            @if (session("message"))
                <div class="alert alert-success mt-3">
                    <p>{{ session("message") }}</p>
                </div>
            @endif

            <form method="POST" action="{{ route("profile.post") }}">
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
                            value="{{ old("name", $user->name) }}"
                        />
                    </div>
                    @error("name")
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
                            value="{{ old("email", $user->email) }}"
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
                            aria-describedby="passwordHelpBlock"
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
                        Password Confirmation
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

                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
@endsection
