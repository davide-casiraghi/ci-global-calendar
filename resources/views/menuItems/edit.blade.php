@extends('menuItems.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>@lang('views.edit_menu_item')</h2>
            </div>
        </div>
    </div>

    @include('partials.forms.error-management', [
      'style' => 'alert-danger',
    ])

    <form action="{{ route('menuItems.update',$menuItem->id) }}" method="POST">
        @csrf
        @method('PUT')

         <div class="row">
            <div class="col-12">
                @include('partials.forms.input', [
                      'title' => __('general.name'),
                      'name' => 'name',
                      'placeholder' => 'menu item Name',
                      'value' => $menuItem->name
                ])
            </div>
        </div>

        @include('partials.forms.buttons-back-submit', [
            'route' => 'menuItems.index'  
        ])

    </form>

@endsection
