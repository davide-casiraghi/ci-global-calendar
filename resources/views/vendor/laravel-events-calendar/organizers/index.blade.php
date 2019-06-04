@extends('laravel-events-calendar::organizers.layout')

@section('javascript-document-ready')
    @parent
    {{--  Clear filters on click reset button --}}
        $("#resetButton").click(function(){
            $("input[name=keywords]").val("");
            $('form.searchForm').submit();
        });
@stop

@section('content')
    <div class="container max-w-md px-0">
        
        @if ($message = Session::get('success'))
            <div class="alert alert-success mt-4">
                <p>{{ $message }}</p>
            </div>
        @endif
        
        @if($organizers->count() > 0)
            
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h4>@lang('laravel-events-calendar::organizer.organizers_management')</h4>
                </div>
                <div class="col-12 col-sm-6 mt-4 mt-sm-0 text-right">
                    <a class="btn btn-success create-new" href="{{ route('organizers.create') }}"><i class="fa fas fa-plus-circle"></i> @lang('laravel-events-calendar::organizer.create_new_organizer')</a>
                </div>
            </div>

            {{-- Search form --}}
            <form class="searchForm mt-3" action="{{ route('organizers.index') }}" method="GET">
                @csrf
                <div class="row">
                    <div class="col-12 col-sm-7 pr-sm-2">
                        @include('laravel-events-calendar::partials.input', [
                            'name' => 'keywords',
                            'placeholder' => __('laravel-events-calendar::organizer.search_by_organizer_name'),
                            'value' => $searchKeywords
                        ])
                    </div>
                    <div class="col-12 col-sm-5 mt-2 mt-sm-0">
                        <input type="submit" value="@lang('laravel-events-calendar::general.search')" class="btn btn-primary float-right ml-2">
                        <a id="resetButton" class="btn btn-outline-primary float-right" href="#">@lang('laravel-events-calendar::general.reset')</a>
                    </div>
                </div>
            </form>
        @else
            
            {{--  Empty Page --}}
            <div class="wrap empty-page empty-page-organizer min-vh-100">
                <div class="row inner">
                    <div class="col-12 mt-5 max-w-sm">
                        <h3 class="mb-4">Create an organizer profile</h3>
                        
                        <span class="dark-gray">
                            In this page an organizer can add his/her own organizer profile.<br /><br />
                        </span>
                    </div>
                    
                    @if(Route::current()->getName() == 'organizers.index') 
                        <div class="col-12">
                            <a class="btn blue-bg-4 create-new white mt-4" href="{{ route('organizers.create') }}"><i class="fa fas fa-plus-circle"></i> @lang('laravel-events-calendar::organizer.create_new_organizer')</a>
                        </div>
                    @endif
                </div>
                <div class="inner-background"></div>
            </div>
            
        @endif
            
        


        {{-- List of organizers --}}
        <div class="organizersList my-4">
            @foreach ($organizers as $organizer)
                <div class="row bg-white shadow-1 rounded mb-3 pb-2 pt-3 mx-1">
                    <div class="col-12 py-1 title">
                        <h5 class="darkest-gray">{{ $organizer->name }}</h5>
                    </div>
                    <div class="col-12 pb-2 action">
                        <form action="{{ route('organizers.destroy',$organizer->id) }}" method="POST">

                            <a class="btn btn-primary float-right" href="{{ route('organizers.edit',$organizer->id) }}">@lang('laravel-events-calendar::general.edit')</a>
                            <a class="btn btn-outline-primary mr-2 float-right" href="{{ route('organizers.show',$organizer->id) }}">@lang('laravel-events-calendar::general.view')</a>
                            
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-link pl-0">@lang('laravel-events-calendar::general.delete')</button>
                        </form>
                    </div>
                </div>
                
                
                {{--<div class="row p-1 {{ $loop->index % 2 ? 'bg-light': 'bg-white' }}">
                    <div class="col-12 py-3 title">
                        <a href="{{ route('organizers.edit',$organizer->id) }}">{{ $organizer->name }}</a>
                    </div>
                    
                    <div class="col-12 pb-2 action">
                        <form action="{{ route('organizers.destroy',$organizer->id) }}" method="POST">

                            <a class="btn btn-info mr-2" href="{{ route('organizers.show',$organizer->id) }}">@lang('laravel-events-calendar::general.view')</a>
                            <a class="btn btn-primary" href="{{ route('organizers.edit',$organizer->id) }}">@lang('laravel-events-calendar::general.edit')</a>

                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger float-right">@lang('laravel-events-calendar::general.delete')</button>
                        </form>
                    </div>
                </div>--}}
            @endforeach 
        </div>

        {!! $organizers->appends([
            'keywords' => $searchKeywords,
        ])->links() !!}

    </div>
@endsection
