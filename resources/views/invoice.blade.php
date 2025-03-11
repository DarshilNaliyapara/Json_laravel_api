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
            background-color: #ecf0f1;
            color: #333;
            margin: 0;
            padding: 20px;
            display: flex;
            border-radius: 8px;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .container {
            width: 90%;
            max-width: 800px;
            background-color: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #2c3e50;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 6px;
            margin-top: 6px;
            color: #34495e;
        }

        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #bdc3c7;
            border-radius: 6px;
            font-size: 16px;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus,
        input[type="email"]:focus {
            border-color: #3498db;
            outline: none;
        }

        button {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 12px 25px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 6px;
            transition: background-color 0.3s;
            margin: 10px 5px;
        }

        button:hover {
            background-color: #2980b9;
        }

        .clone {
            padding: 15px;
            background: #f9f9f9;
            border-radius: 6px;
            margin-bottom: 15px;
        }

        .cloned {
            margin-top: 15px;
        }

        .added-forms {
            margin-top: 20px;
        }

        .added-forms div {
            background-color: #ecf0f1;
            padding: 12px;
            border-radius: 6px;
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

        #search {
            width: 50%;
            padding: 10px;
            margin: 20px 0;
            border: 1px solid #bdc3c7;
            border-radius: 6px;
            font-size: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        table th,
        table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #2c3e50;
            color: white;
            font-weight: bold;
        }

        table tbody tr:hover {
            background-color: #f1f1f1;
        }

        table td a,
        table td button {
            padding: 8px 12px;
            font-size: 14px;
            text-decoration: none;
            border-radius: 4px;
        }

        table td .btn-warning {
            background-color: #f39c12;
            color: white;
            border: none;
        }

        table td .btn-danger {
            background-color: #e74c3c;
            color: white;
            border: none;
        }

        table td .btn-warning:hover {
            background-color: #e67e22;
        }

        table td .btn-danger:hover {
            background-color: #c0392b;
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
                let form = document.getElementById('input')
                let inputData = new FormData(form);

                // let val = new URLSearchParams($("#input").serialize());
                // val.delete("_token");
                // console.log(val);

                // const inputdata = new FormData(document.querySelectorAll('.clone'));
                // console.log(inputdata.get('email'));
                // const forms = document.querySelectorAll('.clone');
                // let data = [];
                // forms.forEach((container, index) => {
                //     const jname = container.querySelector('input[name="name"]').value;
                //     const jemail = container.querySelector('input[name="email"]').value;

                //     const IsRouteEdit = @json(Route::currentRouteName() === 'forms.edit');
                //     data.push({
                //         name: jname,
                //         email: jemail
                //     })
                // });


                const method = '{{ Route::currentRouteName() === 'forms.edit' ? 'PATCH' : 'POST' }}';
                console.log(method);


                $.ajax({
                    url: "{{ route('forms.store') }}",
                    type: 'post',
                    data: inputData,
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                    },
                    processData: false,
                    contentType: false,

                    success: function(response) {

                        console.log(response.message);


                        $('#input').trigger("reset");


                        window.location.href =
                            "{{ route('forms.index') }}";
                    },
                    error: function(xhr) {
                        console.log(xhr.responseJSON);
                    }

                });
            });
        });
    </script>
</head>

<body>
    <h1>
        {{ $title }}
    </h1>
    <h2>{{ $date }}</h2>
    
    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th>Id</th>
                <th>User Name</th>
                <th>Email</th>

            </tr>
        </thead>

        @forelse ($users as $user)
            <tbody id="user_table">
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>

                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No Data Available.</td>
                </tr>
        @endforelse

        </tbody>
    </table>


    <table class="table table-bordered table-striped table-hover" style="margin-top: 15px">
        <thead>
            <tr>
                <th>Id</th>
                <th>User Name</th>
                <th>Email</th>

            </tr>
        </thead>

        @forelse ($forms as $form)
            <tbody id="user_table">
                <tr>
                    <td>{{ $form["id"]}}</td>
                    <td>{{ $form["name"] }}</td>
                    <td>{{ $form["email"] }}</td>

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
