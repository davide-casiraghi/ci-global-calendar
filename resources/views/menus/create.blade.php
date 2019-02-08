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
            
            <div class="col-12">
                <div class="form-group">
                    <strong>@lang('views.menu_position'):</strong>
                    <select name="type" class="selectpicker" title="Position">
                        <option value="1" {{'selected'}}>Nav - Left (main)</option>
                        <option value="2">Nav - Right</option>
                        <option value="3">Footer</option>
                        <option value="4">Custom 1</option>
                        <option value="5">Custom 2</option>
                        <option value="6">Custom 3</option>
                    </select>
                </div>
            </div>
            
        </div>

        @include('partials.forms.buttons-back-submit', [
            'route' => 'menus.index'  
        ])

    </form>

@endsection
