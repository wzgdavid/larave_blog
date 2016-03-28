    <aside class="main-sidebar">
        <section class-"sidebar">
            <ul class="sidebar-menu">
                @if(isset($menu_items))
                    @foreach($menu_items as $item)
                        <li class="{!! LaravelAcl\Library\Views\Helper::get_active_route_name($item->getRoute()) !!}"> <a href="{!! $item->getLink() !!}">{!!$item->getName()!!}</a></li>
                    @endforeach
                @endif
            </ul>
        </section>  
    </aside>  