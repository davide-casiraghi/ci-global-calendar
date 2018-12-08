@extends('continents.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>@lang('views.continents_management')</h2>
            </div>
            <div class="pull-right mt-4 float-right">
                <a class="btn btn-success" href="{{ route('continents.create') }}">@lang('views.create_new_continent')</a>
            </div>
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
            <div class="row p-1 {{ $loop->index % 2 ? 'bg-light': 'bg-white' }}">
                <div class="col-9 col-md-6 col-lg-7 py-3 title">
                    <a href="{{ route('continents.edit',$continent->id) }}">{{ $continent->name }}</a>
                </div>
                <div class="col-3 col-md-3 col-lg-3 py-3 code">
                    <i data-toggle="tooltip" data-placement="top" title="" class="far fa-barcode-alt mr-2" data-original-title="@lang('general.code')"></i>
                    {{ $continent->code }} 
                </div>
                
                <div class="col-12 pb-2 action">
                    <form action="{{ route('continents.destroy',$continent->id) }}" method="POST">

                        <a class="btn btn-info mr-2" href="{{ route('continents.show',$continent->id) }}">@lang('views.view')</a>
                        <a class="btn btn-primary" href="{{ route('continents.edit',$continent->id) }}">@lang('views.edit')</a>

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger float-right">@lang('views.delete')</button>
                    </form>
                </div>
                
            </div>
        @endforeach    
    </div>


    {!! $continents->links() !!}


@endsection
