@extends('categories.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>@lang('views.category_management')</h2>
            </div>
            <div class="pull-right mt-4 float-right">
                <a class="btn btn-success create-new" href="{{ route('categories.create') }}"><i class="fa fas fa-plus-circle"></i> @lang('views.create_new_category')</a>
            </div>
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
            <div class="row p-1 {{ $loop->index % 2 ? 'bg-light': 'bg-white' }}">
                
                {{-- Title --}}
                    <div class="col-5 py-2 title">
                        <a href="{{ route('categories.edit',$category->id) }}">{{ $category->translate('en')->name }}</a>
                    </div>
                
                {{-- Translations --}}
                    <div class="col-5 text-right translation mt-2" style="line-height: 2rem;">
                        @foreach ($countriesAvailableForTranslations as $key => $countryAvTrans)
                            @if($category->hasTranslation($key))
                                <a href="/categoryTranslations/{{ $category->id }}/{{ $key }}/edit" class="bg-success text-white px-2 mb-1 d-inline-block rounded">{{$key}}</a>
                            @else
                                <a href="/categoryTranslations/{{ $category->id }}/{{ $key }}/create" class="bg-secondary text-white px-2 mb-1 d-inline-block rounded">{{$key}}</a>
                            @endif
                        @endforeach
                    </div>
                
                <div class="col-2 pb-2 action">
                    <form action="{{ route('categories.destroy',$category->id) }}" method="POST">

                        
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger float-right"><i class="far fa-trash-alt"></i></button>
                    </form>
                </div>
            </div>
        @endforeach    
    </div>
    {{-- List of post categories --}}
    {{-- <table class="table table-bordered mt-4">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Slug</th>
            <th width="280">Action</th>
        </tr>
        @foreach ($categories as $category)
        <tr>
            <td>{{ $category->id }}</td>
            <td>{{ $category->name }}</td>
            <td>{{ $category->slug }}</td>
            <td>
                <form action="{{ route('categories.destroy',$category->id) }}" method="POST">


                    <a class="btn btn-info" href="{{ route('categories.show',$category->id) }}">Show</a>
                    <a class="btn btn-primary" href="{{ route('categories.edit',$category->id) }}">Edit</a>


                    @csrf
                    @method('DELETE')


                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>--}}


    {!! $categories->links() !!}


@endsection
