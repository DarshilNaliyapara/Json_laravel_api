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

            $('#input').submit(function(e) {
                e.preventDefault();

                const forms = document.querySelectorAll('.clone');
                let data = [];

                forms.forEach((container, index) => {

                    const search = container.querySelector('input[name="search"]').value;
                    const _id = $('#id').val();


                });
                data.push({

                    name: search,

                });


                $.ajax({
                    url: '{{ route('test.search') }}',
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr(
                            'content'),
                        _method: 'POST',
                        inputdata: data,
                    },

                    success: function(response) {

                        console.log(response.message);


                        $('#input').trigger("reset");

                    },

                });
            });
        });
    </script>
</head>

<body>

    <form class="input-form" id="input" method="post">
        <input type="hidden" name="id" id="id" value="{{ isset($id) ? $id : '' }}">
        @csrf
        <div class="clone">
            <label>Search:</label>
            <input type="text" name="search" id="search" placeholder="Search....." required>
            <button type="submit" id="submit-btn">search</button>
            {{ $for['name'] }} {{ $for['id'] }}
        </div>
        @foreach ($names as $name)
            {{ $name['name'] }}, {{ $name['id'] }}
        @endforeach

    </form>

</body>

</html>
