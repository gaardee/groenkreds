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
            data-bs-toggle="modal"
            data-bs-target="#exampleModal"
            data-type="type-{{ $a->type }}"
            data-slug="{{ $a->slug }}"
            data-title="{{ $a->title }}"
            data-aktiviteter="{{ $a->indhold }}"
            data-ikon="{{ $a->ikon }}"
            data-image="{{ $a->path != '' ? url('storage/' . $a->path) : url('images/aktivitet_placeholder.png') }}"
            data-materialer="{{ $a->materialer }}"
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
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Luk"></button>
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
document.addEventListener('DOMContentLoaded', function () {
    var modalEl = document.getElementById('exampleModal');
    var modal = bootstrap.Modal.getOrCreateInstance(modalEl);

    modalEl.addEventListener('show.bs.modal', function (event) {
        var trigger = event.relatedTarget;
        if (!trigger) {
            return; // Opened on page load with server-rendered content.
        }
        var data = trigger.dataset;

        window.history.replaceState('aktivitet', 'Aktivitet - ' + data.slug, '/aktiviteter/' + data.slug);

        modalEl.querySelector('.modal-title').textContent = data.title;
        modalEl.classList.remove('type-1', 'type-2', 'type-3');
        modalEl.classList.add(data.type);

        var materialer = modalEl.querySelector('#materialer');
        if (data.materialer) {
            materialer.style.display = 'block';
            modalEl.querySelector('#materialer-indhold').innerHTML = data.materialer;
        } else {
            materialer.style.display = 'none';
        }
        modalEl.querySelector('#aktiviteter-indhold').innerHTML = data.aktiviteter;
        modalEl.querySelector('.modal-body .image-holder img').src = data.image;
        modalEl.querySelector('.modal-header .icon-badge i').className = data.ikon;
    });

    modalEl.addEventListener('hide.bs.modal', function () {
        window.history.replaceState('aktiviteter', 'Aktiviteter', '/aktiviteter');
    });

    @if($aktivitet)
    modal.show();
    @endif
});
</script>
@endsection
