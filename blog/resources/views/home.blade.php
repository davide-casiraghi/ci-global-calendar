@extends('layouts.app')

@section('title',  "Homepage" )

@section('content')

    <div class="container">
        <div class="page-header">
            <h1 class="text-center">Contact Improvisation Slovenia
            </h1>
        </div>

        <div class="row mb-4">
            <div class="col-md-12">
                <img src="{{ URL::to('/') }}/images/ci_slovenia_header.jpg" alt="" style="width:100%"/>
            </div>
        </div>


        <div class="row">
            <div class="col-md-12">
                Welcome to Contact Improvisation Slovenia!<br />
                This site aims to be a central resource for all things related to contact improvisation in Slovenia.<br /><br />

                What you will find here:<br />

                <ul>
                    <li>A listing of the weekly jams in Slovenia.</li>
                    <li>Links to teachers of contact improvisation in Slovenia and further resources for learning about contact improvisation.</li>
                    <li>All events can also be found in the calendar.</li>
                    <li>More info about this website and the people behind it.</li>
                </ul>
            </div>
        </div>



        @if (Auth::check())
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Dashboard</div>

                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            You are logged in!
                        </div>
                    </div>
                </div>
            </div>
        @endif


    </div>

@endsection
