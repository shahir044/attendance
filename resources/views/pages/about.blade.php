<!DOCTYPE html>
<html lang="en">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/about.css') }}" rel="stylesheet">
    
    <title>Document</title>

<body class="page-top">
    <header class="header">
        <a class="logo" href="/attendance" >About</a>

        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        

        <input class="menu-btn" type="checkbox" id="menu-btn" />
        <label class="menu-icon" for="menu-btn"><span class="navicon"></span></label>
        <ul class="menu">
            <li><a href="" class="link link-theme link-arrow">Objective</a></li>
            <li><a href="" class="link link-theme link-arrow">Features</a></li>
            <li><a href="#three" class="link link-theme link-arrow"></a></li>
            <li><a href="#four" class="link link-theme link-arrow"></a></li>
        </ul>
    </header>

    <div>

        <div id="main" class="main">

            <section class="intro">

                <article class="container">

                    <h1 class="animate__animated animate__fadeInDown">
                        Attendance<strong>Counter</strong>
                    </h1>

                    <h2 class="animate__animated animate__fadeInDown">
                        Daily presence counter in all buildings of Biman.
                    </h2>

                    <p class="animate__animated animate__fadeInDown">
                        <a href="/"  class="link link-theme link-arrow" title="Let’s Build Something Great">LET’S
                            BUILD SOMETHING GREAT</a>
                    </p>

                </article>

            </section>
            <!-- /intro -->

            <section class="work" >

                <article class="container" id="one">

                    <h2 class="animate__animated animate__fadeInDown">
                        Objective
                    </h2>

                    <ul class="menu">
                        <li class="animate__animated animate__fadeInDown"><a  class="link link-theme link-arrow">Concise Objective</a></li>
                        <li class="animate__animated animate__fadeInDown"><a  class="link link-theme link-arrow">Within Two points</a></li>
                        <li class="animate__animated animate__fadeInDown"><a  class="link link-theme link-arrow"></a></li>
                        <li class="animate__animated animate__fadeInDown"><a  class="link link-theme link-arrow"></a></li>
                    </ul>

                </article>

                <article class="container" id="two">
                    <h2>
                        Use Case
                    </h2>

                </article>

                <article class="container" id="three">
                    <h2>
                        Future Plan
                    </h2>

                </article>

                <article class="container" id="four">

                    

                </article>
                </article>

            </section>
            <!-- /work -->

            <footer class="footer">

                <div class="container">
                    <hr>
                    <article class="foot-content-left">
                        <ul>&copy;2021 IT Biman Bangladesh Airlines</ul>
                    </article>

                    <article class="foot-content">
                        <ul>
                            <li><a href="pixelstrecher@gmail.com">@bdbiman.com</a></li>
                            <li class="social"><a href="https://www.facebook.com/">Facebook</a></li>
                            <li class="social"><a href="https://twitter.com/">Twitter</a></li>
                            <li class="social"><a href="https://www.linkedin.com/company/">LinkedIn</a></li>
                        </ul>
                    </article>

                </div>

            </footer>
            <!-- /footer -->


        </div>

        
    </div>
    <!-- end div container -->
    <script>
        $("a").click(function(e) {
            e.preventDefault();
            $("body, html").animate({
                    scrollTop: $($(this).attr("href")).offset().top - 120
                },
                1000
            );
        });
    </script>

</body>
</html>
