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

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Kredsens motivation</label>
                            <textarea class="form-control" name="motivation" rows="5">{{ $kreds->motivation }}</textarea>
                        </div>

                        <div class="form-group">
                            <div class="field" align="left">
                                <h3>Billeder</h3>
                                <input type="file" id="files" multiple />
                                @if($kreds->billeder)
                                @foreach(array_reverse($kreds->billeder) AS $billede)
                                <span class="pip">
                                    <img class="img-thumbnail" src="/storage/photos/{{ $billede }}"/>
                                    <span class="remove-saved remove" data-path="{{ $billede }}">
                                        <i class="fas fa-times"></i>
                                    </span>
                                </span>
                                @endforeach
                                <input type="hidden" name="removePhotos" id="remove-photos" value="[]">
                                @endif
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <h4>Aktiviteter i har lavet</h4>
                        </div>
                        <div class="form-group">
                            <div class="btn-group-toggle d-flex" id="aktiviteter-select" data-toggle="buttons">
                                @foreach($aktiviteter AS $aktivitet)
                                <label class="btn btn-round d-flex type-{{ $aktivitet->type }} aktivitet">
                                    <input type="checkbox" value="{{ $aktivitet->id }}" name="aktiviteter[]" autocomplete="off" {{ $kreds->aktiviteter->contains('id', $aktivitet->id) ? 'checked' : '' }}>
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

                        <div class="form-group mt-4">
                            <h4>Kontaktperson</h4>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Navn</label>
                            <input type="text" class="form-control" name="kontakt_navn" value="{{ $kreds->kontakt_navn }}">
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlInput1">Email</label>
                            <input type="email" class="form-control" name="kontakt_email" value="{{ $kreds->kontakt_email }}">
                        </div>

                        <div class="form-group pt-4">
                            <input type="submit" class="btn-block btn btn-success" value="Gem">
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
    $(document).ready(function() {
  if (window.File && window.FileList && window.FileReader) {
    $("#files").on("change", function(e) {
      var files = e.target.files,
        filesLength = files.length;
      for (var i = 0; i < filesLength; i++) {
        var f = files[i]
        var fileReader = new FileReader();
        fileReader.onload = (function(e) {
          var file = e.target;
          $("<span class=\"pip\">" +
            "<img class=\"img-thumbnail\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
            "<span class=\"remove\"><i class='fas fa-times'></i></span>" +
            "<input type='hidden' name='photos[]' value='" + e.target.result + "'>" +
            "</span>").insertAfter("#files");
          $(".remove").click(function(){
            $(this).parent(".pip").remove();
            files(e.target.files.splice(i,1));
          });
        });
        fileReader.readAsDataURL(f);
      }
      $("#files").val('');
    });
  } else {
    alert("Your browser doesn't support to File API")
  }

          $(".remove-saved").click(function(){
            $(this).parent(".pip").remove();
            var removes = JSON.parse($('#remove-photos').val());
            console.log(removes);
            removes.push($(this).data('path'));
            console.log(removes);
            $('#remove-photos').val(JSON.stringify(removes));
          });
});
</script>
@endsection
