

<div class="container pt-5">
    @yield('content')
</div>


<script type="text/javascript">
    $(document).ready(function(){
        @yield('javascript-document-ready')
    });

    $('.selectpicker').selectpicker();

</script>
