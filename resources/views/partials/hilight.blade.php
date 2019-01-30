{{--

    HILIGHT
    Show a box with a text that can be closed and now shown until the cookie expire.
    
    PARAMETERS:
        - $title: array - the list of events
        - $text: boolean - if true clicking on an event bring the user out of the IFRAME where the page was loaded (used for regional websites)
        - $backgroundColor: string - the box background (eg.#B5A575)
        - $textColor: string - the text color (eg.#B5A575)
--}}

<div class="container" style="
            position: fixed; 
            top: 6rem;
            right: 0;
            left: 0;
            z-index: 10;
">
    <div class="row">
        <div class="col-12 text-center">
            <div class="alert alert-secondary alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>{{$title}}</strong> {{$text}}<br />
                <a href="{{$linkUrl}}">{{$linkText}}</a>
            </div>
        </div>
        
        
        
        
        
    </div>
</div>
