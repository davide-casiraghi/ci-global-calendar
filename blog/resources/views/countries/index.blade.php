@extends('countries.layout')


@section('content')
    <div class="row">
        <div class="col-12">
            <h2>@lang('views.countries_management')</h2>
        </div>
        <div class="col-12 mt-4 mt-sm-0 text-right">
            <a class="btn btn-success" href="{{ route('countries.create') }}">@lang('views.add_new_country')</a>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success mt-4">
            <p>{{ $message }}</p>
        </div>
    @endif

    {{-- Search form --}}
    <form class="row mt-3" action="{{ route('countries.index') }}" method="GET">
        @csrf
        <div class="col-12 col-md-8 col-lg-9">
            @include('partials.forms.input', [
                'name' => 'keywords',
                'placeholder' => __('views.search_by_country_name'),
                'value' => $searchKeywords
            ])
        </div>
        <div class="col-12 col-md-4 col-lg-3 mt-sm-0 mt-3">
            <a id="resetButton" class="btn btn-info float-right ml-2" href="#">@lang('general.reset')</a>
            <input type="submit" value="@lang('general.search')" class="btn btn-primary float-right">
        </div>
    </form>


    {{-- List of countries --}}
    <div class="countriesList my-4">
        @foreach ($countries as $country)
            <div class="row p-1 {{ $loop->index % 2 ? 'bg-light': 'bg-white' }}">
                <div class="col-12 col-sm-6 col-lg-7 py-3 title">
                    <a href="{{ route('countries.edit',$country->id) }}">{{ $country->name }}</a>
                </div>
                <div class="col-6 col-sm-3 col-lg-2 py-3 code">
                    <i data-toggle="tooltip" data-placement="top" title="" class="far fa-barcode-alt mr-2" data-original-title="@lang('general.code')"></i>
                    {{ $country->code }} 
                </div>
                <div class="col-6 col-sm-3 col-lg-3 py-3 continent">
                    <i data-toggle="tooltip" data-placement="top" title="" class="fas fa-globe-americas mr-2" data-original-title="@lang('general.continent')"></i>
                    {{ $continents[$country->continent_id] }}
                </div>
                
                <div class="col-12 pb-2 action">
                    <form action="{{ route('countries.destroy',$country->id) }}" method="POST">
                        <a class="btn btn-primary" href="{{ route('countries.edit',$country->id) }}">@lang('views.edit')</a>

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger float-right">@lang('views.delete')</button>
                    </form>
                </div>

            </div>
        @endforeach    
    </div>


    {!! $countries->links() !!}


@endsection
