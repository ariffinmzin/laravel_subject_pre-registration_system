<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>{{ config("app.name", "Laravel") }}</title>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.bunny.net" />
        <link
            href="https://fonts.bunny.net/css?family=Nunito"
            rel="stylesheet"
        />

        <!-- Scripts -->
        @vite(["resources/sass/app.scss", "resources/js/app.js"])

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- jQuery UI -->
        <link
            rel="stylesheet"
            href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"
        />
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    </head>
    <body>
        <div id="app">
            <nav
                class="navbar navbar-expand-md navbar-light bg-white shadow-sm"
            >
                <div class="container">
                    <a class="navbar-brand" href="{{ url("/") }}">
                        {{ config("app.name", "Laravel") }}
                    </a>
                    <button
                        class="navbar-toggler"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent"
                        aria-expanded="false"
                        aria-label="{{ __("Toggle navigation") }}"
                    >
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div
                        class="collapse navbar-collapse"
                        id="navbarSupportedContent"
                    >
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav me-auto"></ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ms-auto">
                            <!-- Authentication Links -->
                            @guest
                                @if (Route::has("login"))
                                    <li class="nav-item">
                                        <a
                                            class="nav-link"
                                            href="{{ route("login") }}"
                                        >
                                            {{ __("Login") }}
                                        </a>
                                    </li>
                                @endif

                                @if (Route::has("register"))
                                    <li class="nav-item">
                                        <a
                                            class="nav-link"
                                            href="{{ route("register") }}"
                                        >
                                            {{ __("Register") }}
                                        </a>
                                    </li>
                                @endif
                            @else
                                <li class="nav-item dropdown">
                                    <a
                                        id="navbarDropdown"
                                        class="nav-link dropdown-toggle"
                                        href="#"
                                        role="button"
                                        data-bs-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false"
                                        v-pre
                                    >
                                        {{ Auth::user()->name }}
                                    </a>

                                    <div
                                        class="dropdown-menu dropdown-menu-end"
                                        aria-labelledby="navbarDropdown"
                                    >
                                        <a
                                            class="dropdown-item"
                                            href="{{ route("logout") }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"
                                        >
                                            {{ __("Logout") }}
                                        </a>

                                        <form
                                            id="logout-form"
                                            action="{{ route("logout") }}"
                                            method="POST"
                                            class="d-none"
                                        >
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>

            <main class="py-4">
                <!-- 5 -->
                <div class="container">
                    <div class="row">
                        <div class="col-md-2">
                            @include("components.menu")
                            <!-- <a href="" class="btn btn-primary w-100">Home</a> -->
                        </div>

                        <div class="col-md-10">
                            @yield("content")
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <!-- Footer -->
        <footer class="bg-light text-center py-3 mt-4">
            <div class="container">
                <p class="mb-0">
                    &copy; {{ date("Y") }} developed by
                    <a href="https://ariffinmzin.com" target="_blank">
                        ariffinmzin
                    </a>
                </p>
            </div>
        </footer>

        @yield("scripts")
    </body>
</html>
