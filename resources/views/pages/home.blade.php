<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <title>Biman Bangladesh Airlines</title>
</head>

<body>
    <section class="showcase">

        <header>
            <h2 class="logo">Biman Bangladesh Airlines</h2>
            <div class="toggle"></div>
        </header>
        <video src="videos/team.mp4" muted loop autoplay></video>
        <div class="overlay"></div>
        <div class="text">
            <h2><strong>Alone</strong></h2>
            <h3>we can do so little.<br>Together we can do so much.</h3>

            <p>When you have confidence, you can have a lot of fun.<br>And when you have fun, you can do amazing things.
            </p>
            <a href="/attendance">Explore</a>
        </div>
        <ul class="social">
            <li><a href="https://www.facebook.com/bimanbalaka/"><img src="https://i.ibb.co/x7P24fL/facebook.png"></a>
            </li>
           {{--  <li><a href="https://www.facebook.com/bimanbalaka/"><img src="https://i.ibb.co/Wnxq2Nq/twitter.png"></a>
            </li>
            <li><a href="https://www.facebook.com/bimanbalaka/"><img src="https://i.ibb.co/ySwtH4B/instagram.png"></a>
            </li> --}}
        </ul>
    </section>
    <div class="menu">
        <ul>
            <li><a href="http://attendance.localhost/attendance">Home</a></li>
{{--             <li><a href="http://attendance.localhost/login">Sign In</a></li>
            <li><a href="http://attendance.localhost/register">Register</a></li> --}}
            <li><a href="https://www.biman-airlines.com/">Website</a></li>
            <li><a href="http://attendance.localhost/about">About</a></li>
        </ul>
    </div>

    <script>
        const menuToggle = document.querySelector('.toggle');
        const showcase = document.querySelector('.showcase');

        menuToggle.addEventListener('click', () => {
            menuToggle.classList.toggle('active');
            showcase.classList.toggle('active');
        })

    </script>
</body>

</html>
