@extends('users.layout')


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit User</h2>
            </div>
        </div>
    </div>

    @include('partials.forms.error-management')

    <form action="{{ route('users.update',$user->id) }}" method="POST">
        @csrf
        @method('PUT')

         <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                @include('partials.forms.input', [
                      'title' => 'Name',
                      'name' => 'name',
                      'placeholder' => 'User name',
                      'value' => $user->name
                ])
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                @include('partials.forms.input', [
                      'title' => 'Email',
                      'name' => 'email',
                      'placeholder' => 'Email',
                      'value' => $user->email
                ])
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                @include('partials.forms.password')
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Group:</strong>
                    <select name="group" class="selectpicker" title="Select user role">
                        <option value="" @if(empty($user->group)) {{'selected'}} @endif >Author</option>
                        <option value="1" @if(!empty($user->group)) {{  $user->group == '1' ? 'selected' : '' }} @endif>Super Administrator</option>
                        <option value="2" @if(!empty($user->group)) {{  $user->group == '2' ? 'selected' : '' }} @endif>Administrator</option>
                    </select>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                @include('partials.forms.select-country', [
                      'value' => $user->country_id
                ])
            </div>


            <div class="col-xs-12 col-sm-12 col-md-12">
                @include('partials.forms.textarea', [
                      'title' => 'Description',
                      'name' => 'description',
                      'placeholder' => 'To be approved as an editor of the CI Global Calendar, please describe your role in the Contact Improvisation community. (this is needed to prevent spam contents in the website)',
                      'value' => $user->description
                ])
            </div>

        </div>

        <div class="row mt-5">
            <div class="col-xs-6 col-sm-6 col-md-6 pull-left">
                <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 pull-right">
              <button type="submit" class="btn btn-primary float-right">Submit</button>
            </div>
        </div>

    </form>

@endsection
