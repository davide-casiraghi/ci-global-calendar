

<div class="container pt-5">
    @yield('content')
</div>

@yield('javascript')

<script type="text/javascript">
    $(document).ready(function(){
        @yield('javascript-document-ready')
    });
</script>
