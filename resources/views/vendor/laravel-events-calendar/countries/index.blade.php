@extends('laravel-events-calendar::countries.layout')

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
        <div class="row">
            <div class="col-12 col-sm-6">
                <h3>@lang('views.countries_management')</h3>
            </div>
            <div class="col-12 col-sm-6 mt-4 mt-sm-0 text-right">
                <a class="btn btn-success create-new" href="{{ route('countries.create') }}"><i class="fa fas fa-plus-circle"></i> @lang('views.create_new_country')</a>
            </div>
        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success mt-4">
                <p>{{ $message }}</p>
            </div>
        @endif

        {{-- Search form --}}
        <form class="searchForm mt-3" action="{{ route('countries.index') }}" method="GET">
            @csrf
            <div class="row">
                <div class="col-12 col-sm-7 pr-sm-2">
                    @include('laravel-events-calendar::partials.input', [
                        'name' => 'keywords',
                        'placeholder' => __('views.search_by_country_name'),
                        'value' => $searchKeywords
                    ])
                </div>
                <div class="col-12 col-sm-5 mt-2 mt-sm-0">
                    <input type="submit" value="@lang('general.search')" class="btn btn-primary float-right ml-2" style="white-space: normal;">
                    <a id="resetButton" class="btn btn-outline-primary float-right" href="#">@lang('general.reset')</a>
                </div>
            </div>
        </form>
        
        {{-- List of countries --}}
        <div class="countriesList my-4">
            @foreach ($countries as $country)
                <div class="row bg-white shadow-1 rounded mb-3 pb-2 pt-3 mx-1">
                    <div class="col-12 py-1 title">
                        <h5 class="darkest-gray">{{ $country->name }}</h5>
                    </div>
                    <div class="col-12 mb-4">        
                        <i data-toggle="tooltip" data-placement="top" title="" class="far fa-barcode-alt mr-1 dark-gray" data-original-title="@lang('general.code')"></i>
                        {{ $country->code }} 
                        
                        <i data-toggle="tooltip" data-placement="top" title="" class="far fa-globe-americas mr-1 ml-4 dark-gray" data-original-title="@lang('general.continent')"></i>
                        @if($country->continent_id){{ $continents[$country->continent_id] }}@endif
                    </div>
                    
                    <div class="col-12 pb-2 action">
                        <form action="{{ route('countries.destroy',$country->id) }}" method="POST">
                            <a class="btn btn-primary float-right" href="{{ route('countries.edit',$country->id) }}">@lang('views.edit')</a>
                            
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-link pl-0">@lang('views.delete')</button>
                        </form>
                    </div>
                </div>
                
                
            @endforeach    
        </div>

        {!! $countries->links() !!}
    </div>

@endsection
