@extends('posts.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>@lang('views.add_new_post')</h2>
            </div>
        </div>
    </div>

    @include('partials.forms.error-management', [
          'style' => 'alert-danger',
    ])

    <form action="{{ route('posts.store') }}" method="POST">
        @csrf

         <div class="row">
            <div class="col-12">
                @include('partials.forms.input', [
                    'title' => 'Title',
                    'name' => 'title',
                    'placeholder' => 'Post title',
                    'value' => ''
                ])
            </div>
            <div class="col-12">
                <div class="form-group">
                    <strong>Slug:</strong>
                    <input type="text" name="slug" class="form-control" placeholder="Slug">
                </div>
            </div>
            <div class="col-12">
                @include('partials.forms.select', [
                    'title' => __('views.category'),
                    'name' => 'category_id',
                    'placeholder' => __('views.select_category'),
                    'records' => $categories
                ])
            </div>
            <div class="col-12">
                <div class="form-group">
                    <strong>Status:</strong>
                    <select name="status" class="form-control">
                        <option value="2" selected>Published</option>
                        <option value="1">Unpublished</option>
                    </select>

                </div>
            </div>
            <div class="col-12">
                @include('partials.forms.textarea-plain', [
                    'title' =>  __('views.before_post_contents'),
                    'name' => 'before_content',
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.textarea-post', [
                    'title' => 'Text',
                    'name' => 'body',
                    'placeholder' => 'Post text',
                    'value' => ''
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.textarea-plain', [
                    'title' =>  __('views.after_post_contents'),
                    'name' => 'after_content',
                ])
                {{--<div class="form-group">
                    <strong>After Content:</strong>
                    <textarea class="form-control" style="height:150px" name="after_content" placeholder="After the content"></textarea>
                </div>--}}
            </div>
        </div>

        <div class="row h-100 mt-3">
            <div class="col-6 pull-left my-auto">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><strong>Intro Image</strong></span>
                    </div>
                    <input id="thumbnail" class="form-control" type="text" name="introimage_src">
                    <span class="input-group-btn">
                        <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                            <i class="fa fa-picture-o"></i> Choose
                        </a>
                    </span>
                </div>
            </div>
            <div class="col-3 pull-right my-auto">
                <input type="text" name="introimage_alt" class="form-control" placeholder="Alt">
            </div>
            <div class="col-3 pull-right my-auto">
                <img id="holder" style="width:100%;">
            </div>
        </div>

        @include('partials.forms.buttons-back-submit', [
            'route' => 'posts.index'  
        ])


        <input type="hidden" name="author_id" value="1">
        <!--<input type="hidden" name="category_id" value="3">-->
        <input type="hidden" name="meta_description" value="3">
        <input type="hidden" name="meta_keywords" value="3">
        <input type="hidden" name="seo_title" value="3">
        <input type="hidden" name="image" value="3">
        <input type="hidden" name="featured" value="3">

    </form>

@endsection
