@extends('organizers.layout')

@section('javascript-document-ready')
    @parent
    {{--  Clear filters on click reset button --}}
        $("#resetButton").click(function(){
            $("input[name=keywords]").val("");
            $('form.searchForm').submit();
        });
@stop

@section('content')
    <div class="container max-w-md">
        <div class="row">
            <div class="col-12 col-sm-7 px-0">
                <h3>@lang('views.organizers_management')</h3>
            </div>
            <div class="col-12 col-sm-5 mt-4 mt-sm-0 text-right px-0">
                <a class="btn btn-success create-new" href="{{ route('organizers.create') }}"><i class="fa fas fa-plus-circle"></i> @lang('views.create_new_organizer')</a>
            </div>
        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success mt-4">
                <p>{{ $message }}</p>
            </div>
        @endif

        {{-- Search form --}}
        <form class="row searchForm mt-3" action="{{ route('organizers.index') }}" method="GET">
            @csrf
            <div class="col-12 col-sm-12 col-md-8 col-lg-9 mb-2">
                @include('partials.forms.input', [
                    'name' => 'keywords',
                    'placeholder' => __('views.search_by_organizer_name'),
                    'value' => $searchKeywords
                ])
            </div>
            <div class="col-12 col-sm-12 col-md-4 col-lg-3 mt-3 mt-md-0">
                <a id="resetButton" class="btn btn-info float-right ml-2" href="#">@lang('general.reset')</a>
                <input type="submit" value="@lang('general.search')" class="btn btn-primary float-right">
            </div>
        </form>


        {{-- List of organizers --}}
        <div class="organizersList my-4">
            @foreach ($organizers as $organizer)
                <div class="row p-1 {{ $loop->index % 2 ? 'bg-light': 'bg-white' }}">
                    <div class="col-12 py-3 title">
                        <a href="{{ route('organizers.edit',$organizer->id) }}">{{ $organizer->name }}</a>
                    </div>
                    
                    <div class="col-12 pb-2 action">
                        <form action="{{ route('organizers.destroy',$organizer->id) }}" method="POST">

                            <a class="btn btn-info mr-2" href="{{ route('organizers.show',$organizer->id) }}">@lang('views.view')</a>
                            <a class="btn btn-primary" href="{{ route('organizers.edit',$organizer->id) }}">@lang('views.edit')</a>

                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger float-right">@lang('views.delete')</button>
                        </form>
                    </div>
                </div>
            @endforeach 
        </div>


        {!! $organizers->links() !!}

    </div>
@endsection
