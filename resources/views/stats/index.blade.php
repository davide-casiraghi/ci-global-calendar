@extends('stats.layout')

@section('javascript-document-ready')
    @parent
    
@stop

@section('content')
    
    <div class="row mb-3">
        <div class="col-12 col-sm-6">
            <h3>CIGC Statistics</h3>
        </div>
    </div>
    
    
    
    <div class="row mt-4">
        
        {{-- USERS --}}
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="card-text py-3">
                        <div class="row">
                            <div class="col max-w-50-px">
                                <i class="fas fa-user-alt text-5xl blue-5 pt-2"></i>
                            </div>
                            <div class="col pl-4">
                                <div class="text-3xl font-weight-bolder">
                                    {{$statsDatas->registered_users_number}}
                                </div>
                                <div class="text-xs text-uppercase dark-gray font-weight-bold letter-spacing-wide">Registered users</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Orgenizers --}}
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="card-text py-3">
                        <div class="row">
                            <div class="col max-w-70-px">
                                <i class="fas fa-users text-5xl blue-5 pt-2"></i>
                            </div>
                            <div class="col pl-3">
                                <div class="text-3xl font-weight-bolder">
                                    {{$statsDatas->organizers_number}}
                                </div>
                                <div class="text-xs text-uppercase dark-gray font-weight-bold letter-spacing-wide">Organizer profiles</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Teachers --}}
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="card-text py-3">
                        <div class="row">
                            <div class="col max-w-70-px">
                                <i class="far fa-users text-5xl blue-5 pt-2"></i>
                            </div>
                            <div class="col pl-4">
                                <div class="text-3xl font-weight-bolder">
                                    {{$statsDatas->teachers_number}}
                                </div>
                                <div class="text-xs text-uppercase dark-gray font-weight-bold letter-spacing-wide">Teacher profiles</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Active events --}}
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card mb-2">
                <div class="card-body">
                    <div class="card-text py-3">
                        <div class="row">
                            <div class="col max-w-50-px">
                                <i class="far fa-calendar-alt text-5xl blue-5 pt-2"></i>
                            </div>
                            <div class="col pl-4">
                                <div class="text-3xl font-weight-bolder">
                                    {{$statsDatas->active_events_number}}
                                </div>
                                <div class="text-xs text-uppercase dark-gray font-weight-bold letter-spacing-wide">Active events</div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-1">
        <div class="col-12 dark-gray text-xs">
            The statistics are updated every day at midnight.<br />
            Last update: {{Carbon\Carbon::parse($statsDatas->created_at)->format('d-m-Y')}}

        </div>
    </div>







@endsection
