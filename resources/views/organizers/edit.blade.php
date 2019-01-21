@extends('organizers.layout')


@section('content')
    <div class="row">
        <div class="col-12 margin-tb">
            <div class="pull-left">
                <h2>@lang('views.edit_organizer')</h2>
            </div>
        </div>
    </div>

    @include('partials.forms.error-management', [
          'style' => 'alert-danger',
    ])

    <form action="{{ route('organizers.update',$organizer->id) }}" method="POST">
        @csrf
        @method('PUT')

         <div class="row">
            <div class="col-12">
                @include('partials.forms.input', [
                    'title' => __('general.name'),
                    'name' => 'name',
                    'placeholder' => __('homepage-serach.organizer_name'),
                    'value' => $organizer->name
                ])
            </div>

            {{-- Show the created by field just to the admin and super admin --}}
            @if(empty($authorUserId))
                <div class="col-12">
                    @include('partials.forms.select', [
                          'title' => __('views.created_by'),
                          'name' => 'created_by',
                          'placeholder' => __('views.select_owner'),
                          'records' => $users,
                          'seleted' => $organizer->created_by,
                          'liveSearch' => 'true',
                          'mobileNativeMenu' => false,
                    ])
                </div>
            @endif

            <div class="col-12">
                @include('partials.forms.input', [
                    'title' => __('general.email_address'),
                    'name' => 'email',
                    'value' => $organizer->email
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.input', [
                    'title' => __('general.phone'),
                    'name' => 'phone',
                    'value' => $organizer->phone
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.input', [
                    'title' => __('views.website'),
                    'name' => 'website',
                    'placeholder' => 'https://...',
                    'value' => $organizer->website
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.textarea', [
                      'title' => __('general.description'),
                      'name' => 'description',
                      'placeholder' => '',
                      'value' => $organizer->description
                ])
            </div>
        </div>

        {{-- used to not update the slug --}}
        @include('partials.forms.input-hidden', [
              'name' => 'slug',
              'value' => $organizer->slug,
        ])

        @include('partials.forms.buttons-back-submit', [
            'route' => 'organizers.index'  
        ])

    </form>

@endsection
