@extends('teachers.layout')

@section('content')
    <div class="container max-w-md px-0">
        <div class="row m-0 p-4 white-bg rounded">
            <div class="col-12">
                
                <div class="row">
                    <div class="col-12 mt-3">
                        <h4>{{ $user->name }}</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 mt-2">
                        <i data-toggle="tooltip" data-placement="top" title="" class="far fa-globe-americas mr-1 dark-gray" data-original-title="@lang('general.country')"></i>
                        {{ $countries[$user->country_id] }}
                    </div>
                    <div class="col-6 mt-2">
                        <i data-toggle="tooltip" data-placement="top" title="" class="fas fa-key mr-1 dark-gray" data-original-title="@lang('general.country')"></i>
                        {{ $role }}
                    </div>
                    
                    
                </div>
                    
                    
                    <div class="col-12 mt-5">
                        {!! $user->description !!}
                    </div>
                    
                </div>
            </div>
            
        </div>
    </div>
@endsection
