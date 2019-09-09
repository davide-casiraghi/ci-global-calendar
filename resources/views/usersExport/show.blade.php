@extends('massMailingForms.layout')

@section('content')


<div class="container max-w-sm px-0">

    <div class="row">
        <div class="col-12">
            <h3>Export all the users</h3>
        </div>
        
        <div class="col-12 mt-5">
            Click on the export button to download an excel with all the users and their emails.
        </div>
    </div>
    
    <form action="{{ route('users-export-export') }}" method="POST">
        @csrf
        
        <div class="row mt-5">
            <div class="col-6 pull-left">
                <a class="btn btn-primary" href="{{ route('home') }}">@lang('general.back')</a>
            </div>
            <div class="col-6 pull-right">
              <button type="submit" class="btn btn-primary float-right">Export</button>
            </div>
        </div>
    
    </form>
</div>

@endsection
