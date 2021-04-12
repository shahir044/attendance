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
        <video src="videos/production.mp4" muted loop autoplay></video>
        <div class="overlay"></div>
        <div class="text">
          <h2>Never Stop To</h2> 
          <h3>Exploring The World</h3>
          <p>Welcome aboard your home in the sky. My heartiest thanks to you for choosing Biman Bangladesh Airlines. We strive to earn your loyalty every time you fly Biman by offering safe and reliable service to the destinations of your choice.</p>
          <a href="https://www.biman-airlines.com/">Explore</a>
        </div>
        <ul class="social">
          <li><a href="https://www.facebook.com/bimanbalaka/"><img src="https://i.ibb.co/x7P24fL/facebook.png"></a></li>
          <li><a href="https://www.facebook.com/bimanbalaka/"><img src="https://i.ibb.co/Wnxq2Nq/twitter.png"></a></li>
          <li><a href="https://www.facebook.com/bimanbalaka/"><img src="https://i.ibb.co/ySwtH4B/instagram.png"></a></li>
        </ul>
      </section>
      <div class="menu">
        <ul>
          <li><a href="http://attendance.localhost/attendance">Home</a></li>
          <li><a href="http://attendance.localhost/">Upload File</a></li>
          <li><a href="http://attendance.localhost/login">Sign In</a></li>
          <li><a href="http://attendance.localhost/register">Register</a></li>
          <li><a href="https://www.biman-airlines.com/">Website</a></li>
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