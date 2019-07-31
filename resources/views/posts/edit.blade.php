@extends('posts.layout')


@section('content')
    <div class="container max-w-md px-0">
        <div class="row mb-4">
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
                    @include('laravel-form-partials::input', [
                        'title' => __('views.title'),
                        'name' => 'title',
                        'placeholder' => 'Event title',
                        'value' => $post->translate('en')->title,
                        'required' => true,
                    ])
                </div>
            </div>
            <div class="row">
                <div class="col-10">
                    @include('laravel-form-partials::input-readonly', [
                        'title' => 'Link to this post',
                        'name' => 'post_link',
                        'tooltip' => '',
                        'value' => env('APP_URL').'post/'.$post->translate('en')->slug
                    ])
                </div>
                <div class="col-2">
                    @include('laravel-form-partials::input-readonly', [
                        'title' => 'Post ID',
                        'name' => 'post_id',
                        'tooltip' => '',
                        'value' => $post->id
                    ])
                </div>
                
            </div>
            <div class="row">
                <div class="col-12">
                    @include('laravel-form-partials::select', [
                        'title' => __('views.category'),
                        'name' => 'category_id',
                        'placeholder' => __('views.select_category'),
                        'records' => $categories,
                        'selected' => $post->category_id,
                        'liveSearch' => 'false',
                        'mobileNativeMenu' => true,
                        'required' => true,
                    ])
                </div>
                <div class="col-12">
                    @include('partials.forms.textarea-plain', [
                        'title' =>  __('views.before_post_contents'),
                        'name' => 'before_content',
                        'value' => $post->translate('en')->before_content,
                        'required' => false,
                    ])
                </div>
                <div class="col-12">
                    @include('partials.forms.textarea-post', [
                        'title' => 'Text',
                        'name' => 'body',
                        'placeholder' => 'Post text',
                        'value' => $post->translate('en')->body,
                        'required' => true,
                    ])
                </div>
                <div class="col-12">
                    @include('partials.forms.textarea-plain', [
                        'title' =>  __('views.after_post_contents'),
                        'name' => 'after_content',
                        'value' => $post->translate('en')->after_content,
                        'required' => false,
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
    </div>
    
@endsection
