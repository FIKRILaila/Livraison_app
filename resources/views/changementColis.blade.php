@extends('adminLte.dashboard')
@section('ChangementColis')
    active
@endsection
@section('demandes')
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

    @if (Auth::user()->role == 'client')
    <div>
        <p class="row justify-content-end">
        <button class="btn btn-info mt-4 mr-2" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
            Nouvelle Demande
        </button>
        </p>
        <div class="collapse" id="collapseExample">
        <div class="card">
            <div class="m-4">
                <form action="{{route('newDemande')}}" method="post" class="row ml-4">
                    @csrf
                    <input type="hidden" name="type" value="ChangementColis">
                    <div class="row col-md-10">
                        <label for="message" class="text-right col-md-2 control-label obligatoire"> Code de Colis a changer : </label>
                        <input type="text" name="message" id="message" class="form-control col-md-10">
                    </div>
                    <div class="row col-md-2 ml-2">
                        <button type="submit" class="btn btn-info">Envoyer</button>
                    </div>
                </form>        
            </div>
        </div>
        </div>
    </div>
    <div class="card mt-4">
        <div class="card-header">
            <h4 class="font-weight-bold m-2 text-info">Liste des colis en retour que vous pouvez changer pour un autre client :</h4>
        </div>
        <div class="card-body">
            <table id="retourner" class="display">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Date de creation</th>
                        <th>Destinataire</th>
                        <th>Téléphone</th>
                        <th>Etat</th>
                        <th>Status</th>
                        <th>Ville</th>
                        <th>Prix</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($colis as $col)
                    <tr>
                        <td>{{$col->code}}</td>
                        <td>{{$col->created_at}}</td>
                        <td>{{$col->destinataire}}</td>
                        <td>{{$col->telephone}}</td>
                        <td>
                            @if ($col->paye == false)
                                Non Payé
                            @else
                                Payé
                            @endif
                        </td>
                        <td>{{$col->etat}}</td>
                        <td>{{$col->ville}}</td>
                        <td>{{$col->prix}}</td>
                        <td>
                            @if ($col->change)
                            <button type="button" class="btn btn-light" data-toggle="modal" data-target="{{'#edit_'.$col->id}}"><i class="fas fa-edit"></i></button>
                            <div class="modal fade" id="{{'edit_'.$col->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="m-4">
                                            <h5 class="font-weight-bold">Changement de colis <span class="text-info"> {{$col->code}} </span> par :</h5><br>
                                            <form method="POST" action="{{route('ChangerColis')}}">
                                                @csrf
                                                <input type="hidden" name="colis_id" value="{{$col->id}}">
                                                <div class="row">
                                                    <div class="form-group row col-md-12">
                                                        <label for="code" class="col-md-2 col-form-label">{{ __('Nouveau Code') }}</label>
                                                        <div class="col-md-10">
                                                            <input id="code" type="text" class="form-control" name="code" value="" autocomplete="on">
                                                        </div>
                                                    </div>
                                                    {{-- <div class="form-group col-md-6 row">
                                                        <input type="hidden" name="ville_id" id="ville_id" value="{{$col->ville_id}}">
                                                        <label for="ville" class="col-md-4 col-form-label">{{ __('Ville') }}</label>
                                                        <div class="col-md-8">
                                                            <select onchange="Tarif(value)" name="ville" id="ville" class="form-control" value="{{ old('ville') }}" required  autofocus autocomplete="on">
                                                                <option value="{{$col->ville_id}}_{{$col->frais_livraison}}">{{$col->ville}}</option>
                                                                @foreach ($villes as $ville)
                                                                    <option value="{{$ville->id}}_{{$ville->frais_livraison}}">{{$ville->ville}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div> --}}
                                                </div>
                                                <div class="row">
                                                    <div class="form-group row col-md-6">
                                                        <label for="destinataire" class="col-md-4 col-form-label">{{ __('Destinataire') }}</label>
                                                        <div class="col-md-8">
                                                            <input id="destinataire" type="text" class="form-control" name="destinataire" value="{{$col->destinataire}}" required autocomplete="on">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row col-md-6">
                                                        <label for="telephone" class="col-md-4 col-form-label">{{ __('Téléphone') }}</label>
                                                        <div class="col-md-8">
                                                            <input id="telephone" type="tel" class="form-control" name="telephone" value="{{$col->telephone}}" required autocomplete="on">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-6 row">
                                                        <label for="prix" class="col-md-4 col-form-label">{{ __('Prix') }}</label>
                                                        <div class="col-md-8">
                                                            <input id="prix" type="number" min="1" class="form-control" name="prix" value="{{$col->prix}}" required autocomplete="on">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row col-md-6">
                                                        <label for="quartier" class="col-md-4 col-form-label">{{ __('Quartier') }}</label>
                                                        <div class="col-md-8">
                                                            <input id="quartier" type="text" class="form-control" name="quartier" value="{{$col->quartier}}" required autocomplete="on">
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- <div class="row">
                                                    <div class="col-md-8 row">
                                                        <div class="form-group row col-md-6">
                                                            <label for="fragile" class="col-md-4 mr-2 col-form-label">{{ __('Fragile :') }}</label>
                                                            <div class="col-md-8 row">
                                                                <div class="mr-2">
                                                                    <input type="radio" id="oui" name="fragile" value="oui" @if($col->fragile == true) checked @endif>
                                                                    <label for="oui">oui</label>
                                                                </div>
                                                                <div>
                                                                    <input type="radio" id="non" name="fragile" value="non"  @if($col->fragile == false) checked @endif>
                                                                    <label for="non">non</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row col-md-6">
                                                            <label for="remplacer" class="mr-2 col-md-6 col-form-label">{{ __('Remplacer :') }}</label>
                                                            <div class="row col-md-6">
                                                                <div class="mr-2">
                                                                    <input type="radio" id="Aremplacer" name="remplacer" value="oui" @if($col->remplacer == true) checked @endif>
                                                                    <label for="Aremplacer">oui</label>
                                                                </div>
                                                                <div>
                                                                    <input type="radio" id="remplacePas" name="remplacer" value="non" @if($col->remplacer == true) checked @endif>
                                                                    <label for="remplacePas">non</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group row">
                                                            <div>
                                                                <input type="checkbox" id="ouvrir" name="ouvrir" value="oui" @if($col->ouvrir) checked @endif>
                                                                <label for="ouvrir">Ne pas Ouvrir le colis?</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> --}}

                                                <div class="row">
                                                    <div class="form-group col-md-12 row">
                                                        <label for="adresse" class="col-md-2 col-form-label">{{ __('Adresse') }}</label>
                                                        <div class="col-md-10">
                                                            <textarea id="adresse" name="adresse" class="form-control" required autocomplete="on" autofocus>{{$col->adresse}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-md-12 row">
                                                        <label for="commentaire" class="col-md-2 col-form-label">{{ __('Commentaire') }}</label>
                                                        <div class="col-md-10">
                                                            <textarea id="commentaire" name="commentaire" class="form-control" autocomplete="on" autofocus>{{$col->commentaire}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row justify-content-end col-md-12">
                                                    <label class="col-form-label">{{ __('Tarif de Livraison :') }}
                                                        <span class="" id="tarif">{{$col->frais_livraison}}</span> DH
                                                    </label>
                                                </div>
                                                <div class="form-group row justify-content-end col-md-12">
                                                    <div>
                                                        <button type="submit" class="btn btn-info">{{ __('Enregistrer') }}</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <div class="card mt-4">
        <div class="card-header">
            <h4 class="font-weight-bold m-2 text-info">Liste des demandes de changement de colis</h4>
        </div>
        <div class="card-body">
            <table id="demandes" class="display">
                <thead>
                    <tr>
                        @if (Auth::user()->role == 'admin')
                        <th>Colis a changer</th>
                        <th>Par</th>
                        <th>Date</th>
                        <th>Actions</th>
                        @endif
                        @if (Auth::user()->role == 'client')
                        <th>Colis a changer</th>
                        <th>Date</th>
                        <th>Etat</th>
                        {{-- <th>Actions</th> --}}
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($demandes as $demande) 
                    <tr>
                        @if (Auth::user()->role == 'admin')
                        <td>{{$demande->message}}</td>
                        <td>{{ $demande->nomComplet }}</td>
                        <td>{{$demande->created_at}}</td>
                        <td class="d-flex">
                            @if ($demande->traiter)
                                <p class="text-info font-weight-bold">Traité</p>
                            @else
                                <form action="{{route('TraiterDemande')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="demande_id" value="{{$demande->id}}">
                                    <button type="submit" class="btn btn-success"><i class="fas fa-check"></i></button>
                                </form>
                            @endif
                        </td>
                        @endif

                        @if (Auth::user()->role == 'client')
                        <td>{{$demande->message}}</td>
                        <td>{{$demande->created_at}}</td>
                        <td>
                            @if ($demande->traiter)
                                <p class="text-success font-weight-bold">Traité</p>
                            @else
                                <p class="text-danger font-weight-bold">En cours de traitement</p>
                            @endif
                        </td>
                        @endif
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
        $('#retourner').DataTable();
    });
    function Tarif(value){
        let id = value.split('_')[0];
        let frais = value.split('_')[1];
        let tarif = document.querySelector("#tarif")
        document.querySelector("#ville_id").value = id
        tarif.innerHTML=`${frais}`;          
    }
    $(document).ready( function () {
        $('#demandes').DataTable();
    });
</script>
@endsection