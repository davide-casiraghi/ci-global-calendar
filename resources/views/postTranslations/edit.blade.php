@extends('postTranslations.layout')


@section('content')
    <div class="container max-w-md px-0">

        <div class="row py-4">
            <div class="col-12 col-sm-9">
                <h4>@lang('views.edit_translation')</h4>
            </div>
            <div class="col-12 col-sm-3 text-right">
                <span class="badge badge-secondary">{{$selectedLocaleName}}</span>
            </div>
        </div>

        @include('laravel-form-partials::error-management', [
              'style' => 'alert-danger',
        ])

        <form action="{{ route('postTranslations.update',$postId) }}" method="POST">
            @csrf
            @method('PUT')

            @include('laravel-form-partials::input-hidden', [
                  'name' => 'post_translation_id',
                  'value' => $postTranslation->id
            ])

            @include('laravel-form-partials::input-hidden', [
                  'name' => 'post_id',
                  'value' => $postId
            ])
            @include('laravel-form-partials::input-hidden', [
                  'name' => 'language_code',
                  'value' => $languageCode
            ])

             <div class="row">
                <div class="col-12">
                    @include('laravel-form-partials::input', [
                        'title' => 'Title',
                        'name' => 'title',
                        'placeholder' => 'Post title',
                        'value' => $postTranslation->title,
                        'required' => true,
                    ])
                </div>
                <div class="col-12">
                    @include('laravel-form-partials::textarea-plain', [
                        'title' =>  __('views.before_post_contents'),
                        'name' => 'before_content',
                        'value' => $postTranslation->before_content,
                        'required' => false,
                    ])
                </div>
                <div class="col-12">
                    @include('laravel-form-partials::textarea-post', [
                        'title' => 'Text',
                        'name' => 'body',
                        'placeholder' => 'Post text',
                        'value' => $postTranslation->body,
                        'required' => true,
                    ])
                </div>
                <div class="col-12">
                    @include('laravel-form-partials::textarea-plain', [
                        'title' =>  __('views.after_post_contents'),
                         'name' => 'after_content',
                         'value' => $postTranslation->after_content,
                         'required' => false,
                    ])
                </div>
            </div>
            
            <div class="row mt-2">  
                <div class="col-12 action">
                    @include('laravel-form-partials::buttons-back-submit', [
                        'route' => 'posts.index'  
                    ])
        </form>

                    <form action="{{ route('postTranslations.destroy',$postTranslation->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-link pl-0">@lang('views.delete_translation')</button>
                    </form>
                </div>
            </div>
    </div>

@endsection
