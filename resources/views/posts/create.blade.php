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

    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
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
            
            @include('partials.forms.upload-image', [
                  'title' => __('views.upload_profile_picture'), 
                  'name' => 'introimage',
                  'value' => ''
            ])
        </div>

        @include('partials.forms.buttons-back-submit', [
            'route' => 'posts.index'  
        ])


        <input type="hidden" name="featured" value="0">

    </form>

@endsection
