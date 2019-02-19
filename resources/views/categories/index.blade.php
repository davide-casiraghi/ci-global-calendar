@extends('categories.layout')


@section('content')
    <div class="container max-w-md px-0">
        <div class="row">
            <div class="col-12 col-sm-7">
                <h3>@lang('views.category_management')</h3>
            </div>    
            <div class="col-12 col-sm-5 mt-sm-0 text-right">
                <a class="btn btn-success create-new" href="{{ route('categories.create') }}"><i class="fa fas fa-plus-circle"></i> @lang('views.create_new_category')</a>
            </div>
        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success mt-4">
                <p>{{ $message }}</p>
            </div>
        @endif

        {{-- List of post categories --}}
        <div class="venuesList my-4">
            @foreach ($categories as $category)
                <div class="row bg-white shadow-1 rounded mb-3 pb-2 pt-3 mx-1">
                    {{-- Title --}}
                        <div class="col-12 py-1 title">
                            <h5 class="darkest-gray">{{ $category->translate('en')->name }}</h5>
                        </div>
                        
                    {{-- Translations --}}
                        <div class="col-12 mb-4 mt-4">
                            @foreach ($countriesAvailableForTranslations as $key => $countryAvTrans)
                                @if($category->hasTranslation($key))
                                    <a href="/categoryTranslations/{{ $category->id }}/{{ $key }}/edit" class="bg-success text-white px-2 py-1 mb-1 mb-lg-0 d-inline-block rounded">{{$key}}</a>
                                @else
                                    <a href="/categoryTranslations/{{ $category->id }}/{{ $key }}/create" class="bg-secondary text-white px-2 py-1 mb-1 mb-lg-0 d-inline-block rounded">{{$key}}</a>
                                @endif
                            @endforeach
                        </div>
                        
                    {{-- Buttons --}}
                        <div class="col-12 pb-2 action">
                            <form action="{{ route('categories.destroy',$category->id) }}" method="POST">

                                <a class="btn btn-primary float-right" href="{{ route('categories.edit',$category->id) }}">@lang('views.edit')</a>
                                
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-link pl-0">@lang('views.delete')</button>
                            </form>
                        </div>
                </div>
                
            @endforeach    
        </div>
        
        {!! $categories->links() !!}
    </div>

@endsection
