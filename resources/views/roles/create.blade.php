<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create Roles And Permission</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        form {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }

        label {
            font-size: 14px;
            color: #333;
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            color: #333;
            box-sizing: border-box;
        }

        input:focus {
            border-color: #5c9f6e;
            outline: none;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #5c9f6e;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #4a8052;
        }

        .register-link {
            margin-top: 15px;
        }

        .register-link a {
            color: #5c9f6e;
            text-decoration: none;
            font-size: 14px;
        }

        .register-link a:hover {
            text-decoration: underline;
        }
        
    </style>
</head>

<body>

    <form action="{{ route('users.createroles') }}" id="input" method="post">
        <h1> Create Roles And Permission </h1>
        {{-- <input type="hidden" name="id" id="id" value="{{ isset($id) ? $id : '' }}"> --}}
        @csrf

        <div class="clone">

            <div class="form-group">
                <label for="role">Role:</label>
                <input type="text" name="role" id="role" required>
            </div>
            <div class="form-group">
                <label for="permissions">Select Permissions:</label>
                <div id="permissions" class="form-group">
                    @foreach($permissions as $permission)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="permission-{{ $permission->id }}">
                            <label class="form-check-label" for="permission-{{ $permission->id }}">
                                {{ $permission->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

       
        <button type="submit" id="submit-btn">Create</button>

    </form>
</body>

</html>
