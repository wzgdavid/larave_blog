    <aside class="main-sidebar">
        <section class-"sidebar">
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