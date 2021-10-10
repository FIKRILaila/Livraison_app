@extends('adminLte.dashboard')
@section('Distribution')
active
@endsection

@section('content')
<div class="m-4">
    @if (Session::get('success'))
    <div class="alert alert-success">
        {{ Session::get('success') }}
    </div>
    @endif
    @if (Session::get('fail'))
        <div class="alert alert-danger">{{ Session::get('fail') }}</div>
    @endif
    @if ($bon->livreur_id != NULL)
    <div class="card mt-4">
        <div class="card-header">
            <h4 class="font-weight-bold m-2">Liste des Colis a Distribuer</h4>
        </div>
        <div class="card-body">
            <table id="recu" class="display">
                <thead>
                    <tr>
                        <th>Code d'Envoie</th>
                        <th>Date de creation</th>
                        <th>Téléphone</th>
                        <th>Nom du Magasin</th>
                        <th>Etat</th>
                        <th>Status</th>
                        <th>Ville</th>
                        <th>Prix</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($Attente as $item) 
                        {{-- @if($item->etat == 'Ramasse') --}}
                            <tr>
                                <td>{{$item->code}}</td>
                                <td>{{$item->created_at}}</td>
                                <td>{{$item->telephone}}</td>
                                <td>{{$item->nomMagasin}}</td>
                                <td>
                                    @if ($item->paye == false)
                                        Non Payé
                                    @else
                                        Payé
                                    @endif
                                </td>
                                <td>{{$item->etat}}</td>
                                <td>{{$item->ville}}</td>
                                <td>{{$item->prix}} DH</td>
                            </tr>
                        {{-- @endif --}}
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
    <div class="card mt-4">
        <p class="m-2"><span class="font-weight-bold">Date de Création :</span> {{$bon->created_at}} </p>
    </div>
    <div class="card">
        <div class="m-4">
            @if ($bon->livreur_id == NULL)
                <form action="{{route('Distributeur')}}" method="post" class="row">
                    @csrf
                    <input type="hidden" name="bon_id" value="{{$bon->id}}">
                    <div class="row col-md-10">
                        <label for="livreur_id" class="text-right col-md-2 col-form-label">{{ __('Livreur: *') }}</label>
                        <select name="livreur_id" id="livreur_id" class="col-md-10 form-control @error('livreur_id') is-invalid @enderror" value="{{ old('livreur_id') }}" required  autofocus autocomplete="on">
                            <option value="">Livreur</option>
                            @foreach ($livreurs as $liv)     
                                <option value="{{$liv->id}}">{{$liv->nomComplet}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row justify-content-end col-md-2 ml-2">
                        <a href="#" class="btn btn-primary mr-2">Annuler</a>
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                    </div>
                </form>
            @else
                <form action="{{route('DistributionCode')}}" method="post" class="row">
                    @csrf
                    <input type="hidden" name="bon_id" value="{{$bon->id}}">
                    <div class="row col-md-10">
                        <label for="code_suivi" class="col-md-2 text-right col-form-label">Code Suivi * :</label>
                        <input type="text" name="code_suivi" class="form-control col-md-10">
                    </div>
                    <div class="row col-md-2 ml-2">
                        <button type="submit" class="btn btn-info">Ajouter</button>
                    </div>
                </form>
            @endif

        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h4 class="font-weight-bold m-2">Liste des Colis Ajouter</h4>
        </div>
        <div class="m-4">
            <table id="envoi" class="display">
                <thead>
                    <tr>
                        <th>Code Suivi</th>
                        <th>Destinataire</th>
                        <th>Date de Création</th>
                        <th>Prix</th>
                        <th>Ville</th>
                        <th>Status</th>
                        <th><input type="checkbox"></th>
                    </tr>
                </thead>
                <tbody>
                        @foreach ($colis as $coli)
                        {{-- @if ($coli->bon_id == $bon->id )  --}}
                            <tr>
                                <td>{{$coli->code}}</td>
                                <td>{{$coli->destinataire}}</td>
                                <td>{{$coli->created_at}}</td>
                                <td>{{$coli->prix}}</td>
                                <td>{{$coli->ville}}</td>
                                <td>{{$coli->etat}}</td>
                                <th><input type="checkbox"></th>
                            </tr>
                        {{-- @endif --}}
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
            $('#recu').DataTable();
        });
        $(document).ready( function () {
            $('#envoi').DataTable();
        });
    </script>
@endsection



   
    