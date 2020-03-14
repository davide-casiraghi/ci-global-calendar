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
    
    <script>
        var map = L.map('mapid').setView(
            [
                {{ config('leaflet.map_center_latitude') }}, 
                {{ config('leaflet.map_center_longitude') }}
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
        
        var ratIcon = L.icon({
          iconUrl: 'http://andywoodruff.com/maptime-leaflet/rat.png',
          iconSize: [60,50]
        });
        
        
        //L.geoJson({!!$activeEventMarkersJSON!!}).addTo(map);
        L.geoJson({!!$activeEventMarkersJSON!!},{
          pointToLayer: function(feature,latlng){
            var marker = L.marker(latlng,{icon: ratIcon});
            //var marker = L.marker(latlng);
            marker.bindPopup(feature.properties.Location + '<br/>' + feature.properties.Title+ '<br/>' + latlng);
            return marker;
          }
        }).addTo(map);
        
        
    </script>

    <!-- Initialize editor for the main textbox -->
    <script src="{{ asset('js/tinymce/tinymce.min.js') }}" ></script>
    
@stop

@section('content')
    
    <div class="row mb-3">
        <div class="col-12 col-sm-6">
            <h3>CIGC Geomap</h3>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-12">
            
            {{-- GEOMAP --}}
            <div class="card">
                <div class="card-body" id="mapid"></div>
            </div>
            
        </div>
    </div>

@endsection
