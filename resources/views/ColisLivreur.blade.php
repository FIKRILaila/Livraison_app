@extends('adminLte.dashboard')
@section('ColisLivreur')
    active
@endsection
@section('content')
<div class="m-4">
    <div class="mt-4 card col-md-12">
        <div class="m-4">
            <table id="tousColis" class="display">
                <thead>
                    <tr>
                        <th>Code Suivi</th>
                        <th>Date de creation</th>
                        <th>Téléphone</th>
                        <th>Adresse</th>
                        {{-- <th>Nom du Magasin</th> --}}
                        <th>Ville</th>
                        <th>Etat</th>
                        <th>Status</th>
                        <th>Reporté a</th>
                        {{-- <th>Prix</th> --}}
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($colis as $item) 
                    <tr>
                        <td>{{$item->code}}</td>
                        <td>{{$item->created_at}}</td>
                        <td>{{$item->telephone}}</td>
                        <td>{{$item->adresse}}</td>
                        {{-- <td>{{$item->nomMagasin}}</td> --}}
                        <td>{{$item->ville}}</td>
                        <td>@if ($item->paye == false) Non Payé @else Payé @endif </td>
                        <td>{{$item->etat}}</td>
                        <td>{{$item->reported_at}}</td>
                        {{-- <td>{{$item->prix}} DH</td> --}}
                        <td>
                            <button type="button" class="btn btn-light" data-toggle="modal" data-target="{{'#model_'.$item->id}}">
                                <i class="fas fa-info-circle"></i>
                            </button>
                            <div class="modal fade" id="{{'model_'.$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle ">Détails</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
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
                            </div>
                            @if ($item->etat != "Livré") 
                            <button type="button" class="btn btn-light" data-toggle="modal" data-target="{{'#edit_'.$item->id}}"><i class="fas fa-edit"></i></button>
                            <div class="modal fade" id="{{'edit_'.$item->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="m-4">
                                            <form method="POST" action="{{ route('editLivreur') }}">
                                                @csrf
                                                <input type="hidden" name="colis_id" value="{{$item->id}}">
                                                <div class="form-group col-md-12 row">
                                                    <label for="etat" class="col-md-2 col-form-label">{{ __('Status') }}</label>
                                                    <div class="col-md-10">
                                                        <select name="etat" id="etat" class="form-control" value="{{ old('etat') }}" required  autofocus autocomplete="on">
                                                            <option value="{{$item->etat}}">{{$item->etat}}</option>
                                                            <option value="Annulé">Annulé</option>
                                                            <option value="Refusé">Refusé</option>
                                                            <option value="Reporté">Reporté</option>
                                                            <option value="Pas de Réponse">Pas de Réponse</option>
                                                            <option value="Erreur Numéro">Erreur Numéro</option>
                                                            <option value="Numéro Injoignable">Numéro Injoignable</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12 " id="reporte" style="display:none;">
                                                    <label for="reported_at" class="col-md-2 col-form-label">{{ __('Reporté à : ') }}</label>
                                                    <div class="col-md-10">
                                                        <input type="date" name="reported_at" id="reported_at" class="form-control" value="{{ old('reported_at') }}" autofocus autocomplete="on">
                                                    </div>
                                                </div>
                                                <div class="form-group d-flex justify-content-end">
                                                    <div class="mr-2">
                                                        <a href="{{route('ColisLivreur')}}" class="btn btn-secondary">{{ __('Annuler') }}</a>
                                                    </div>
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
                        
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="{{'#livre_'.$item->id}}">
                                Livré
                            </button>
                            <div class="modal fade" id="{{'livre_'.$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <form method="POST" action="{{ route('editLivreur') }}">
                                            @csrf
                                            <h3 class="font-weight-bold mt-4 mb-4">Vous êtes Sûr ?</h3>
                                            <input type="hidden" name="colis_id" value="{{$item->id}}">
                                            <input type="hidden" name="etat" value="Livré">
                                            <div class="row justify-content-end mt-4 mr-2 mb-2">
                                                <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">Annuler</span>
                                                </button>
                                                {{-- <a href="{{route('ColisLivreur')}}" class="btn btn-secondary">Annuler</a> --}}
                                                <button type="submit" class="btn btn-info">{{ __('Livré') }}</button>
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