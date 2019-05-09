{{--
    GOOGLE MAPS: show a google map with a placemark and some description in
    
    PARAMETERS:
        - $venue_name: string - 
        - $venue_address: string - where to place the placemark
        - $venue_city: string - 
        - $venue_country: string - 
        - $venue_zip_code: string -
--}}

<iframe
    width="100%"
    height="300"
    frameborder="0"
    src="https://maps.google.com/maps?&amp;q='@if(!empty($venue_address)){{ $venue_address }} @endif, @if(!empty($venue_city)){{ $venue_city }} @endif, @if(!empty($venue_country)){{ $venue_country }} @endif, @if(!empty($venue_zip_code)){{ $venue_zip_code }} @endif'&amp;z=14&amp;output=embed&amp;iwloc"
    marginwidth="0"
    marginheight="0"
    scrolling="no">
</iframe>
