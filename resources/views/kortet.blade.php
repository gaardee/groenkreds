@extends('layouts.app')

@section('content')
@if($kreds ?? false)
<kortet-component :kredse="{{ json_encode($kredse) }}" :kredsprop="{{ json_encode($kreds) }}"></kortet-component>
@else
<kortet-component :kredse="{{ json_encode($kredse) }}"></kortet-component>
@endif
@endsection

