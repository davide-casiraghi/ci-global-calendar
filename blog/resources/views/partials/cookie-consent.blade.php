{{--
    Cookie Policy - https://cookieconsent.insites.com/download/
	<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.css" />
--}}

@section('css')
    @parent
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.0/cookieconsent.min.css" />
@stop

@section('javascript')
    @parent

    <script src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.1.0/cookieconsent.min.js"></script>-->
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
