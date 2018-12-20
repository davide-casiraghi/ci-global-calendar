@extends('postTranslations.layout')


@section('content')

    <div class="row">
        <div class="col-12 col-sm-6">
            <h2>@lang('views.edit_translation')</h2>
        </div>
        <div class="col-12 col-sm-6 text-right">
            <span class="badge badge-secondary">{{$selectedLocaleName}}</span>
        </div>
    </div>

    @include('partials.forms.error-management', [
          'style' => 'alert-danger',
    ])

    <form action="{{ route('postTranslations.update',$postId) }}" method="POST">
        @csrf
        @method('PUT')

        @include('partials.forms.input-hidden', [
              'name' => 'post_translation_id',
              'value' => $postTranslation->id
        ])

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
                    'value' => $postTranslation->title
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.textarea-plain', [
                    'title' =>  __('views.before_post_contents'),
                    'name' => 'before_content',
                    'value' => $postTranslation->before_content,
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.textarea-post', [
                    'title' => 'Text',
                    'name' => 'body',
                    'placeholder' => 'Post text',
                    'value' => $postTranslation->body
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.textarea-plain', [
                    'title' =>  __('views.after_post_contents'),
                     'name' => 'after_content',
                     'value' => $postTranslation->after_content,
                ])
            </div>
        </div>

        @include('partials.forms.buttons-back-submit', [
            'route' => 'posts.index'  
        ])

    </form>



@endsection
