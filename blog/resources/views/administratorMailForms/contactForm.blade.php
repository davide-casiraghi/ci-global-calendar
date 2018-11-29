@extends('backgroundImages.layout')

@section('content')

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Contact the administrator</h2>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 mt-3 mb-5">
            Please write your text in english.
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
           @include('partials.forms.input', [
                 'title' => 'Name',
                 'name' => 'name',
                 'placeholder' => 'Your name'
           ])
        </div>

       <div class="col-xs-12 col-sm-12 col-md-12">
           @include('partials.forms.input', [
                 'title' => 'Email',
                 'name' => 'email',
                 'placeholder' => 'Your email'
           ])
       </div>

       <div class="col-xs-12 col-sm-12 col-md-12">
           @include('partials.forms.textarea-plain', [
                 'title' => 'Description',
                 'name' => 'description',
                 'placeholder' => 'Your message'
           ])
       </div>
   </div>

@endsection
