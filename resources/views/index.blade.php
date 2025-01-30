<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>form</title>
    <link rel="stylesheet" href="">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f7f7;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #2c3e50;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            color: #34495e;
        }

        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            box-sizing: border-box;
        }

        button {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
            margin: 10px 0;
        }

        button:hover {
            background-color: #2980b9;
        }

        .clone {
            margin-bottom: 20px;
        }

        .cloned {
            margin-top: 10px;
        }

        .form-group input {
            margin-bottom: 10px;
        }

        .added-forms {
            margin-top: 20px;
        }

        .added-forms div {
            background-color: #ecf0f1;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 4px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .added-forms span {
            font-size: 14px;
            color: #34495e;
        }

        .added-forms a {
            color: #3498db;
            text-decoration: none;
            font-weight: bold;
        }

        .added-forms a:hover {
            text-decoration: underline;
        }

        .home-link {
            font-size: 14px;
            display: inline-block;
            margin-bottom: 20px;
            color: #2c3e50;
        }

        .home-link a {
            color: #3498db;
            text-decoration: none;
        }

        .home-link a:hover {
            text-decoration: underline;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {

            $("#add_btn").on("click", function() {
                const form = document.querySelector('.clone');
                const form2 = document.querySelector('.cloned');
                const clone = form.cloneNode(true);
                const inputs = clone.querySelectorAll('input');
                inputs.forEach(input => input.value = '');
                form2.append(clone);
            });

            $("#remove_btn").on("click", function() {
                $(".cloned").find("div:last").remove();
            });
            // var maxNum = -1;
            // $("#user_table tr").each(function() {
            //     const firstTdValue = parseInt($(this).find("td:first").text());
            //     if (!isNaN(firstTdValue) && firstTdValue > maxNum) {
            //         maxNum = firstTdValue; // Update max number if a new higher number is found
            //     }

            // });

            // console.log(typeof(maxNum));
            $("#search").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                console.log(value);
                $("#user_table tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
            $('#input').submit(function(e) {
                e.preventDefault();

                const forms = document.querySelectorAll('.clone');
                let data = [];
                forms.forEach((container, index) => {
                    const jname = container.querySelector('input[name="name"]').value;
                    const jemail = container.querySelector('input[name="email"]').value;

                    const IsRouteEdit = @json(Route::currentRouteName() === 'forms.edit');
                    data.push({
                        name: jname,
                        email: jemail
                    })
                });

                const url =
                    '{{ Route::currentRouteName() === 'forms.edit' ? route('forms.update', $id) : route('forms.store') }}';
                const method = '{{ Route::currentRouteName() === 'forms.edit' ? 'PATCH' : 'POST' }}';
                console.log(method);

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr(
                            'content'),
                        _method: method,
                        inputdata: data,
                    },

                    success: function(response) {

                        console.log(response.message);


                        $('#input').trigger("reset");


                        window.location.href =
                            "{{ route('forms.index') }}";
                    },

                });
            });
        });
    </script>
</head>

<body>

    <form class="input-form" id="input" method="post">

        @csrf
        @if (Route::currentRouteName() === 'forms.edit')
            <a href="/">Home</a>
        @endif
        <a href="/logout">Logout</a>
        <div class="clone">
            <field class="form-group">
                <label>Name:</label>
                <input type="text" name="name" id="name"
                    value="{{ old('name', isset($for['name']) ? $for['name'] : '') }}" required>
            </field>
            <field class="form-group">
                <label>E-mail:</label>
                <input type="email" name="email" id="email"
                    value = "{{ old('email', isset($for['email']) ? $for['email'] : '') }}" required>

            </field>
        </div>
        <div class="cloned">

        </div>
        @if (Route::currentRouteName() !== 'forms.edit')
            <button type="button" id="remove_btn">Remove</button>
            <button type="button" id="add_btn">Add</button>
        @endif

        <button type="submit" id="submit-btn">save</button>
    </form>

    <input type="text" id="search" placeholder="Search...">

    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th>Id</th>
                <th>User Name</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>

        @forelse ($forms as $for)
            <tbody id="user_table">
                <tr>
                    <td>{{ $for['id'] }}</td>
                    <td>{{ $for['name'] }}</td>
                    <td>{{ $for['email'] }}</td>
                    <td>
                        <a href="{{ route('forms.edit', $for['id']) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('forms.destroy', $for['id']) }}" method="post" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure you want to delete User?')">DELETE</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No Data Available.</td>
                </tr>
        @endforelse

        </tbody>
    </table>


</body>

</html>
