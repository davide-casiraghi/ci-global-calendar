@extends('backgroundImages.layout')

@section('content')

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Contact the administrator</h2>
            </div>
        </div>
    </div>

    <form action="{{ route('posts.store') }}" method="POST">
        @csrf

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
                     'title' => 'Message',
                     'name' => 'message',
                     'placeholder' => 'Your message'
               ])
           </div>

       </div>

       <div class="row mt-5">
           <div class="col-xs-6 col-sm-6 col-md-6 pull-left">
               <a class="btn btn-primary" href="{{ route('home') }}"> Back</a>
           </div>
           <div class="col-xs-6 col-sm-6 col-md-6 pull-right">
             <button type="submit" class="btn btn-primary float-right">Send</button>
           </div>
       </div>
   </form>

@endsection
