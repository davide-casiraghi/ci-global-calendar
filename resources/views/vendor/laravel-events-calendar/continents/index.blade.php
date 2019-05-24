@extends('laravel-events-calendar::continents.layout')


@section('content')
    <div class="container max-w-md px-0">
        
        <div class="row">
            <div class="col-12 col-sm-6">
                <h3>@lang('laravel-events-calendar::continent.continents_management')</h3>
            </div>
            <div class="col-12 col-sm-6 mt-4 mt-sm-0 text-right">
                <a class="btn btn-success create-new" href="{{ route('continents.create') }}"><i class="fa fas fa-plus-circle"></i> @lang('laravel-events-calendar::continent.create_new_continent')</a>
            </div>
        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success mt-4">
                <p>{{ $message }}</p>
            </div>
        @endif

        
        {{-- List of continents --}}
        <div class="continentsList my-4">
            @foreach ($continents as $continent)
                <div class="row bg-white shadow-1 rounded mb-3 pb-2 pt-3 mx-1">
                    <div class="col-6 py-1 title order-1">
                        <h5 class="darkest-gray">{{ $continent->name }}</h5>
                    </div>
                    
                    <div class="col-6 mb-4 order-2 pt-1">
                        <i data-toggle="tooltip" data-placement="top" title="" class="far fa-barcode-alt mr-1 ml-4 dark-gray" data-original-title="@lang('laravel-events-calendar::general.code')"></i>
                        {{ $continent->code }}
                    </div>
                    
                    <div class="col-12 pb-2 action order-3">
                        <form action="{{ route('continents.destroy',$continent->id) }}" method="POST">
                            <a class="btn btn-primary float-right" href="{{ route('continents.edit',$continent->id) }}">@lang('laravel-events-calendar::general.edit')</a>
                            
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-link pl-0">@lang('laravel-events-calendar::general.delete')</button>
                        </form>
                    </div>
                    
                </div>
                
                
                
            @endforeach    
        </div>


        {!! $continents->links() !!}
    </div>

@endsection
