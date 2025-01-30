<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email Verification</title>
</head>
<body>
    <h1>Please check your email to verify </h1>
    <h2>your Input email is this please check it:</h2>
    <h3>{{auth()->user()->email}}</h3>
    <p>if this is wrong email please register again</p>
    <a href="/register">Register</a>
</body>
</html>