@extends('postTranslations.layout')


@section('content')
    
    <div class="row">
        <div class="col-12 col-sm-6">
            <h2>@lang('views.add_new_translation')</h2>
        </div>
        <div class="col-12 col-sm-6 text-right">
            <span class="badge badge-secondary">{{$selectedLocaleName}}</span>
        </div>
    </div>

    @include('partials.forms.error-management', [
          'style' => 'alert-danger',
    ])

    {{--<form action="/postTranslations/{{ $postId }}/{{ $languageCode }}/store" method="POST">--}}
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
                    'value' => ''
                ])
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
            </div>
        </div>

        @include('partials.forms.buttons-back-submit', [
            'route' => 'posts.index'  
        ])

    </form>

@endsection
