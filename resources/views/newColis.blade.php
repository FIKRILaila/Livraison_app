@extends('adminLte.dashboard')
@section('colis')
active
@endsection
@section('nouveauColis')
active
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h1 class="text-center m-4">Nouveau Colis</h1>
            @if (Session::get('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
            @endif
            @if (Session::get('fail'))
                <div class="alert alert-danger">{{ Session::get('fail') }}</div>
            @endif
            
            <div class="card mt-4">
                <div class="card-body">
                    <form method="POST" action="{{route('storeColis')}}">
                        @csrf
                        <input type="hidden" name="ville_id" id="ville_id" value="">
                        <div class="row">
                            <div class="form-group col-md-6 row">
                                <label for="ville" class="col-md-4 col-form-label">{{ __('Ville') }}</label>
                                <div class="col-md-8">
                                    <select onchange="Tarif(value)" name="ville" id="ville" class="form-control @error('ville') is-invalid @enderror" value="{{ old('ville') }}" required  autofocus autocomplete="on">
                                        <option value="">Ville</option>
                                        @foreach ($villes as $ville)
                                            <option value="{{$ville->id}}_{{$ville->frais_livraison}}">{{$ville->ville}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-6 row">
                                <label class="col-md-4 col-form-label">{{ __('Tarif') }}</label>
                                <div class="col-md-8">
                                    <span class="form-control" id="tarif">Tarif</span> 
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group row col-md-6">
                                <label for="destinataire" class="col-md-4 col-form-label">{{ __('Destinataire') }}</label>
                                <div class="col-md-8">
                                    <input id="destinataire" type="text" class="form-control @error('destinataire') is-invalid @enderror" name="destinataire" value="{{ old('destinataire') }}" required autocomplete="on">
                                </div>
                            </div>
                            <div class="form-group row col-md-6">
                                <label for="telephone" class="col-md-4 col-form-label">{{ __('Téléphone') }}</label>
                                <div class="col-md-8">
                                    <input id="telephone" type="tel" class="form-control @error('telephone') is-invalid @enderror" name="telephone" value="{{ old('telephone') }}" required autocomplete="on">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6 row">
                                <label for="prix" class="col-md-4 col-form-label">{{ __('Prix') }}</label>
                                <div class="col-md-8">
                                    <input id="prix" type="number" min="1" class="form-control @error('prix') is-invalid @enderror" name="prix" value="{{ old('prix') }}" required autocomplete="on">
                                </div>
                            </div>
                            <div class="form-group row col-md-6">
                                <label for="quartier" class="col-md-4 col-form-label">{{ __('Quartier') }}</label>
                                <div class="col-md-8">
                                    <input id="quartier" type="text" class="form-control @error('quartier') is-invalid @enderror" name="quartier" value="{{ old('quartier') }}" required autocomplete="on">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group row col-md-6">
                                <label for="code" class="col-md-4 col-form-label">{{ __('Code') }}</label>
                                <div class="col-md-8">
                                    <input id="code" type="text" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ old('code') }}" autocomplete="on">
                                </div>
                            </div>
                            <div class="form-group col-md-6 row">
                                <label for="adresse" class="col-md-4 col-form-label">{{ __('Adresse') }}</label>
                                <div class="col-md-8">
                                    <textarea id="adresse" name="adresse" class="form-control @error('adresse') is-invalid @enderror" required autocomplete="on" autofocus>{{ old('adresse') }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6 row">
                                <label for="fragile" class="col-md-4 col-form-label">{{ __('Fragile') }}</label>
                                <div class="col-md-8 row">
                                    <div class="mr-4">
                                        <input type="radio" id="oui" name="fragile" value="oui" checked>
                                        <label for="oui">oui</label>
                                    </div>
                                    <div>
                                        <input type="radio" id="non" name="fragile" value="non">
                                        <label for="non">non</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6 row">
                                <div class="col-md-12">
                                    <input type="checkbox" id="ouvrir" name="ouvrir">
                                    <label for="ouvrir">Ne pas Ouvrir le colis?</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12 row">
                                <label for="commentaire" class="col-md-2 col-form-label">{{ __('Commentaire') }}</label>
                                <div class="col-md-10">
                                    <textarea id="commentaire" name="commentaire" class="form-control @error('commentaire') is-invalid @enderror" autocomplete="on" autofocus>{{ old('commentaire') }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mb-0 offset-md-10">
                            <div class="mr-2">
                                <a href="{{route('home')}}" class="btn btn-danger">{{ __('Annuler') }}</a>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-success">{{ __('Enregistrer') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script>
        function Tarif(value){
            let id = value.split('_')[0];
            let frais = value.split('_')[1];
            let tarif = document.querySelector("#tarif")
            document.querySelector("#ville_id").value = id
            tarif.innerHTML=`${frais}`;           
        }
    </script>
@endsection