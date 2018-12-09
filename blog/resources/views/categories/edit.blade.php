@extends('categories.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>@lang('views.edit_category')</h2>
            </div>
        </div>
    </div>

    @include('partials.forms.error-management', [
        'style' => 'alert-danger',
    ])

    <form action="{{ route('categories.update',$category->id) }}" method="POST">
        @csrf
        @method('PUT')

         <div class="row">
            <div class="col-12">
                @include('partials.forms.input', [
                      'title' => __('general.name'),
                      'name' => 'name',
                      'placeholder' => 'Category name',
                      'value' => $category->name
                ])
            </div>
            <div class="col-12">
                @include('partials.forms.textarea', [
                      'title' => __('general.description'),
                      'name' => 'description',
                      'placeholder' => 'Description',
                      'value' => $category->description
                ])
            </div>
        </div>
        <div class="row">
            <div class="col-6 pull-left">
                <a class="btn btn-primary" href="{{ route('categories.index') }}"> Back</a>
            </div>
            <div class="col-6 pull-right">
              <button type="submit" class="btn btn-primary float-right">Submit</button>
            </div>
        </div>


    </form>


@endsection
