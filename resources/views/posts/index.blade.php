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
    <div class="container max-w-md px-0">
        <div class="row">
            <div class="col-12 col-sm-7">
                <h3>@lang('views.post_management')</h3>
            </div>
            <div class="col-12 col-sm-5 mt-sm-0 text-right">
                <a class="btn btn-success create-new" href="{{ route('posts.create') }}"><i class="fa fas fa-plus-circle"></i> @lang('views.create_new_post')</a>
            </div>
        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success mt-4">
                <p>{{ $message }}</p>
            </div>
        @endif

        {{-- Search form --}}
        <form class="mt-3 searchForm" action="{{ route('posts.index') }}" method="GET">
            <div class="row">    
                @csrf
                <div class="col-12 col-sm-6 pr-sm-2"> 
                    @include('partials.forms.input', [
                        'name' => 'keywords',
                        'placeholder' => __('views.search_by_post_name'),
                        'value' => $searchKeywords
                    ])
                </div>
                <div class="col-12 col-sm-6">
                    @include('partials.forms.select', [
                        'name' => 'category_id',
                        'placeholder' => __('views.filter_by_category'),
                        'records' => $categories,
                        'seleted' => $searchCategory,
                        'liveSearch' => 'false',
                        'mobileNativeMenu' => true,
                    ])
                </div>
                <div class="col-12">
                    <input type="submit" value="@lang('general.search')" class="btn btn-primary float-right ml-2">
                    <a id="resetButton" class="btn btn-outline-primary float-right" href="#">@lang('general.reset')</a>
                </div>
            </div>
        </form>


        {{-- List of posts --}}
        <div class="venuesList my-4">
            @foreach ($posts as $post)
                <div class="row bg-white shadow-1 rounded mb-3 mx-1">
                    
                    {{-- Intro Image (hidden on mobile) --}}
                    <div class="d-none d-sm-block col-sm-4 p-0">
                        @if(!empty($post->introimage))
                            <img class="rounded-left" style="width:100%; height:100%;" alt="{{ $post->title }}" src="/storage/images/posts_intro_images/thumb_{{ $post->introimage }}">
                        @else
                            <span class="gray-bg rounded-left d-block" style="width:100%; height:100%;"></span>
                        @endif
                    </div>
                    
                    <div class="col-12 col-sm-8 pb-2 pt-3 px-3">
                        <div class="row">
                            
                            {{-- Title --}}
                            <div class="col-12 py-1 title">
                                <h5 class="darkest-gray">{{ $post->title }}</h5>
                            </div>
                            <div class="col-12">
                                <i data-toggle="tooltip" data-placement="top" title="" class="fa fa-tag mr-2 dark-gray" data-original-title="@lang('general.category')"></i>
                                @if($post->category_id){{ $categories[$post->category_id] }}@endif
                            </div>
                            
                            {{-- Translations --}}
                            <div class="col-12 mb-4 mt-4">
                                @foreach ($countriesAvailableForTranslations as $key => $countryAvTrans)
                                    @if($post->hasTranslation($key))
                                        <a href="/postTranslations/{{ $post->id }}/{{ $key }}/edit" class="bg-success text-white px-2 py-1 mb-1 mb-lg-0 d-inline-block rounded">{{$key}}</a>
                                    @else
                                        <a href="/postTranslations/{{ $post->id }}/{{ $key }}/create" class="bg-secondary text-white px-2 py-1 mb-1 mb-lg-0 d-inline-block rounded">{{$key}}</a>
                                    @endif
                                @endforeach
                            </div>
                            <div class="col-12 pb-2 action">
                                <form action="{{ route('posts.destroy',$post->id) }}" method="POST">

                                    <a class="btn btn-primary float-right" href="{{ route('posts.edit',$post->id) }}">@lang('views.edit')</a>
                                    <a class="btn btn-outline-primary mr-2 float-right" href="{{ route('posts.show',$post->id) }}">@lang('views.view')</a>
                                    
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-link pl-0">@lang('views.delete')</button>
                                </form>
                            </div>
                        </div>
                    </div>    
                </div>    

                
            @endforeach    
        </div>

        {!! $posts->links() !!}
    </div>

@endsection
