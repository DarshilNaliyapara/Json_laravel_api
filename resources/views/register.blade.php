<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <form action="{{route('auth.register')}}" id="input" method="post">
        {{-- <input type="hidden" name="id" id="id" value="{{ isset($id) ? $id : '' }}"> --}}
        @csrf

        <div class="clone">



            <div class="form-group">

                <label>Name:</label>
                <input type="text" name="name" id="name" required>
            </div>
            <div class="form-group">
                <label>E-mail:</label>
                <input type="email" name="email" id="email" required>

            </div>
            <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password" id="password" required>

            </div>
        </div>
        <div class="cloned"></div>


        <button type="submit" id="submit-btn">save</button>
    </form>
</body>

</html>
