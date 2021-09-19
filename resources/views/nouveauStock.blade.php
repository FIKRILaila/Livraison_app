@extends('adminLte.dashboard')
{{-- @extends('layouts.app') --}}
@section('stock')
active
@endsection
@section('nouveauStock')
active
@endsection
@section('content')
<div class="container">
    <h1 class=" m-4">Nouveau Stock</h1>
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
@endsection
