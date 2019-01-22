@extends('layouts.regionalframe')


<div class="container">
    <div class="row">
        <div class="col-12">
            
            <h2>list-by-country</h2>

            @foreach ($events as $key => $event)
                {{$event->title}}
            @endforeach
            
            
            <p>
                You can specify your country using one of this country codes:
                https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2#Officially_assigned_code_elements
            </p>
        </div>
    </div>
</div>
