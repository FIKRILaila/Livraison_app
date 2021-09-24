@extends('adminLte.dashboard')
{{-- @extends('layouts.app') --}}
@section('toutColis')
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
                        <td>
                            <button type="button" class="btn btn-light" data-toggle="modal" data-target="{{'#model_'.$item->id}}"><i class="fas fa-info-circle"></i></button>
                            <div class="modal fade" id="{{'model_'.$item->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="m-4">
                                        <table id="historiques" class="display">
                                            <thead>
                                                <tr>
                                                    <th>Code d'envoie</th>
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
    </script>
@endsection