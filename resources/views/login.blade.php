<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
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

    <form action="{{ route('auth.login') }}" id="input" method="post">
        <h1> Login </h1>
        {{-- <input type="hidden" name="id" id="id" value="{{ isset($id) ? $id : '' }}"> --}}
        @csrf

        <div class="clone">
          
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
            </div>
        </div>

        <div class="register-link">
            <p>No account? <a href="{{route('auth.register')}}">Register</a></p>
        </div>
        <button type="submit" id="submit-btn">Login</button>

    </form>
</body>

</html>
