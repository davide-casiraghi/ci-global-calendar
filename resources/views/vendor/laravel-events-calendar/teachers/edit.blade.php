@extends('laravel-events-calendar::teachers.layout')


@section('content')
    <div class="container max-w-md px-0">
        
        <div class="row mb-4">
            <div class="col-12">
                <h4>@lang('laravel-events-calendar::teacher.edit_teacher')</h4>
            </div>
        </div>

        @include('laravel-form-partials::error-management', [
              'style' => 'alert-danger',
        ])

        <form action="{{ route('teachers.update',$teacher->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

             <div class="row">
                <div class="col-12">
                    @include('laravel-form-partials::input', [
                        'title' => __('laravel-events-calendar::general.name'),
                        'name' => 'name',
                        'placeholder' => '',
                        'value' => $teacher->name,
                        'required' => true,
                    ])
                </div>

                {{-- Show the created by field just to the admin and super admin --}}
                @if(empty($authorUserId))
                    <div class="col-12">
                        @include('laravel-form-partials::select', [
                              'title' => __('laravel-events-calendar::general.created_by'),
                              'name' => 'created_by',
                              'placeholder' => __('laravel-events-calendar::general.select_owner'),
                              'records' => $users,
                              'selected' => $teacher->created_by,
                              'liveSearch' => 'true',
                              'mobileNativeMenu' => false,
                              'required' => false,
                        ])
                    </div>
                @endif

                <div class="col-12">
                    @include('laravel-form-partials::select', [
                          'title' => __('laravel-events-calendar::general.country'),
                          'name' => 'country_id',
                          'placeholder' => __('laravel-events-calendar::general.select_country'),
                          'records' => $countries,
                          'selected' => $teacher->country_id,
                          'liveSearch' => 'true',
                          'mobileNativeMenu' => false,
                          'required' => false,
                    ])
                </div>

                <div class="col-12">
                    @include('laravel-form-partials::textarea', [
                         'title' =>  __('laravel-events-calendar::teacher.bio'),
                          'name' => 'bio',
                          'value' => $teacher->bio,
                          'required' => false,
                    ])
                </div>
                <div class="col-12">
                    @include('laravel-form-partials::input', [
                          'title' => __('laravel-events-calendar::teacher.year_of_starting_to_practice'),
                          'name' => 'year_starting_practice',
                          'placeholder' => 'AAAA',
                          'value' => $teacher->year_starting_practice,
                          'required' => true,
                    ])
                </div>
                <div class="col-12">
                    @include('laravel-form-partials::input', [
                          'title' => __('laravel-events-calendar::teacher.year_of_starting_to_teach'),
                          'name' => 'year_starting_teach',
                          'placeholder' => 'AAAA',
                          'value' => $teacher->year_starting_teach,
                          'required' => true,
                    ])
                </div>
                
                <div class="col-12">
                    @include('laravel-form-partials::textarea-plain', [
                          'title' =>  __('laravel-events-calendar::teacher.significant_teachers'),
                          'name' => 'significant_teachers',
                          'value' => $teacher->significant_teachers,
                          'required' => true,
                    ])
                </div>
                
                <div class="col-12">
                    @include('laravel-form-partials::input', [
                          'title' => __('laravel-events-calendar::teacher.facebook_profile'),
                          'name' => 'facebook',
                          'placeholder' => 'https://...',
                          'value' => $teacher->facebook ,
                          'required' => false,
                    ])
                </div>
                <div class="col-12">
                    @include('laravel-form-partials::input', [
                          'title' => __('laravel-events-calendar::general.website'),
                          'name' => 'website',
                          'placeholder' => 'https://...',
                          'value' => $teacher->website,
                          'required' => false,
                    ])
                </div>

                @include('laravel-form-partials::upload-image', [
                      'title' => __('laravel-events-calendar::teacher.upload_profile_picture'), 
                      'name' => 'profile_picture',
                      'folder' => 'teachers_profile',
                      'value' => $teacher->profile_picture,
                ])
            </div>

            {{-- used to not update the slug --}}
            @include('laravel-form-partials::input-hidden', [
                  'name' => 'slug',
                  'value' => $teacher->slug,
            ])

            @include('laravel-form-partials::buttons-back-submit', [
                'route' => 'teachers.index'  
            ])

        </form>
    </div>
@endsection
