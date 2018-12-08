@extends('posts.layout')

@section('javascript-document-ready')
    @parent

    {{-- Clear filters on click reset button --}}
    $("#resetButton").click(function(){
        $("input#keywords").val("");
        $('#category option').prop("selected", false).trigger('change');
        $('form.searchForm').submit();
    });

@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <h2>@lang('views.post_management')</h2>
        </div>
        <div class="col-12 mt-4 mt-sm-0 text-right">
            <a class="btn btn-success" href="{{ route('posts.create') }}">@lang('views.create_new_post')</a>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success mt-4">
            <p>{{ $message }}</p>
        </div>
    @endif

    {{-- Search form --}}
    <form class="row mt-3 searchForm" action="{{ route('posts.index') }}" method="GET">
        @csrf
        <div class="form-group col-12 col-sm-6 col-md-6 col-lg-6"> 
            <input type="text" name="keywords" id="keywords" class="form-control" placeholder="@lang('views.search_by_post_name')" value="{{ $searchKeywords }}">
        </div>
        <div class="col-12 col-sm-6 col-md-6 col-lg-3">
            <select name="category_id" class="form-control">
                <option value="">@lang('views.filter_by_category')</option>
                @foreach ($categories as $value => $category)
                    {{-- {{ $event->category_id == $value ? 'selected' : '' }} --}}
                    <option value="{{$value}}" {{ $searchCategory == $value ? 'selected' : '' }} >{!! $category !!} </option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-sm-12 col-md-12 col-lg-3 mt-sm-0 mt-3">
            <a id="resetButton" class="btn btn-info float-right ml-2" href="#">@lang('general.reset')</a>
            <input type="submit" value="@lang('general.search')" class="btn btn-primary float-right">
        </div>
    </form>

    {{-- List of posts --}}
    <table class="table table-bordered mt-4">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Category</th>
            <th width="160">Translations</th>
            <th width="280">Action</th>
        </tr>
        @foreach ($posts as $post)
        <tr>
            <td>{{ $post->id }}</td>
            <td>{{ $post->title }}</td>
            <td>{{ $categories[$post->category_id] }}</td>
            <td style="line-height: 2rem;">
                @foreach ($countriesAvailableForTranslations as $key => $countryAvTrans)
                    @if($post->hasTranslation($key))
                        <a href="postTranslations/{{ $post->id }}/{{ $key }}/edit" class="bg-success text-white p-1 mb-1">{{$key}}</a>
                    @else
                        <a href="postTranslations/{{ $post->id }}/{{ $key }}/create" class="bg-secondary text-white p-1 mb-1">{{$key}}</a>
                    @endif


                @endforeach
            </td>
            <td>
                <form action="{{ route('posts.destroy',$post->id) }}" method="POST">

                    <a class="btn btn-info" href="{{ route('posts.show',$post->id) }}">Show</a>
                    <a class="btn btn-primary" href="{{ route('posts.edit',$post->id) }}">Edit</a>

                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>


    {!! $posts->links() !!}


@endsection
