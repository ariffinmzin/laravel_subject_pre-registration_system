@extends("layouts.master")

@section("content")
    <div class="card">
        <div class="card-header">Find Student</div>
        <div class="card-body">
            @if (session("message"))
                <div class="alert alert-success mt-3">
                    <p>{{ session("message") }}</p>
                </div>
            @endif

            <input
                type="text"
                name="search"
                id="search"
                placeholder="Enter name or matric id"
                class="form-control"
                onfocus="this.value=''"
            />

            <div id="search_list"></div>
        </div>
    </div>
@endsection

@section("scripts")
    <script>
        $(document).ready(function () {
            $('#search').on('keyup', function () {
                var query = $(this).val();
                $.ajax({
                    url: '/students/find',
                    type: 'GET',
                    data: { search: query },
                    success: function (data) {
                        $('#search_list').html(data);
                    },
                });
                //end of ajax call
            });
        });
    </script>
@endsection
