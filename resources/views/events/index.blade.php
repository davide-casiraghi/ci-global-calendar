@extends('events.layout')

@section('javascript-document-ready')
    @parent
    {{--  Clear filters on click reset button --}}
        $("#resetButton").click(function(){
            $("input[name=keywords]").val("");
            $("select[name=category_id] option").prop("selected", false).trigger('change');
            $("select[name=country_id] option").prop("selected", false).trigger('change');
            $('form.searchForm').submit();
        });
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <h2>@lang('views.events_management')</h2>
        </div>
        <div class="col-12 mt-4 mt-sm-0 text-right">
            <a class="btn btn-success create-new" href="{{ route('events.create') }}"><i class="fa fas fa-plus-circle"></i> @lang('views.create_new_event')</a>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success mt-4">
            <p>{{ $message }}</p>
        </div>
    @endif

    {{-- Search form --}}
    <form class="row searchForm mt-3" action="{{ route('events.index') }}" method="GET">
        @csrf
        <div class="col-12 col-sm-12 col-md-4 col-lg-3 mb-2">
            @include('partials.forms.input', [
                'name' => 'keywords',
                'placeholder' => __('views.search_by_event_name'),
                'value' => $searchKeywords
            ])
        </div>
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-2">
            @include('partials.forms.select', [
                'name' => 'category_id',
                'placeholder' => __('views.filter_by_category'),
                'records' => $eventCategories,
                'seleted' => $searchCategory,
                'liveSearch' => 'true',
                'mobileNativeMenu' => false,
            ])
        </div>
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            @include('partials.forms.select', [
                'name' => 'country_id',
                'placeholder' => __('views.filter_by_country'),
                'records' => $countries,
                'seleted' => $searchCountry,
                'liveSearch' => 'true',
                'mobileNativeMenu' => false,
            ])
        </div>
        <div class="col-12 col-lg-3 mt-3 mt-sm-2 mt-lg-0">
            <input type="submit" value="@lang('general.search')" class="btn btn-primary float-right ml-2">
            <a id="resetButton" class="btn btn-outline-primary float-right" href="#">@lang('general.reset')</a>
        </div>
    </form>
    
    {{-- List of events --}}
    <div class="eventList my-4">
        @foreach ($events as $event)
            <div class="container max-w-md">
                <div class="row py-3 px-2 bg-white shadow-1 rounded mb-3">
                    
                    
                    
                    <div class="col-12   py-1 title">
                        <h5 class="darkest-gray">{{ $event->title }}</h5>
                    </div>
                    <div class="col-12 mb-4">
                        <i data-toggle="tooltip" data-placement="top" title="" class="fa fa-tag mr-1 dark-gray" data-original-title="@lang('general.category')"></i>
                        {{ $eventCategories[$event->category_id] }}
                        
                        <i data-toggle="tooltip" data-placement="top" title="" class="far fa-globe-americas mr-1 ml-4 dark-gray" data-original-title="@lang('general.country')"></i>
                        {{ $countries[$venues[$event->venue_id]] }}
                    </div>
                    <div class="col-12 pb-2 action">
                        <form action="{{ route('events.destroy',$event->id) }}" method="POST">

                            <a class="btn btn-primary float-right" href="{{ route('events.edit',$event->id) }}">@lang('views.edit')</a>
                            <a class="btn btn-outline-primary mr-2 float-right" href="{{ route('events.show',$event->id) }}">@lang('views.view')</a>
                            
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-link">@lang('views.delete')</button>
                        </form>
                    </div>
                    
                    
                </div>
            </div>
        @endforeach
    </div>


    {!! $events->links() !!}


@endsection
