@extends('layouts.app')

@section('content')
<div class="container pt-4">
    <div class="row mt-4 mb-4">
        <h1 class="title">{{ $page->navn }}</h1>
        <div class="col-12" style="font-size: 1rem;">
            {!! $page->content !!}
        </div>
    </div>
</div>
@endsection
