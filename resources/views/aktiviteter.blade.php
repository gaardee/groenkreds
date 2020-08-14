@extends('layouts.app')

@section('content')
<div class="container pt-4">
    <div class="row mt-4">
        <h1 class="title">Aktiviteter</h1>
    </div>
</div>
<div class="container mb-4 mt-4">
    <div id="aktiviteter">
        <div class="aktivitet-header type-1">KREDSEN I LOKALMILJØET</div>
        <div class="aktivitet-header type-2">KREDSENS LEVEVEJ</div>
        <div class="aktivitet-header type-3">DEN LEGENDE KREDS</div>
        @forelse($aktiviteter AS $a)
        @if($a)
    <div class="aktivitet type-{{ $a->type }}"
            data-toggle="modal"
            data-target="#exampleModal"
            data-type="type-{{ $a->type }}"
            data-slug="{{ $a->slug }}"
            data-title="{{ $a->title }}"
            data-aktiviteter="{{ $a->indhold }}"
            data-ikon="{{ $a->ikon }}"
            data-image="{{ $a->path != '' ? url('storage/' . $a->path) : url('images/aktivitet_placeholder.png') }}"
            data-materialer="{!! $a->materialer !!}"
        >
            <div class="top d-flex align-items-center">
                <div class="icon-badge rounded-circle">
                    <i class="{{ $a->ikon }}"></i>
                </div>
                <div class="titel">
                    {{ $a->title }}
                </div>
            </div>
            <div class="image-holder">
                <img src="{{ $a->path != '' ? url('storage/' . $a->path) : url('images/aktivitet_placeholder.png') }}">
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
<div class="modal fade aktivitet-modal {{ $aktivitet ? 'type-' . $aktivitet->type : '' }}" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <div class="icon-badge rounded-circle">
            <i class="{{ $aktivitet->ikon ?? '' }}"></i>
        </div>
        <h5 class="modal-title" id="exampleModalLabel">{{ $aktivitet->title ?? '' }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="image-holder">
            <img src="{{ $aktivitet ? $aktivitet->path != '' ? url('storage/' . $aktivitet->path) : url('images/aktivitet_placeholder.png') : '' }}">
        </div>
        <div class="p-4">
            <h3>Aktivitet</h3>
            <div id="aktiviteter-indhold">{!! $aktivitet->indhold ?? '' !!}</div>
        </div>
        <div class="p-4" id="materialer" style="display:{{ $aktivitet ? $aktivitet->materialer ? 'block' : 'none' : 'none' }}">
            <h3>Materialer</h3>
            <div id="materialer-indhold">{!! $aktivitet->materialer ?? '' !!}</div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
$( document ).ready(function() {
    @if($aktivitet)
    $('#exampleModal').modal('show');
    @endif
    // $(document).on("click", ".aktivitet.closed", function(){
    //     $(this).removeClass('closed').addClass('open');
    //     $("<div id='placeholder'></div>").insertAfter($(this));
    //     $(window).scrollTop(0);
    //     window.history.replaceState(
    //       "aktivitet",
    //       "Aktivitet - " + $(this).data('slug'),
    //       "/aktiviteter/" + $(this).data('slug')
    //     );
    //     $("#modalShadow").show();
    // });
    $('#exampleModal').on('show.bs.modal', function (event) {
        var trigger = $(event.relatedTarget);
        var title = trigger.data('title');
        var type = trigger.data('type');
        var ikon = trigger.data('ikon');
        var image = trigger.data('image');
        var slug = trigger.data('slug');
        var materialer = trigger.data('materialer');
        var aktiviteter = trigger.data('aktiviteter');
        var modal = $(this);
        window.history.replaceState(
          "aktivitet",
          "Aktivitet - " + slug,
          "/aktiviteter/" + slug
        );
        modal.find('.modal-title').text(title);
        modal.removeClass('type-1 type-2 type-3').addClass(type);
        console.log(materialer);
        if(materialer){
            modal.find('.modal-body #materialer').show();
            modal.find('.modal-body #materialer-indhold').html(materialer);
        } else {
            modal.find('.modal-body #materialer').hide();
        }
        modal.find('.modal-body #aktiviteter-indhold').html(aktiviteter);
        modal.find(".modal-body .image-holder img").attr("src",image);
        modal.find(".modal-header .icon-badge i").removeClass();
        modal.find(".modal-header .icon-badge i").addClass(ikon);
    });
    $('#exampleModal').on('hide.bs.modal', function (event) {
        closeModal();
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
