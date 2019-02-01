@extends('menus.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>@lang('views.add_new_menu')</h2>
            </div>
        </div>
    </div>

   @include('partials.forms.error-management', [
      'style' => 'alert-danger',
    ])

    <form action="{{ route('menus.store') }}" method="POST">
        @csrf

         <div class="row">
            <div class="col-12">
                @include('partials.forms.input', [
                      'title' => __('general.name'),
                      'name' => 'name',
                      'placeholder' => 'Menu Name',
                      'value' => old('name')
                ])
            </div>
        </div>

        @include('partials.forms.buttons-back-submit', [
            'route' => 'menus.index'  
        ])

    </form>

@endsection
