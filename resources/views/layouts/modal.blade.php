
<div class="container pt-2 pb-3">
    @yield('content')
</div>

<script>
    $(document).ready(function(){
        @yield('javascript-document-ready')
    });
    $('.selectpicker').selectpicker();
</script>
