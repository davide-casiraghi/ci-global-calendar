
{{-- 
    Footer menu
    
    PARAMETERS:
        - $container: boolean - show the menu in a container or not 
        - $padding-x: string - the padding on the left and right side of the nav bar, expressed in bootstrap spacing notation eg. px-5

--}}

{{--<hr class="mt-5">--}}
<footer class="{{$paddingX}}" style="background-color: {{$backgroundColor}}">
    @if($container)<div class="container">@endif
        <nav class="row py-2">
            <div class="col-12 col-sm-6 col-sm-pull-6 text-center text-md-left mb-2 mb-sm-0">
                <div class="text text-white">© 2019, made with <i class="fas fa-heart"></i> by Round Robin Team</div>
            </div>
            <div class="col-12 col-sm-5 col-sm-push-5 text-center text-md-right" >
                <a href="/post/contact-improvisation-global-archive-ciga" class="mr-2 text-white"><i class="fa fa-globe"></i> CI - Global Archive</a>
                <a href="/post/donate" class="text-white"><i class="fa fa-heart"></i> @lang('menu.donate') </a>
                {{--<p class="float-right"><a href="#">Back to top</a></p>--}}
            </div>
            <div class="col-12 col-sm-1 col-sm-push-1 text-center text-md-right d-none d-md-block">
                @include('partials.language-selector')
            </div>
        </nav>
    @if($container)</div>@endif
</footer>
