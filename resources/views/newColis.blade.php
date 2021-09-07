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
            <div class="card mt-4">
                <div class="card-body">
                    <form method="POST" action="{{route('storeColis')}}">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6 row">
                                <label for="ville_id" class="col-md-4 col-form-label">{{ __('Ville') }}</label>
                                <div class="col-md-8">
                                    <select name="ville_id" id="ville_id" class="form-control @error('ville_id') is-invalid @enderror" value="{{ old('ville_id') }}" required  autofocus autocomplete="on">
                                        <option value="">Ville</option>
                                        @foreach ($villes as $villes)
                                            <option value="{{$villes->id}}">{{$villes->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-6 row">
                                <label class="col-md-4 col-form-label">{{ __('Tarif') }}</label>
                                <div class="col-md-8">
                                    <span class="form-control">Tarif</span> 
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
                                <label for="phone" class="col-md-4 col-form-label">{{ __('Téléphone') }}</label>
                                <div class="col-md-8">
                                    <input id="phone" type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="on">
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
                            <div class="form-group col-md-12 row">
                                <label for="adresse" class="col-md-2 col-form-label">{{ __('Adresse') }}</label>
                                <div class="col-md-10">
                                    <textarea id="adresse" name="adresse" class="form-control @error('adresse') is-invalid @enderror" required autocomplete="on" autofocus>{{ old('adresse') }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6 row">
                                <label for="fragile" class="col-md-4 col-form-label">{{ __('Fragile') }}</label>
                                <div class="col-md-8 row">
                                    <div class="mr-4">
                                        <input type="radio" id="oui" name="fragile" value="1" checked>
                                        <label for="oui">oui</label>
                                    </div>
                                    <div>
                                        <input type="radio" id="non" name="fragile" value="0">
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
                                    <textarea id="commentaire" name="commentaire" class="form-control @error('commentaire') is-invalid @enderror"  required autocomplete="on" autofocus>{{ old('commentaire') }}</textarea>
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
