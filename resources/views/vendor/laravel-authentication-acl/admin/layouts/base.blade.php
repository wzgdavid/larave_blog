{{-- Layout base admin panel --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">

    <link rel="stylesheet" href="//apps.bdimg.com/libs/jqueryui/1.10.4/css/jquery-ui.min.css">
    {!! HTML::style('packages/jacopo/laravel-authentication-acl/css/bootstrap.min.css') !!}
    {!! HTML::style('packages/jacopo/laravel-authentication-acl/css/style.css') !!}
    <!--{!! HTML::style('packages/jacopo/laravel-authentication-acl/css/baselayout.css') !!}-->
    {!! HTML::style('packages/jacopo/laravel-authentication-acl/css/fonts.css') !!}
    {!! HTML::style('//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css') !!}
    
    {{ HTML::style('packages/admin/dist/css/AdminLTE.min.css') }}
    {{ HTML::style('packages/admin/dist/css/skins/skin-blue.min.css') }}
    
    @yield('head_css')
    {{-- End head css --}}

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>

    <body class="skin-blue sidebar-mini">
        <div class="wrapper">
            
            {{-- main header --}}
            @include('laravel-authentication-acl::admin.layouts.main-header')
        
            {{--main sidebar--}}
            @include('laravel-authentication-acl::admin.layouts.main-sidebar')
            {{--content wrapper--}}

            <div class="container-wrapper">
                @yield('container')
            </div>



            @include('laravel-authentication-acl::admin.layouts.control-sidebar')

            {{-- Start footer scripts --}}
            @yield('before_footer_scripts')

            {!! HTML::script('packages/jacopo/laravel-authentication-acl/js/vendor/jquery-1.10.2.min.js') !!}
            {!! HTML::script('packages/jacopo/laravel-authentication-acl/js/vendor/bootstrap.min.js') !!}

            @yield('footer_scripts')
            {{-- End footer scripts --}}
            
        </div>
    </body>
</html>