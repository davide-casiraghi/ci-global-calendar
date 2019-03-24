@extends('stats.layout')

@section('javascript-document-ready')
    @parent
    
@stop

@section('content')
    stats view
    
    {{$statsDatas['registeredUsersNumber']}}

@endsection
