@extends('adminLte.dashboard')
@section('ColisLivreur')
    active
@endsection
@section('content')
<div class="container">
    <div class="mt-4 card col-md-12">
        <div class="m-4">
            <table id="tousColis" class="display">
                <thead>
                    <tr>
                        <th>Code d'Envoie</th>
                        <th>Date de creation</th>
                        <th>Téléphone</th>
                        <th>Adresse</th>
                        {{-- <th>Nom du Magasin</th> --}}
                        <th>Etat</th>
                        <th>Status</th>
                        <th>Ville</th>
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
                        <td>@if ($item->paye == false) Non Payé @else Payé @endif </td>
                        <td>{{$item->etat}}</td>
                        {{-- <td>{{$item->ville}}</td> --}}
                        <td>{{$item->prix}} DH</td>
                        <td>
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
                                                                <option value="Livré">Livré</option>
                                                                <option value="En Retour">En Retour</option>
                                                                <option value="Refusé">Refusé</option>
                                                                <option value="Reporté">Reporté</option> {{-- a une date --}}
                                                                <option value="Pas de Réponse 1">Pas de Réponse 1</option>
                                                                <option value="Pas de Réponse 2">Pas de Réponse 2</option>
                                                                <option value="Pas de Réponse 3">Pas de Réponse 3</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-12 " id="reporte" style="display:none;">
                                                        <label for="reported_at" class="col-md-2 col-form-label">{{ __('Reporté à : ') }}</label>
                                                        <div class="col-md-10">
                                                            <input type="datetime-local" name="reported_at" id="reported_at" class="form-control" value="{{ old('reported_at') }}" autofocus autocomplete="on">
                                                        </div>
                                                    </div>
                                                <div class="form-group row mb-0 offset-md-8">
                                                    <div class="mr-2">
                                                        <a href="{{route('ColisLivreur')}}" class="btn btn-danger">{{ __('Annuler') }}</a>
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