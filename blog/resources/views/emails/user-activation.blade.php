

<h3>Hello administrator</h3>
<p> A new user has registered on the CI Global calendar website.</p>

<strong>Name:</strong>
<div class="">
    {{$name}}
</div>
<strong>Email:</strong>
<div class="">
    {{$email}}
</div>
<strong>Country:</strong>
<div class="">
    {{$country}}
</div>
<strong>Description:</strong>
<div class="">
    {{$description}}
</div>

<a
    moz-do-not-send="true"
    style="font-family: Avenir, Helvetica, sans-serif; box-sizing:
border-box; border-radius: 3px; box-shadow: 0 2px 3px rgba(0, 0, 0,
0.16); color: #FFF; display: inline-block; text-decoration: none;
-webkit-text-size-adjust: none; background-color: #3097D1; border-top:
10px solid #3097D1; border-right: 18px solid #3097D1; border-bottom:
10px solid #3097D1; border-left: 18px solid #3097D1;"
    target="_blank"
    class="button button-blue"
    href="{{env('APP_URL')}}verify-user/{{$activation_code}}">
    Activate user
</a>
