@extends('layouts.app')

@section('content')
<div id="kortet-app"
    data-kredse="{{ json_encode($kredse) }}"
    @isset($kreds) data-kreds="{{ json_encode($kreds) }}" @endisset
></div>
@endsection
