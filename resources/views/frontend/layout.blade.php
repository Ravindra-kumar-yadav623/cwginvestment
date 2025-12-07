<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Capital Wealth Growth</title>

        <!-- CSS -->

        
        <!-- google fonts -->
        <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,500,700' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Oswald:400,300,700' rel='stylesheet' type='text/css'>

         <!-- files -->
        <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
        <link href="{{asset('assets/css/magnific-popup.css')}}" rel="stylesheet">
        <link href="{{asset('assets/css/owl.carousel.css')}}" rel="stylesheet">
        <link href="{{asset('assets/css/owl.carousel.theme.min.css')}}" rel="stylesheet">
        <link href="{{asset('assets/css/ionicons.css')}}" rel="stylesheet">
        <link href="{{asset('assets/css/main.css')}}" rel="stylesheet">


        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>

    <!-- Site Header -->
        <div class="site-header-bg">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <a href="index.html"><img src="{{asset('assets/images/logo.png')}}" alt="logo"></a>
                    </div>
                    <div class="col-sm-3 col-sm-offset-3 text-right">
                        <span class="ion-android-cart"></span> 0 products &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="{{route('login')}}">Login</a>
                        <form>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="">
                                <span class="input-group-btn">
                                    <button class="btn btn-default btn-robot" type="button">Search</button>
                                </span>
                            </div><!-- /input-group -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Header -->

        @yield('header-class')
        
            <div class="container">

                <div class="row">
                    <nav class="navbar navbar-default">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#site-nav-bar" aria-expanded="false">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>

                        <div class="collapse navbar-collapse" id="site-nav-bar">
                            <ul class="nav navbar-nav">
                                <li class="active"><a href="{{ url('/') }}">Home</a></li>
                                <li><a href="{{ url('about') }}">About</a></li>
                                <li><a href="{{ url('shop') }}">Shop</a></li>
                                <li><a href="{{ url('faq') }}">FAQ</a></li>
                                <li><a href="{{ url('about') }}">Contact</a></li>
                            </ul>
                        </div><!-- /.navbar-collapse -->
                    </nav>
                </div>
                
                @yield('breadcrum')
                
            </div> <!-- /.container -->
            <div class="nutral"></div>
        </section> <!-- /#header -->

    <!-- Product -->


@yield('content')

 <!-- Footer -->
        <section id="footer-widget" class="footer-widget">
            <div class="container header-bg">
                <div class="row">
                    <div class="col-sm-3">
                        <h3>Our Popular Services</h3>
                        <ul>
                            <li><a href="#">Achieving Long</a></li>
                            <li><a href="#">Financial Security</a></li>
                            <li><a href="#">Risk Management:</a></li>
                            <li><a href="#">Passive Income</a></li>
                            <li><a href="#">Generational Wealth</a></li>
                        </ul>
                    </div>
                    <div class="col-sm-3">
                        <h3>Important Link</h3>
                        <ul>
                            <li><a href="#">Home</a></li>
                            <li><a href="#">About</a></li>
                            <li><a href="#">Shop</a></li>
                            <li><a href="#">FAQ</a></li>
                            <li><a href="#">Contact</a></li>
                        </ul>
                    </div>
                    <div class="col-sm-3">
                        <h3>Our Latest Services</h3>
                        <ul>
                            <li><a href="#">Package 1</a></li>
                            <li><a href="#">Package 2</a></li>
                            <li><a href="#">Package 3</a></li>
                            <li><a href="#">Package 4</a></li>
                            <li><a href="#">Package 5</a></li>
                        </ul>
                    </div>
                    <div class="col-sm-3">
                        <h3>Our Services</h3>
                        <div class="widget-img-box">
                            <a class="test-popup-link" href="assets/images/widget-big-1.png">
                                <img class="widget-img" src="assets/images/widget-1.png" alt="widget">
                            </a>
                            <a class="test-popup-link" href="assets/images/widget-big-2.png">
                                <img class="widget-img" src="assets/images/widget-2.png" alt="widget">
                            </a>
                            <a class="test-popup-link" href="assets/images/widget-big-3.png">
                                <img class="widget-img" src="assets/images/widget-3.png" alt="widget">
                            </a>
                            <a class="test-popup-link" href="assets/images/widget-big-4.png">
                                <img class="widget-img" src="assets/images/widget-4.png" alt="widget">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <footer class="footer text-center">
            <h3>&copy;Copyright 2000 - <a href="#">Capital Wealth Growth</a></h3>
        </footer>

     <!-- script -->
     <script src="{{asset('assets/js/jquery-1.12.3.min.js')}}"></script>
        <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('assets/js/jquery.magnific-popup.min.js')}}"></script>
        <script src="{{asset('assets/js/owl.carousel.min.js')}}"></script>
        <script src="{{asset('assets/js/script.js')}}"></script>

  </body>
</html>