<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>First</title>
    <link rel="stylesheet" href="">
    <script src="first.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>

$(document).ready(function(){

$("#sub-btn").click(function(){
$("#demo").load("test.txt");
});

});

    </script>
</head>
<body>
    <!-- <h1>guess number higher then bot(from 0-5)</h1>
    <input type="number" name="fname" id="input">
    <button id="sub-btn" onclick="formvalue()">submit</button>-->
    <!-- <form  onsubmit="revstring()" id="myform">
        <input type="text" name="username" id="username">
        <input type="email" name="email" id="email">

    </form> -->
    <p id="demo">helo</p>
    <p id="message"></p>
    <button id="sub-btn">load</button>

</body>
</html>
