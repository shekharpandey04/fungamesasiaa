<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Calling a Function Repeatedly with setInterval() Method</title>
    <style>
        img {
            display: none;
        }
    </style>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script>
        var myVar;

        function showImage() {
            $("img").fadeIn(6000).fadeOut(6000);
            myVar = setTimeout(showImage, 2000);
        }

        function stopFunction() {
            clearTimeout(myVar); // stop the timer
        }
        $(document).ready(function() {
            showImage();
        });
    </script>
</head>

<body>
    <button onclick="stopFunction()">Stop Image Transition</button>
    <p>
        <img src="{{url('GameImage\logo.png')}}" alt="Cloudy Sky">
    </p>
</body>

</html>