@extends('eventCategories.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>@lang('views.events_category_management')</h2>
            </div>
            <div class="pull-right mt-4 float-right">
                <a class="btn btn-success create-new" href="{{ route('eventCategories.create') }}"><i class="fa fas fa-plus-circle"></i> @lang('views.create_new_category')</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success mt-4">
            <p>{{ $message }}</p>
        </div>
    @endif


    {{-- List of event categories --}}
    <div class="venuesList my-4">
        @foreach ($eventCategories as $eventCategory)
            <div class="row p-1 {{ $loop->index % 2 ? 'bg-light': 'bg-white' }}">
                
                {{-- Title --}}
                    <div class="col-5 py-2 title">
                        <a href="{{ route('eventCategories.edit',$eventCategory->id) }}">{{ $eventCategory->translate('en')->name }}</a>
                    </div>
                    
                {{-- Translations --}}
                    <div class="col-5 text-right translation mt-1">
                        @foreach ($countriesAvailableForTranslations as $key => $countryAvTrans)
                            @if($eventCategory->hasTranslation($key))
                                <a href="/eventCategoryTranslations/{{ $eventCategory->id }}/{{ $key }}/edit" class="bg-success text-white px-2 py-1 mb-1 mb-lg-0 d-inline-block rounded">{{$key}}</a>
                            @else
                                <a href="/eventCategoryTranslations/{{ $eventCategory->id }}/{{ $key }}/create" class="bg-secondary text-white px-2 py-1 mb-1 mb-lg-0 d-inline-block rounded">{{$key}}</a>
                            @endif
                        @endforeach
                    </div>
                
                <div class="col-2 action">
                    <form action="{{ route('eventCategories.destroy',$eventCategory->id) }}" method="POST">

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger float-right"><i class="far fa-trash-alt"></i></button>
                    </form>
                </div>
            </div>
        @endforeach    
    </div>


    {!! $eventCategories->links() !!}


@endsection
