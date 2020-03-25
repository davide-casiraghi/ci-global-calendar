@extends('geomap.layout')

@section('css')
    @parent
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css"
    integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ=="
    crossorigin=""/>
    
    <style>
        #mapid { min-height: 500px; }
    </style>
@stop

@section('javascript')
    @parent

    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"
    integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw=="
    crossorigin=""></script>
    
    
    <script src="/storage/leaflet-color-markers/js/leaflet-color-markers.js" ></script>
    
    <script>
        var map = L.map('mapid').setView(
            [
                {{ $userLat }}, 
                {{ $userLng }}
            ], 
            {{ config('leaflet.zoom_level') }}
        );
            
        var baseUrl = "{{ url('/') }}";

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        
        /*L.marker([51.5, -0.09]).addTo(map)
        .bindPopup("<b>Hello world!</b><br />I am a popup.").openPopup();
        */
        
        //L.geoJson({!!$activeEventMarkersJSON!!}).addTo(map);
        L.geoJson({!!$activeEventMarkersJSON!!},{
          pointToLayer: function(feature,latlng){
              var icon_color = feature.properties.IconColor;
              var marker = L.marker(latlng,{icon: window[icon_color]});  //Icon colors are defined in /storage/leaflet-color-markers/js/leaflet-color-markers.js
            //var marker = L.marker(latlng,{icon: greenIcon});
            //var marker = L.marker(latlng);
            
            console.log(feature.properties.NextDate);
            marker.bindPopup(
                '<b><a href="'+feature.properties.Link+'">' +feature.properties.Title + '</a></b>' +
                '<br/>' + 
                feature.properties.Category + 
                '<br/>' + 
                feature.properties.NextDate +
                '<br/><br/>' + 
                '<b>' + feature.properties.VenueName + '</b>' +
                '<br/>' + 
                feature.properties.City + feature.properties.Address +
                '<br/>'
            );
            return marker;
          }
        }).addTo(map);
        
        
    </script>

    <!-- Initialize editor for the main textbox -->
    <script src="{{ asset('js/tinymce/tinymce.min.js') }}" ></script>
    
@stop

@section('content')
     
    <div class="row mb-3 d-none d-sm-block">
        <div class="col-12 col-sm-6">
            <h3>CIGC Geomap</h3>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-12">
            
            {{-- GEOMAP --}}
            <div class="card">
                <div class="card-body" id="mapid" style="z-index:1;"></div>
            </div>
            
        </div>
    </div>
        
    {{-- Legend --}}
    <div class="container max-w-md px-0">
        <div class="row mt-1">
            <div class="col text-center mt-4">
              <img src="/storage/leaflet-color-markers/img/marker-icon-green.png" alt="green marker">
              <br>
              Regular Jam
            </div>
            <div class="col text-center mt-4">
                <img src="/storage/leaflet-color-markers/img/marker-icon-yellow.png" alt="green marker">
                <br>
                Special Jam
            </div>
            <div class="col text-center mt-4">
                <img src="/storage/leaflet-color-markers/img/marker-icon-gold.png" alt="green marker">
                <br>
                Class
            </div>
            <div class="col text-center mt-4">
                <img src="/storage/leaflet-color-markers/img/marker-icon-orange.png" alt="green marker">
                <br>
                Workshop
            </div>
            <div class="col text-center mt-4">
                <img src="/storage/leaflet-color-markers/img/marker-icon-red.png" alt="green marker">
                <br>
                Festival <br> Camp <br> Journey
            </div>
        {{--</div>    
        <div class="row mt-1">  --}}  
            <div class="col text-center mt-4">
                <img src="/storage/leaflet-color-markers/img/marker-icon-blue.png" alt="green marker">
                <br>
                Underscore
            </div>
            <div class="col text-center mt-4">
                <img src="/storage/leaflet-color-markers/img/marker-icon-violet.png" alt="green marker">
                <br>
                Performance <br> Lecture <br> Conference <br> Film <br> Other event
            </div>
            <div class="col text-center mt-4">
                <img src="/storage/leaflet-color-markers/img/marker-icon-grey.png" alt="green marker">
                <br>
                Lab
            </div>
            <div class="col text-center mt-4">
                <img src="/storage/leaflet-color-markers/img/marker-icon-black.png" alt="green marker">
                <br>
                Teachers Meeting
            </div>
        </div>
        
        <div class="row mt-4 mx-2 alert alert-warning">
            If you are an event organizer and the venue of your event doesn't show up correctly, please check that all the data of the venue's address such as street or postcode are specified.
        </div>
        
    </div>

@endsection
