@extends('layouts.app')

@section('content')
<div class="container pt-4">
    <div class="row mt-4">
        <div class="col-12">
            <h1 class="title">Ret kreds</h1>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-8 offset-md-2 col-xl-6 offset-xl-3">
            <form action="{{ route('kreds.update', $kreds->key) }}" method="post" id="form" enctype="multipart/form-data">
            @csrf
            @method('put')
                <div class="card">
                    <div class="card-header">
                        <h2>{{ $kreds->navn }}</h2>
                    </div>
                    <div class="card-body">

                        <div class="mb-3">
                            <label for="motivation" class="form-label">Kredsens motivation</label>
                            <textarea class="form-control" id="motivation" name="motivation" rows="5">{{ $kreds->motivation }}</textarea>
                        </div>

                        <div class="mb-3">
                            <div class="field" align="left">
                                <h3>Billeder</h3>
                                <input type="file" id="files" accept="image/*" multiple />
                                @if($kreds->billeder)
                                @foreach(array_reverse($kreds->billeder) AS $billede)
                                <span class="pip">
                                    <img class="img-thumbnail" src="/storage/photos/{{ $billede }}"/>
                                    <span class="remove-saved remove" role="button" aria-label="Fjern billede" data-path="{{ $billede }}">
                                        <i class="fas fa-times"></i>
                                    </span>
                                </span>
                                @endforeach
                                <input type="hidden" name="removePhotos" id="remove-photos" value="[]">
                                @endif
                            </div>
                        </div>

                        <div class="mb-3 mt-4">
                            <h4>Aktiviteter i har lavet</h4>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex" id="aktiviteter-select">
                                @foreach($aktiviteter AS $aktivitet)
                                <input type="checkbox" class="btn-check" id="aktivitet-{{ $aktivitet->id }}" value="{{ $aktivitet->id }}" name="aktiviteter[]" autocomplete="off" @checked($kreds->aktiviteter->contains('id', $aktivitet->id))>
                                <label class="btn btn-round d-flex type-{{ $aktivitet->type }} aktivitet" for="aktivitet-{{ $aktivitet->id }}">
                                    <div class="icon-badge rounded-circle">
                                        <i class="{{ $aktivitet->ikon }}"></i>
                                    </div>
                                    <div class="titel">
                                        {{ $aktivitet->title }}
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="mb-3 mt-4">
                            <h4>Kontaktperson</h4>
                        </div>
                        <div class="mb-3">
                            <label for="kontakt_navn" class="form-label">Navn</label>
                            <input type="text" class="form-control" id="kontakt_navn" name="kontakt_navn" value="{{ $kreds->kontakt_navn }}">
                        </div>

                        <div class="mb-3">
                            <label for="kontakt_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="kontakt_email" name="kontakt_email" value="{{ $kreds->kontakt_email }}">
                        </div>

                        <div class="mb-3 pt-4">
                            <input type="submit" class="w-100 btn btn-success" value="Gem">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var input = document.getElementById('files');

    input.addEventListener('change', function () {
        Array.from(input.files).forEach(function (file) {
            var reader = new FileReader();
            reader.onload = function () {
                var pip = document.createElement('span');
                pip.className = 'pip';

                var img = document.createElement('img');
                img.className = 'img-thumbnail';
                img.src = reader.result;
                img.title = file.name;

                var remove = document.createElement('span');
                remove.className = 'remove';
                remove.setAttribute('role', 'button');
                remove.setAttribute('aria-label', 'Fjern billede');
                remove.innerHTML = '<i class="fas fa-times"></i>';
                remove.addEventListener('click', function () {
                    pip.remove();
                });

                var hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = 'photos[]';
                hidden.value = reader.result;

                pip.append(img, remove, hidden);
                input.after(pip);
            };
            reader.readAsDataURL(file);
        });
        input.value = '';
    });

    document.querySelectorAll('.remove-saved').forEach(function (button) {
        button.addEventListener('click', function () {
            var field = document.getElementById('remove-photos');
            var removes = JSON.parse(field.value);
            removes.push(button.dataset.path);
            field.value = JSON.stringify(removes);
            button.closest('.pip').remove();
        });
    });
});
</script>
@endsection
