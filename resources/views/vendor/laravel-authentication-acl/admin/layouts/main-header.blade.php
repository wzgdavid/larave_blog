  <header class="main-header">

    <!-- Logo -->
    <a href="" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>A</b>LT</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg">Admin</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">


        <ul class="nav navbar-nav">




          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="dropdown-profile">
                        @include('laravel-authentication-acl::admin.layouts.partials.avatar', ['size' => 30])
                        <span id="nav-email">{!! isset($logged_user) ? $logged_user->email : 'User' !!}</span> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                            <li>
                                <a href="{!! URL::route('users.selfprofile.edit') !!}"><i class="fa fa-user"></i> Your profile</a>
                            </li>
                            <li class="divider"></li>
                        <li>
                            <a href="{!! URL::route('user.logout') !!}"><i class="fa fa-sign-out"></i> Logout</a>
                        </li>
                    </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>