{{--

    HILIGHT
    Show a box with a text that can be closed and now shown until the cookie expire.
    
    PARAMETERS:
        - $title: array - the list of events
        - $text: boolean - if true clicking on an event bring the user out of the IFRAME where the page was loaded (used for regional websites)
--}}

<div class="alert alert-secondary alert-dismissible fade show" style="z-index:3; margin: 0 1rem;">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <strong>{{$title}}</strong> {{$text}}<br />
    <a href="{{$linkUrl}}">{{$linkText}}</a>
</div>
