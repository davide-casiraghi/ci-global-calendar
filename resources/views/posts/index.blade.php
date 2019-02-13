@extends('posts.layout')

@section('javascript-document-ready')
    @parent

    {{-- Clear filters on click reset button --}}
    $("#resetButton").click(function(){
        $("input[name=keywords]").val("");
        $("select[name=category_id] option").prop("selected", false).trigger('change');
        $('form.searchForm').submit();
    });

@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <h2>@lang('views.post_management')</h2>
        </div>
        <div class="col-12 mt-4 mt-sm-0 text-right">
            <a class="btn btn-success create-new" href="{{ route('posts.create') }}"><i class="fa fas fa-plus-circle"></i> @lang('views.create_new_post')</a>
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
        <div class="col-12 col-sm-6 col-md-6 col-lg-6"> 
            @include('partials.forms.input', [
                'name' => 'keywords',
                'placeholder' => __('views.search_by_post_name'),
                'value' => $searchKeywords
            ])
        </div>
        <div class="col-12 col-sm-6 col-md-6 col-lg-3">
            @include('partials.forms.select', [
                'name' => 'category_id',
                'placeholder' => __('views.filter_by_category'),
                'records' => $categories,
                'seleted' => $searchCategory,
                'liveSearch' => 'false',
                'mobileNativeMenu' => true,
            ])
        </div>
        <div class="col-12 col-lg-3 mt-sm-0 mt-3">
            <a id="resetButton" class="btn btn-info float-right ml-2" href="#">@lang('general.reset')</a>
            <input type="submit" value="@lang('general.search')" class="btn btn-primary float-right">
        </div>
    </form>


    {{-- List of posts --}}
    
    <div class="venuesList my-4">
        @foreach ($posts as $post)
            <div class="row p-1 {{ $loop->index % 2 ? 'bg-light': 'bg-white' }}">
                
                {{-- Title and Preview --}}
                    <div class="col-10 col-md-5 col-lg-5 pt-2 order-1 title">
                        <a href="{{ route('posts.edit',$post->id) }}">{{ $post->translate('en')->title }}</a>
                        <a class="btn btn-secondary ml-2 py-0 px-1 float-md-right" href="{{ route('posts.show',$post->id) }}" data-toggle="tooltip" data-placement="top" data-original-title="@lang('views.preview')"><small><i class="fas fa-eye"></i></small></a>
                    </div>
                
                {{-- Category --}}
                    <div class="col-6 col-md-2 col-lg-3 pt-2 order-3 order-md-2 category">
                        <i data-toggle="tooltip" data-placement="top" title="" class="fa fa-tag mr-2" data-original-title="@lang('general.category')"></i>
                        {{ $categories[$post->category_id] }}
                    </div>
                
                {{-- Translations --}}
                    <div class="col-6 col-md-3 col-lg-3 pt-1 order-4 order-md-3 translation" style="line-height: 2rem;">
                        @foreach ($countriesAvailableForTranslations as $key => $countryAvTrans)
                            @if($post->hasTranslation($key))
                                <a href="/postTranslations/{{ $post->id }}/{{ $key }}/edit" class="bg-success text-white p-1 mb-1">{{$key}}</a>
                            @else
                                <a href="/postTranslations/{{ $post->id }}/{{ $key }}/create" class="bg-secondary text-white p-1 mb-1">{{$key}}</a>
                            @endif
                        @endforeach
                    </div>
                
                {{-- Delete --}}
                    <div class="col-2 col-lg-1 order-2 order-md-4 action">
                        <form action="{{ route('posts.destroy',$post->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger float-right"><i class="far fa-trash-alt"></i></button>
                        </form>
                    </div>
            </div>
        @endforeach    
    </div>


    {!! $posts->links() !!}


@endsection
