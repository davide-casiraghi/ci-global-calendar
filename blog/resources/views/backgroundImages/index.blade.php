@extends('backgroundImages.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>@lang('views.background_image_management')</h2>
            </div>
            <div class="pull-right mt-4 float-right">  
                <a class="btn btn-success" href="{{ route('backgroundImages.create') }}">@lang('views.add_new_background_image')</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success mt-4">
            <p>{{ $message }}</p>
        </div>
    @endif

    {{-- Search form --}}
    <form class="row mt-3" action="{{ route('backgroundImages.index') }}" method="GET">
        @csrf
        <div class="form-group col-12 col-md-8 col-lg-9">
            <input type="text" name="keywords" id="keywords" class="form-control" placeholder="@lang('views.search_by_photographer_name')" value="{{ $searchKeywords }}">
        </div>
        <div class="col-12 col-md-4 col-lg-3 mt-sm-0 mt-3">
            <a id="resetButton" class="btn btn-info float-right ml-2" href="#">@lang('general.reset')</a>
            <input type="submit" value="@lang('general.search')" class="btn btn-primary float-right">
        </div>
    </form>


    {{-- List of background images --}}
    <div class="countriesList my-4">
        @foreach ($backgroundImages as $backgroundImage)
            <div class="row p-1 {{ $loop->index % 2 ? 'bg-light': 'bg-white' }}">
                <div class="col-12 col-sm-6 col-md-4 py-3 title">
                    <a href="{{ route('backgroundImages.edit', $backgroundImage->id) }}">{{ $backgroundImage->title }}</a>
                </div>
                
                <div class="col-12 col-sm-3 col-md-2 py-3 code">
                    <i data-toggle="tooltip" data-placement="top" title="" class="far fa-barcode-alt mr-2" data-original-title="@lang('general.code')"></i>
                    {{ $backgroundImage->credits }}
                </div>
                <div class="col-12 col-sm-3 col-md-3 py-3 code">
                    <img src="{{ $backgroundImage->image_src }}" width="150" class="mx-auto d-block">
                </div>
                <div class="col-12 col-sm-12 col-md-3 py-3 code">
                    {{  $backgroundImage->orientation == 0 ? 'Horizontal' : 'Vertical' }}
                </div>
                
                <div class="col-12 pb-2 action">
                    <form action="{{ route('backgroundImages.destroy',$backgroundImage->id) }}" method="POST">

                        <a class="btn btn-info mr-2" href="{{ route('backgroundImages.show',$backgroundImage->id) }}">@lang('views.view')</a>
                        <a class="btn btn-primary" href="{{ route('backgroundImages.edit',$backgroundImage->id) }}">@lang('views.edit')</a>

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger float-right">@lang('views.delete')</button>
                    </form>
                </div>
            </div>
    @endforeach    
    </div>

    {!! $backgroundImages->links() !!}

@endsection
