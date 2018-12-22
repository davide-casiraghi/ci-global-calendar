
<div class="container pt-2 pb-3">
    @yield('content')
</div>

<script type="text/javascript">
    $(document).ready(function(){
        @yield('javascript-document-ready')
    });
    $('.selectpicker').selectpicker();
</script>
