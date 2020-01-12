@extends('layouts.app')

@section('content')
<div id="modalShadow" class="{{ $slug ? 'show' : '' }}"></div>
<div class="container pt-4">
    <div class="row mt-4">
        <h1 class="title">Aktiviteter</h1>
    </div>
</div>
<div class="container mb-4 mt-4">
    <div id="aktiviteter">
        @forelse($aktiviteter AS $a)
        @if($a)
        <div class="aktivitet type-{{ $a->type }} {{ $slug == $a->slug ? 'open' : 'closed' }}" data-slug="{{ $a->slug }}">
            <div class="top">
                <div class="d-flex align-items-center">
                    <div class="icon-badge rounded-circle">
                        <i class="{{ $a->ikon }}"></i>
                    </div>
                    <div class="titel">
                        {{ $a->title }}
                    </div>
                </div>
                <div class="btn btn-link close">
                    <i class="fas fa-times"></i>
                </div>
            </div>
            <div class="image-holder">
                <img src="{{ url("storage/aktiviteter/{$a->path}") }}">
            </div>
            <div class="p-4">
                <h3>Aktivitet</h3>
                {!! $a->indhold !!}
            </div>
            <div class="p-4">
                <h3>Materialer</h3>
                {!! $a->materialer !!}
            </div>
        </div>
        @else
        <div class="empty"></div>
        @endif
        @empty
        <div></div>
        <div class="text-center" style="width: 100%;">Der er ikke nogen aktiviteter endnu</div>
        @endforelse
    </div>
</div>
@endsection

@section('scripts')
<script>
$( document ).ready(function() {
    $(".aktivitet.closed").click(function(){
        $(this).removeClass('closed').addClass('open');
        $("<div id='placeholder'></div>").insertAfter($(this));
        $(window).scrollTop(0);
        window.history.replaceState(
          "aktivitet",
          "Aktivitet - " + $(this).data('slug'),
          "/aktiviteter/" + $(this).data('slug')
        );
        $("#modalShadow").show();
    });
    $(".aktivitet .close, #modalShadow").click(function(e){
        closeModal();
        e.stopPropagation();
    });
});
function closeModal(){
    $("#placeholder").remove();
    $("#modalShadow").hide();
    $(".open").removeClass('open').addClass('closed');
        window.history.replaceState(
          "aktiviteter",
          "Aktiviteter",
          "/aktiviteter"
        );
}
</script>
@endsection
