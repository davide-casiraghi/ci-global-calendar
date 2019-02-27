@extends('postTranslations.layout')


@section('content')
    <div class="container max-w-md px-0">
    
        <div class="row py-4">
            <div class="col-12 col-sm-9">
                <h4>@lang('views.add_new_translation')</h4>
            </div>
            <div class="col-12 col-sm-3 text-right">
                <span class="badge badge-secondary">{{$selectedLocaleName}}</span>
            </div>
        </div>

        @include('partials.forms.error-management', [
              'style' => 'alert-danger',
        ])

        <form action="{{ route('postTranslations.store') }}" method="POST">
            @csrf

                @include('partials.forms.input-hidden', [
                      'name' => 'post_id',
                      'value' => $postId
                ])
                @include('partials.forms.input-hidden', [
                      'name' => 'language_code',
                      'value' => $languageCode
                ])

             <div class="row">
                <div class="col-12">
                    @include('partials.forms.input', [
                        'title' => 'Title',
                        'name' => 'title',
                        'placeholder' => 'Post title',
                        'value' => old('title')
                    ])
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
            </div>

            <div class="row mt-2">  
                <div class="col-12 action">
                    @include('partials.forms.buttons-back-submit', [
                        'route' => 'posts.index'  
                    ])
                </div>
            </div>

        </form>
    </div>
@endsection
