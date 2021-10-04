@extends('adminLte.dashboard')
{{-- @extends('layouts.app') --}}
@section('stock')
active
@endsection
@section('article')
active
@endsection
@section('style')
<style>
    #Pimage {
        border: 2px dashed gray;
        border-radius: 15px;
        background-size: cover;
        overflow: hidden;
    }
    #image {
        opacity: 0;
        object-fit: cover;
        border-radius: 15px;
        background-color: transparent;
        background-position: center center;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    #platImage {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>
@endsection
@section('content')
<div class="m-4">
    <h1 class=" m-4">Nouveau Article</h1>
    @if (Session::get('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
            @endif
            @if (Session::get('fail'))
                <div class="alert alert-danger">{{ Session::get('fail') }}</div>
            @endif
    <div class="card">
        <div class="m-4">
            <form action="{{route('storeArticle')}}" method="post" class="col-md-12" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="reference" class="mb-2 col-form-label">{{ __('Réference') }}</label>
                    <div>
                        <input id="reference" type="text" class="form-control @error('reference') is-invalid @enderror" name="reference" value="{{ old('reference') }}" required autocomplete="on">
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="mb-2 col-form-label">{{ __('Article') }}</label>
                    <div>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="on">
                    </div>
                </div>
                <div class="form-group">
                    <label for="type" class="mb-2 col-form-label">{{ __('Type d\'Article') }}</label>
                    <div>
                        <input id="type" type="text" class="form-control @error('type') is-invalid @enderror" name="type" value="{{ old('type') }}" required autocomplete="on">
                    </div>
                </div>
                <div class="form-group mb-4 col-md-4">
                    <label for="image" class="col-form-label text-md-right">{{ __('Choose an Image :') }}</label>
                    <div id="Pimage">
                        <img id="platImage" src="{{asset('images/noImage.svg')}}" alt="l'image de l'article " >
                        <input id="image" type="file" class="col-md-12 h-100" onchange="addImage(this)" name="image"  placeholder="type here..." value="{{ old('image') }}" required autocomplete="image" autofocus >
                    </div>
                </div>
                <div class="form-group mt-4 mb-0 d-flex justify-content-end">
                    <div class="mr-2">
                        <a href="{{route('article')}}" class="btn btn-secondary">{{ __('Annuler') }}</a>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary">{{ __('Enregistrer') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    function addImage(input){
        var file=$("input[type=file]").get(0).files[0];
        if(file){
          var reader = new FileReader();
          reader.onload = function(){
            $('#platImage').attr("src",reader.result);
            $('#image').attr("value",reader.result);
          }
          reader.readAsDataURL(file);
        }
    }
</script>
@endsection

