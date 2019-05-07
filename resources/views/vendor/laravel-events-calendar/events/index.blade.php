@extends('laravel-events-calendar::events.layout')

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
    <div class="container max-w-md px-0">
        <div class="row">
            <div class="col-12 col-sm-7">
                <h3>@lang('views.events_management')</h3>
            </div>
            <div class="col-12 col-sm-5 mt-4 mt-sm-0 text-right">
                <a class="btn btn-success create-new" href="{{ route('events.create') }}"><i class="fa fas fa-plus-circle"></i> @lang('views.create_new_event')</a>
            </div>
        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success mt-4">
                <p>{{ $message }}</p>
            </div>
        @endif

        {{-- Search form --}}
        <form class="searchForm mt-3" action="{{ route('events.index') }}" method="GET">
            @csrf
            <div class="row">
                <div class="col-12 col-sm-6 order-1">
                    @include('laravel-events-calendar::partials.input', [
                        'name' => 'keywords',
                        'placeholder' => __('views.search_by_event_name'),
                        'value' => $searchKeywords
                    ])
                </div>
                <div class="col-12 col-sm-6 order-4 order-sm-2">
                    <input type="submit" value="@lang('general.search')" class="btn btn-primary float-right ml-2" style="white-space: normal;">
                    <a id="resetButton" class="btn btn-outline-primary float-right" href="#">@lang('general.reset')</a>
                </div>
            
                <div class="col-12 col-sm-6 order-2 order-sm-3">
                    @include('laravel-events-calendar::partials.select', [
                        'name' => 'category_id',
                        'placeholder' => __('views.filter_by_category'),
                        'records' => $eventCategories,
                        'seleted' => $searchCategory,
                        'liveSearch' => 'true',
                        'mobileNativeMenu' => false,
                    ])
                </div>
                <div class="col-12 col-sm-6 order-3 order-sm-4">
                    @include('laravel-events-calendar::partials.select', [
                        'name' => 'country_id',
                        'placeholder' => __('views.filter_by_country'),
                        'records' => $countries,
                        'seleted' => $searchCountry,
                        'liveSearch' => 'true',
                        'mobileNativeMenu' => false,
                    ])
                </div>    
            </div>
            
            
        </form>
        
        {{-- List of events --}}
        <div class="eventList my-4">
            @foreach ($events as $event)
                <div class="row bg-white shadow-1 rounded mb-3 mx-1">
                    
                    <div class="d-none d-sm-block col-sm-4 p-0">
                        @if(!empty($event->image))
                            <img class="rounded-left" style="width:100%; height:100%;" alt="{{ $event->title }}" src="/storage/images/events_teaser/thumb_{{ $event->image }}">
                        @else
                            <span class="gray-bg rounded-left d-block" style="width:100%; height:100%;"></span>
                        @endif
                    </div>
                    <div class="col-12 col-sm-8 pb-2 pt-3 px-3">
                        <div class="row">
                            <div class="col-12 py-1 title">
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
                                    <a class="btn btn-outline-primary mr-2 float-right" href="{{ route('events.eventBySlug',$event->slug) }}">@lang('views.view')</a>
                                    
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-link pl-0">@lang('views.delete')</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                </div>
            @endforeach
        </div>

        {!! $events->links() !!}
    </div>

@endsection
