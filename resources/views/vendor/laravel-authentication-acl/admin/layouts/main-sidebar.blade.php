    <aside class="main-sidebar">
        <section class="sidebar">
                  <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          @include('laravel-authentication-acl::admin.layouts.partials.avatar', ['size' => 30])
        </div>
        <div class="pull-left info">
          <p><span id="nav-email">{!! isset($logged_user) ? $logged_user->email : 'User' !!}</span></p>
          <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
            <ul class="sidebar-menu">
                @if(isset($menu_items))
                    @foreach($menu_items as $item)
                        <li class> 
                        	<a href="{!! $item->getLink() !!}">
                        		<i class="fa fa-link"></i>
                        		<span>{!!$item->getName()!!}</span>
                        	</a>
                        </li>
                    @endforeach
                @endif
            </ul>
        </section>  
    </aside>  