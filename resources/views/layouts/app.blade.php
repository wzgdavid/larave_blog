<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    

    <!-- Fonts -->
    
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    <link rel="icon" href="../../favicon.ico">
    <link href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/offcanvas.css" rel="stylesheet">
    <link href="/css/layouts/footer.css" rel="stylesheet">
    <link href="/css/layouts/index.css" rel="stylesheet">
    
    <script src="http://libs.baidu.com/jquery/1.10.2/jquery.min.js"></script>
    <script src="/js/ie-emulation-modes-warning.js"></script>
    @yield('head')
    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>
</head>


<body id="app-layout">
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    
                </a>
            </div>
<!--
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            
            <li class="active"><a href="#">Home</a></li>
            <li><a href="/alluser">users</a></li>
            <li><a href="/votepage">vote</a></li>
            <li><a href='/myimgs'>add img</a></li>
            
          </ul>
        </div>
-->

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#">Home</a></li>
                    <li><a href="/article">article</a></li>
                    <li><a href="/votepage">vote</a></li>
                    <li><a href='/myimgs'>add img</a></li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/user/signup') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>



                    @endif
                        <li class="dropdown dropdown-user">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="dropdown-profile">
                            @include('laravel-authentication-acl::admin.layouts.partials.avatar', ['size' => 18])
                            <span id="nav-email">{{ isset($logged_user) ? $logged_user->email : 'User' }}</span> <i class="fa fa-caret-down"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{!! URL::route('userprofile.edit') !!}"><i class="fa fa-user"></i> Your profile</a>
                                </li>
                                <li class="divider">asdf</li>
                                <li>
                                    <a href="{!! URL::route('user.logout') !!}"><i class="fa fa-sign-out"></i> Logout</a>
                                </li>
                            </ul>
                        </li>
                </ul>

            </div>
        </div>
    </nav>

    @yield('content')

    <!-- JavaScripts -->

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}


    <footer id="footer-main">
    <section id="footer-widgets" class="site-width clearfix">
        <div class="container-fluid">
            <div class='row' id='footer-section1'>
              <div class='col-xs-4 col-sm-3 col-md-2 col-lg-2'>
                
                  <img src="/imgs/cityweekend-logo.png" class='autoimg' ></img>
               
              </div>
              <div class='col-sm-12 col-md-8 col-lg-8'>
                City Weekend is an English-language entertainment magazine that brings you the best in food and drinks, nightlife, music, art, community and lifestyle through our print magazine, website and mobile app. Our team is comprised of locals and foreigners who love everything about the cities we call home. Find us in Shanghai, Beijing, Suzhou, Guangzhou and Shenzhen for the latest in entertainment news around China.
              </div>
              <div class='col-sm-3 col-md-2 col-lg-2'>
                asdfsadf
              </div>
            </div>
        </div>
    </section>  
            <section id="footer-links" class=" clearfix text-center">
            <div class="container-fluid">
                <div class="row">
                    <ul><li>
                <a href="http://www.cityweekend.com.cn/about">
                    About
                </a>
            </li><li>
                <a href="http://www.cityweekend.com.cn/terms">
                    Terms & Conditions
                </a>
            </li><li>
                <a href="http://www.cityweekend.com.cn/privacy">
                    Privacy
                </a>
            </li><li>
                <a href="http://www.cityweekend.com.cn/careers">
                    Careers
                </a>
            </li><li>
                <a href="http://www.cityweekend.com.cn/advertise">
                    Advertise with us
                </a>
            </li><li>
                <a href="http://www.cityweekend.com.cn/sitemap">
                    Sitemap
                </a>
            </li><li>
                <a href="https://itunes.apple.com/ca/app/city-weekend-mobile/id429843939?mt=8">
                    iPhone App
                </a>
            </li><li>
                <a href="https://play.google.com/store/apps/details?id=cn.com.cityweekend.android&hl=en">
                    Android App
                </a>
            </li></ul>                </div>
            </div>
        </section>  
           
        <section id="footer-bottom" class="site-width clearfix">
            <div class="container-fluid">
                <div class="row text-center">
                    <div class="col-sm-12 copyright">
            &copy; 1999 - 2016 Ringier China. All rights reserved.
            <span lang="zh">京ICP备10217535号 京公网安备11010102000140号</span>
        </div>                </div>
            </div>
        </section>
    </footer>
<!-- Footer main ends -->


</body>
</html>
