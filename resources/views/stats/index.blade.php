@extends('stats.layout')

@section('javascript-document-ready')
    @parent
    
@stop

@section('content')
    
    <div class="row">
        <div class="col-12 col-sm-6">
            <h3>CIGC statitics</h3>
        </div>
    </div>
    
    
    {{-- USERS --}}
    <div class="row">
        <div class="col-6 col-lg-3">
            <div class="card mb-2">
                <div class="card-body">
                    <p class="card-text">
                        <div class="row">
                            <div class="col max-w-50-px">
                                <i class="fas fa-user-alt text-5xl blue-5"></i>
                            </div>
                            <div class="col pl-4">
                                <div class="text-xs text-uppercase dark-gray font-weight-bold">Registered users</div>
                                <div class="text-3xl font-weight-bolder">
                                    {{$statsDatas['registeredUsersNumber']}}
                                </div>
                            </div>
                        </div>
                        
                    </p>
                </div>
            </div>
        </div>
        
        {{-- Orgenizers --}}
        <div class="col-6 col-lg-3">
            <div class="card mb-2">
                <div class="card-body">
                    <p class="card-text">
                        <div class="row">
                            <div class="col max-w-70-px">
                                <i class="fas fa-users text-5xl blue-5"></i>
                            </div>
                            <div class="col pl-4">
                                <div class="text-xs text-uppercase dark-gray font-weight-bold">Organier profiles</div>
                                <div class="text-3xl font-weight-bolder">
                                    {{$statsDatas['organizersNumber']}}
                                </div>
                            </div>
                        </div>
                        
                    </p>
                </div>
            </div>
        </div>
        
        {{-- Teachers --}}
        <div class="col-6 col-lg-3">
            <div class="card mb-2">
                <div class="card-body">
                    <p class="card-text">
                        <div class="row">
                            <div class="col max-w-70-px">
                                <i class="far fa-users text-5xl blue-5"></i>
                            </div>
                            <div class="col pl-4">
                                <div class="text-xs text-uppercase dark-gray font-weight-bold">Teacher profiles</div>
                                <div class="text-3xl font-weight-bolder">
                                    {{$statsDatas['teachersNumber']}}
                                </div>
                            </div>
                        </div>
                    </p>
                </div>
            </div>
        </div>
        
        {{-- Active events --}}
        <div class="col-6 col-lg-3">
            <div class="card mb-2">
                <div class="card-body">
                    <p class="card-text">
                        <div class="row">
                            <div class="col max-w-50-px">
                                <i class="far fa-calendar-alt text-5xl blue-5"></i>
                            </div>
                            <div class="col pl-4">
                                <div class="text-xs text-uppercase dark-gray font-weight-bold">Active <br />events</div>
                                <div class="text-3xl font-weight-bolder">
                                    {{$statsDatas['activeEventsNumber']}}
                                </div>
                            </div>
                        </div>
                        
                    </p>
                </div>
            </div>
        </div>
    </div>







@endsection
