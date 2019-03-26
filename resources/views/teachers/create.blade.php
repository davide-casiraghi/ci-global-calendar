@extends('teachers.layout')


@section('content')
    <div class="container max-w-md px-0">
        
        <div class="row mb-4">
            <div class="col-12">
                <h4>@lang('views.add_new_teacher')</h4>
            </div>
        </div>

        @include('partials.forms.error-management', [
              'style' => 'alert-danger',
        ])

        <form action="{{ route('teachers.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

             <div class="row">
                <div class="col-12">
                    @include('partials.forms.input', [
                          'title' => __('general.name'),
                          'name' => 'name',
                          'placeholder' => __('homepage-serach.teacher_name'),
                          'value' => old('name'),
                          'required' => true,
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
                              'liveSearch' => 'true',
                              'mobileNativeMenu' => false,
                              'seleted' => old('created_by'),
                        ])
                    </div>
                @endif

                <div class="col-12">
                    @include('partials.forms.select', [
                          'title' => __('general.country'),
                          'name' => 'country_id',
                          'placeholder' => __('views.select_country'), 
                          'records' => $countries,
                          'liveSearch' => 'true',
                          'mobileNativeMenu' => false,
                          'seleted' => old('country_id'),
                          'required' => false,
                    ])
                </div>

                <div class="col-12">
                    @include('partials.forms.textarea-plain', [
                          'title' =>  __('views.bio'),
                          'name' => 'bio',
                          'value' => old('bio'),
                          'required' => true,
                    ])
                </div>

                <div class="col-12">
                    @include('partials.forms.input', [
                          'title' => __('views.year_of_starting_to_practice'),
                          'name' => 'year_starting_practice',
                          'placeholder' => 'AAAA',
                          'value' => old('year_starting_practice'),
                          'required' => true,
                    ])
                </div>

                <div class="col-12">
                    @include('partials.forms.input', [
                          'title' => __('views.year_of_starting_to_teach'),
                          'name' => 'year_starting_teach',
                          'placeholder' => 'AAAA',
                          'value' => old('year_starting_teach'),
                          'required' => true,
                    ])
                </div>

                <div class="col-12">
                    @include('partials.forms.textarea-plain', [
                          'title' =>  __('views.significant_teachers'),
                          'name' => 'significant_teachers',
                          'value' => old('significant_teachers'),
                          'required' => true,
                    ])
                </div>

                <div class="col-12">
                    @include('partials.forms.input', [
                          'title' => __('views.facebook_profile'),
                          'name' => 'facebook',
                          'placeholder' => 'https://...',
                          'value' => old('facebook'),
                          'required' => false,
                    ])
                </div>

                <div class="col-12">
                    @include('partials.forms.input', [
                          'title' => __('views.website'),
                          'name' => 'website',
                          'placeholder' => 'https://...',
                          'value' => old('facebook'),
                          'required' => false,
                    ])
                </div>

                @include('partials.forms.upload-image', [
                      'title' => __('views.upload_profile_picture'), 
                      'name' => 'profile_picture',
                      'folder' => 'teachers_profile',
                      'value' => ''
                ])
            </div>

            @include('partials.forms.buttons-back-submit', [
                'route' => 'teachers.index'  
            ])

        </form>
    </div>
    
@endsection
