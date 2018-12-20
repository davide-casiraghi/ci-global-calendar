@extends('posts.layout')


@section('content')

    <div class="row">
        <div class="col-12 col-sm-6">
            <h2>@lang('views.edit_post')</h2>
        </div>
        <div class="col-12 col-sm-6 text-right">
            <span class="badge badge-secondary">English</span>
        </div>
    </div>

    @include('partials.forms.error-management', [
          'style' => 'alert-danger',
    ])

    <form action="{{ route('posts.update',$post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

         <div class="row">
            <div class="col-12">
                @include('partials.forms.input', [
                    'title' => __('views.title'),
                    'name' => 'title',
                    'placeholder' => 'Event title',
                    'value' => $post->title
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.select', [
                    'title' => __('views.category'),
                    'name' => 'category_id',
                    'placeholder' => __('views.select_category'),
                    'records' => $categories,
                    'seleted' => $post->category_id
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.textarea-plain', [
                    'title' =>  __('views.before_post_contents'),
                    'name' => 'before_content',
                    'value' => $post->before_content,
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.textarea-post', [
                    'title' => 'Text',
                    'name' => 'body',
                    'placeholder' => 'Post text',
                    'value' => $post->body
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.textarea-plain', [
                    'title' =>  __('views.after_post_contents'),
                    'name' => 'after_content',
                    'value' => $post->after_content,
                ])
            </div>
            
            @include('partials.forms.upload-image', [
                'title' => __('views.upload_profile_picture'), 
                'name' => 'introimage',
                'folder' => 'posts_intro_images',
                'value' => $post->introimage,
            ])            
        </div>

        @include('partials.forms.buttons-back-submit', [
            'route' => 'posts.index'  
        ])

    </form>

@endsection
