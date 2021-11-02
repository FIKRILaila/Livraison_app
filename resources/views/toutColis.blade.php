@extends('adminLte.dashboard')
{{-- @extends('layouts.app') --}}
@section('toutColis')
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
    <div class="card">
        <form action="{{route('Filtrer')}}" method="post" class="m-4">
            @csrf
            <div class="row">
                <div class="col-md-2 m-2"><input type="text" name="code" id="code" placeholder="Code Suivi" class="form-control"></div>
                <div class="col-md-2 m-2">
                    <select name="etat" id="etat" class="form-control">
                        <option value="">Status</option>
                        <option value="">Nouveau Colis</option>
                        <option value="">En Attente de Rammassage</option>
                        <option value="">Ramasse</option>
                        <option value="">Reçu</option>
                        <option value="">En Distribution</option>
                        <option value="">Livré</option>
                        <option value="">Annulé</option>
                        <option value="">Refusé</option>
                        <option value="">Reporté</option>
                        <option value="">Retourné</option>
                        <option value="">Reçu Par Agence</option>
                        <option value="">Retourné au Client</option>
                        <option value="">Reçu Par Client</option>
                        <option value="">Pas de Réponse</option>
                        <option value="">Erreur Numéro</option>
                        <option value="">Numéro Injoignable</option>
                    </select>
                </div>
                <div class="col-md-2 m-2">
                    <select name="paye" id="paye" class="form-control">
                        <option value="">Etat</option>
                        <option value="">Payé</option>
                        <option value="">Non Payé</option>
                    </select>
                </div>
                <div class="col-md-2 m-2">
                    <select name="ville_id" id="ville_id" class="form-control">
                        <option value="">Ville</option>
                        @foreach ($villes as $ville)
                            <option value="">{{$ville->ville}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 m-2">
                    <select name="region_id" id="region_id" class="form-control">
                        <option value="">Région</option>
                        @foreach ($regions as $region)
                            <option value="">{{$region->region}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 m-2">
                    <select name="region_id" id="region_id" class="form-control">
                        <option value="">Livreur</option>
                        @foreach ($livreurs as $livreur)
                            <option value="">{{$livreur->nomComplet}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 m-2">
                    <select name="region_id" id="region_id" class="form-control">
                        <option value="">Magasin</option>
                        @foreach ($clients as $client)
                            <option value="">{{$client->nomMagasin}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 m-2">
                    <input type="date" name="created_at" id="created_at" class="form-control">
                </div>
            </div>
            <div class="row justify-content-end">
                <button type="submit" class="btn btn-info">Filtrer</button>
            </div>
        </form>
    </div>
    
    <div class="mt-4 card col-md-12">
        <div class="m-4">
            <table id="tousColis" class="display">
                <thead>
                    <tr>
                        <th>Code Suivi</th>
                        <th>Date de creation</th>
                        <th>Téléphone</th>
                        <th>Nom du Magasin</th>
                        <th>Etat</th>
                        <th>Status</th>
                        <th>Ville</th>
                        <th>Prix</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($colis as $item) 
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
                        <td class="d-flex">
                            <button type="button" class="btn btn-light" data-toggle="modal" data-target="{{'#edit_'.$item->id}}"><i class="fas fa-edit"></i></button>
                            <button type="button" class="btn btn-light" data-toggle="modal" data-target="{{'#model_'.$item->id}}"><i class="fas fa-info-circle"></i></button>
                            <div class="modal fade" id="{{'model_'.$item->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="m-4">
                                        <table id="historiques" class="display">
                                            <thead>
                                                <tr>
                                                    <th>Code Suivi</th>
                                                    <th>Etat</th>
                                                    <th>Status</th>
                                                    <th>Date</th>
                                                    <th>Action par</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($historique as $histo) 
                                                @if($histo->colis_id == $item->id) 
                                                <tr>
                                                    <td>{{$item->code}}</td>
                                                    <td>
                                                        @if ($item->paye == false)
                                                            Non Payé
                                                        @else
                                                            Payé
                                                        @endif
                                                    </td>
                                                    <td>{{$histo->etat_h}}</td>
                                                    <td>{{$histo->created_at}}</td>
                                                    <td>{{$histo->nomComplet}} </td>
                                                </tr>
                                                @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div class="modal fade" id="{{'edit_'.$item->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="m-4">
                                        <form method="POST" action="{{route('editColis')}}">
                                            @csrf
                                            <input type="hidden" name="colis_id" value="{{$item->id}}">
                                            <div class="row">
                                                <div class="form-group col-md-12 row">
                                                    <label for="etat" class="col-md-2 col-form-label">{{ __('Status') }}</label>
                                                    <div class="col-md-10">
                                                        <select name="etat" id="etat" class="form-control" value="{{ old('etat') }}" required  autofocus autocomplete="on">
                                                            <option value="{{$item->etat}}">{{$item->etat}}</option>
                                                            <option value="Nouveau Colis">Nouveau Colis</option>
                                                            <option value="En Attente de Rammassage">En Attente de Rammassage</option>
                                                            <option value="Ramasse">Ramasse</option>
                                                            <option value="Expedié">Expedié</option>
                                                            <option value="Reçu">Reçu</option>
                                                            <option value="En Distribution">En Distribution</option>
                                                            <option value="Livré">Livré</option>
                                                            <option value="annulé">annulé</option>
                                                            <option value="Refusé">Refusé</option>
                                                            <option value="Reporté">Reporté</option>
                                                            <option value="Retourné">Retourné</option>
                                                            <option value="Reçu Par Client">Reçu Par Client</option>
                                                            <option value="Pas de Réponse">Pas de Réponse</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-12 " id="reporte" style="display:none;">
                                                <label for="reported_at" class="col-md-2 col-form-label">{{ __('Reporté à : ') }}</label>
                                                <div class="col-md-10">
                                                    <input type="date" name="reported_at" id="reported_at" class="form-control" value="{{ old('reported_at') }}" autofocus autocomplete="on">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6 row">
                                                    <label for="ville" class="col-md-4 col-form-label">{{ __('Ville') }}</label>
                                                    <div class="col-md-8">
                                                        <select onchange="Tarif(value)" name="ville" id="ville" class="form-control" value="{{ old('ville') }}" required  autofocus autocomplete="on">
                                                            <option value="{{$item->ville_id}}_{{$item->frais_livraison}}">{{$item->ville}}</option>
                                                            @foreach ($villes as $ville)
                                                                <option value="{{$ville->id}}_{{$ville->frais_livraison}}">{{$ville->ville}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 row">
                                                    <label class="col-md-4 col-form-label">{{ __('Tarif') }}</label>
                                                    <div class="col-md-8">
                                                        <span class="form-control" id="tarif">{{$item->frais_livraison}}</span> 
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group row col-md-6">
                                                    <label for="destinataire" class="col-md-4 col-form-label">{{ __('Destinataire') }}</label>
                                                    <div class="col-md-8">
                                                        <input id="destinataire" type="text" class="form-control" name="destinataire" value="{{$item->destinataire}}" required autocomplete="on">
                                                    </div>
                                                </div>
                                                <div class="form-group row col-md-6">
                                                    <label for="telephone" class="col-md-4 col-form-label">{{ __('Téléphone') }}</label>
                                                    <div class="col-md-8">
                                                        <input id="telephone" type="tel" class="form-control" name="telephone" value="{{$item->telephone}}" required autocomplete="on">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6 row">
                                                    <label for="prix" class="col-md-4 col-form-label">{{ __('Prix') }}</label>
                                                    <div class="col-md-8">
                                                        <input id="prix" type="number" min="1" class="form-control" name="prix" value="{{$item->prix}}" required autocomplete="on">
                                                    </div>
                                                </div>
                                                <div class="form-group row col-md-6">
                                                    <label for="quartier" class="col-md-4 col-form-label">{{ __('Quartier') }}</label>
                                                    <div class="col-md-8">
                                                        <input id="quartier" type="text" class="form-control" name="quartier" value="{{$item->quartier}}" required autocomplete="on">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group row col-md-6">
                                                    <label for="code" class="col-md-4 col-form-label">{{ __('Code') }}</label>
                                                    <div class="col-md-8">
                                                        <input id="code" type="text" class="form-control" name="code" value="{{$item->code}}" required autocomplete="on">
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 row">
                                                    <label for="adresse" class="col-md-4 col-form-label">{{ __('Adresse') }}</label>
                                                    <div class="col-md-8">
                                                        <textarea id="adresse" name="adresse" class="form-control" required autocomplete="on" autofocus>{{$item->adresse}}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-6 row">
                                                    <label for="fragile" class="col-md-4 col-form-label">{{ __('Fragile (5DH)') }}</label>
                                                    <div class="col-md-8 row">
                                                        <div class="mr-4">
                                                            <input type="radio" id="oui" name="fragile" value="oui" @if($item->fragile == true) checked @endif>
                                                            <label for="oui">oui</label>
                                                        </div>
                                                        <div>
                                                            <input type="radio" id="non" name="fragile" value="non" @if($item->fragile == false) checked @endif>
                                                            <label for="non">non</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6 row">
                                                    <div class="col-md-12">
                                                        <input type="checkbox" id="ouvrir" name="ouvrir" @if($item->ouvrir) checked @endif>
                                                        <label for="ouvrir">Ne pas Ouvrir le colis?</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-12 row">
                                                    <label for="commentaire" class="col-md-2 col-form-label">{{ __('Commentaire') }}</label>
                                                    <div class="col-md-10">
                                                        <textarea id="commentaire" name="commentaire" class="form-control" autocomplete="on" autofocus>{{$item->commentaire}}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row mb-0 offset-md-8">
                                                <div class="mr-2">
                                                    <a href="{{route('toutColis')}}" class="btn btn-danger">{{ __('Annuler') }}</a>
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
                        </td>
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
            $('#tousColis').DataTable();
        });
        $(document).ready( function () {
            $('#historiques').DataTable();
        });
        function Tarif(value){
            let id = value.split('_')[0];
            let frais = value.split('_')[1];
            let tarif = document.querySelector("#tarif")
            document.querySelector("#ville_id").value = id
            tarif.innerHTML=`${frais}`;           
        }
        var etat = document.querySelector("#etat")
        etat.addEventListener('change', function () {
            if(etat.value == "Reporté") {
                document.querySelector("#reporte").style.display = "block";
            }else{
                document.querySelector("#reporte").style.display = "none";
            }
        })
    </script>
@endsection