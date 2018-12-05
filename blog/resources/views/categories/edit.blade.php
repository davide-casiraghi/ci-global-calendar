@extends('categories.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Category</h2>
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
            <div class="col-xs-12 col-sm-12 col-md-12">
                @include('partials.forms.input', [
                      'title' => 'Name',
                      'name' => 'name',
                      'placeholder' => 'Category name',
                      'value' => $category->name
                ])
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                @include('partials.forms.textarea', [
                      'title' => 'Description',
                      'name' => 'description',
                      'placeholder' => 'Description',
                      'value' => $category->description
                ])
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 pull-left">
                <a class="btn btn-primary" href="{{ route('categories.index') }}"> Back</a>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 pull-right">
              <button type="submit" class="btn btn-primary float-right">Submit</button>
            </div>
        </div>


    </form>


@endsection
