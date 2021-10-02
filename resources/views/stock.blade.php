@extends('adminLte.dashboard')
{{-- @extends('layouts.app') --}}
@section('stock')
active
@endsection
@section('style')
<style>
    #article_image {
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
    #articleImage {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>
@endsection
@section('content')
<div class="container">
      @if (Session::get('success'))
      <div class="alert alert-success">
          {{ Session::get('success') }}
      </div>
      @endif
      @if (Session::get('fail'))
          <div class="alert alert-danger">{{ Session::get('fail') }}</div>
      @endif
      <div class="d-flex justify-content-end mt-4">
        <button class="btn btn-primary mr-2" type="button" data-toggle="collapse" data-target="#article" aria-expanded="false" aria-controls="collapseExample">
          Nouveau Article <i class="fas fa-angle-down"></i>
        </button>
        <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#newstock" aria-expanded="false" aria-controls="collapseExample">
          Nouveau Stock <i class="fas fa-angle-down"></i>
        </button>
      </div>
    <div class="collapse mt-4" id="article">
      <div class="card card-body">
        <h4 class=" ml-4">Nouveau Article :</h4>
            <div class="m-4">
              <form action="{{route('storeArticle')}}" method="post" class="col-md-12" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="reference" class="mb-2 col-form-label">{{ __('Réference :') }}</label>
                        <div>
                            <input id="reference" type="text" class="form-control" name="reference" value="{{ old('reference') }}" required autocomplete="on">
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="name" class="mb-2 col-form-label">{{ __('Article :') }}</label>
                        <div>
                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autocomplete="on">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="type" class="col-form-label">{{ __('Type d\'Article :') }}</label>
                        <div>
                            <input id="type" type="text" class="form-control @error('type') is-invalid @enderror" name="type" value="{{ old('type') }}" required autocomplete="on">
                        </div>
                    </div>
                    <div class="form-group mb-4 col-md-6 row mt-4">
                        <label for="image" class="col-form-label mt-2 mr-4">{{ __('Choose an Image :') }}</label>
                        <div id="article_image" class="col-md-6 mt-4">
                            <img id="articleImage" src="{{asset('images/noImage.svg')}}" alt="l'image de l'article " >
                            <input id="image" type="file" class="col-md-12 h-100" onchange="addImage(this)" name="image" value="{{ old('image') }}" required autocomplete="image" autofocus >
                        </div>
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
    <div class="collapse mt-4" id="newstock">
      <div class="card card-body">
        <h1 class="ml-4">Nouveau Stock</h1>
            <div class="m-4">
                <form action="{{route('storeStock')}}" method="post" class="col-md-12">
                    @csrf
                    <div class="form-group">
                        <label for="article_id" class="mb-2 col-form-label">{{ __('Article') }}</label>
                        <div>
                            <select name="article_id" id="article_id" class="form-control @error('article_id') is-invalid @enderror" value="{{ old('article_id') }}" required  autofocus autocomplete="on">
                                <option value="">article</option>
                              @foreach ($articles as $art)     
                                    <option value="{{$art->id}}">{{$art->name}}</option>
                              @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="quantite" class="mb-2 col-form-label">{{ __('Quantité') }}</label>
                        <div>
                            <input id="quantite" type="number" min="1" class="form-control @error('quantite') is-invalid @enderror" name="quantite" value="{{ old('quantite') }}" required autocomplete="on">
                        </div>
                    </div>
                    <div class="form-group mt-4 mb-0 d-flex justify-content-end">
                        <div class="mr-2">
                            <a href="{{route('nouveauStock')}}" class="btn btn-secondary">{{ __('Annuler') }}</a>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary">{{ __('Enregistrer') }}</button>
                        </div>
                    </div>
                </form>
            </div>
      </div>
    </div>

    <h3 class="mt-4"><i class="mr-2 fas fa-angle-right"></i>Stock Actuel :</h3>
    <div class="col-md-12 mt-4 card">
        <div class="m-4">
        <table id="stock" class="display">
          <thead>
              <tr>
                  <th>Article</th>
                  <th>Image</th>
                  <th>Type d'Article</th>
                  <th>Quantité</th>
              </tr>
          </thead>
          <tbody>
            @foreach ($stock as $s)   
              <tr>
                <td  class="col-md-2"><img src="/images/{{$s->image}}" alt="image"  class="col-md-10"></td>
                <td>{{$s->name}}</td>
                <td>{{$s->type}}</td>
                <td>{{$s->quantite}}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      </div>
</div>
@endsection
@section('script')
    <script>
        $(document).ready( function () {
          $('#stock').DataTable();
        });

        function addImage(input){
        var file=$("input[type=file]").get(0).files[0];
        if(file){
          var reader = new FileReader();
          reader.onload = function(){
            $('#articleImage').attr("src",reader.result);
            $('#image').attr("value",reader.result);
          }
          reader.readAsDataURL(file);
        }
    }
    </script>
@endsection





    
