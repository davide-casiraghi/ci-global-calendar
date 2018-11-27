{{--

    Cookie Consent - https://cookieconsent.insites.com/

--}}

@section('javascript')
    @parent

	<script>
		window.addEventListener("load", function(){
		window.cookieconsent.initialise({
		  "palette": {
		    "popup": {
		      "background": "#000"
		    },
		    "button": {
		      "background": "#f1d600"
		    }
		  },
		  "position": "bottom-right"
		})});
	</script>

@stop
