@extends('posts.layout')


@section('content')
    <div class="container max-w-md px-0">
    
        <div class="row mb-4">
            <div class="col-12 col-sm-8">
                <h3>@lang('views.add_new_post')</h3>
            </div>
            <div class="col-12 col-sm-4 text-right">
                <span class="badge badge-secondary">English</span>
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
                        'title' => __('views.title'),
                        'name' => 'title',
                        'placeholder' => 'Post title',
                        'value' => old('title')
                    ])
                </div>
                
                <div class="col-12">
                    @include('partials.forms.select', [
                        'title' => __('views.category'),
                        'name' => 'category_id',
                        'placeholder' => __('views.select_category'),
                        'records' => $categories,
                        'liveSearch' => 'false',
                        'mobileNativeMenu' => true,
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
                        'value' => old('before_content')
                    ])
                </div>
                <div class="col-12">
                    @include('partials.forms.textarea-post', [
                        'title' => 'Text',
                        'name' => 'body',
                        'placeholder' => 'Post text',
                        'value' => old('body')
                    ])
                </div>
                <div class="col-12">
                    @include('partials.forms.textarea-plain', [
                        'title' =>  __('views.after_post_contents'),
                        'name' => 'after_content',
                        'value' => old('after_content')
                    ])
                </div>
                
                @include('partials.forms.upload-image', [
                      'title' => __('views.upload_profile_picture'), 
                      'name' => 'introimage',
                      'folder' => 'posts_intro_images',
                      'value' => ''
                ])
            </div>

            @include('partials.forms.buttons-back-submit', [
                'route' => 'posts.index'  
            ])


            <input type="hidden" name="featured" value="0">

        </form>
    </div>
@endsection
