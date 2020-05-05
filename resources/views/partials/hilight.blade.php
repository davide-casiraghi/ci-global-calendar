{{--

    HILIGHT
    Show a box with a text that can be closed and now shown until the cookie expire.
    
    PARAMETERS:
        - $title: array - the list of events
        - $text: boolean - if true clicking on an event bring the user out of the IFRAME where the page was loaded (used for regional websites)
        - $linkText: 
        - $linkUrl: 
--}}

@section('javascript-document-ready')
    @parent
    
    {{--@if($mobileNativeMenu)--}}
        {{--If no cookie with our chosen name (e.g. donation_no_thanks)... --}}
         if ($.cookie("donation_no_thanks") == null) {
            $('.donation.alert').show();
         }
          
         {{-- On click of specified class (e.g. 'nothanks'), trigger cookie, which expires in 100 years --}}
         $(".donation.alert .close").click(function() {
           $.cookie('donation_no_thanks', 'true', { expires: 1, path: '/' });  {{-- COOKIE EXPIRE IN 14 DAYS (now temporarly 1 for Nancy's death) - https://www.npmjs.com/package/jquery.cookie --}}
         });
    {{--@endif--}}
@stop

<div class="donation alert alert-secondary alert-dismissible fade show mx-4 mt-5" style="z-index:3; display:none;">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <strong>{{$title}}</strong> {!!$text!!}
    <a href="{{$linkUrl}}">{{$linkText}}</a>
</div>
