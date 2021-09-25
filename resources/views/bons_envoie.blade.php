@extends('adminLte.dashboard')
@section('Envoi')
active
@endsection

@section('content')
<div class="container">
    <div class="card mt-4">
        <div class="card-header">
            <h4 class="font-weight-bold m-2">Liste des Colis Reçu</h4>
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
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <h4 class="font-weight-bold m-2">Liste des Bons d'Envoie</h4>
        </div>
        <div class="card-body">
            <table id="Envoie" class="display">
                <thead>
                    <tr>
                        <th>Réf</th>
                        <th>Date de création</th>
                        <th>Date d'enregistrement</th>
                        <th>Status</th>
                        <th>Colis</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bons as $item) 
                    <tr>
                        <td>{{ $item->ref }}</td>
                        <td>{{$item->created_at}}</td>
                        <td>
                            @if ($item->etat_r == 'Enregistré')
                            {{$item->updated_at}}
                            @endif
                        </td>
                        <td>{{$item->etat_r}}</td>
                        <td>
                            @php
                            $c = 0;
                            foreach ($colis as $col){
                                if ($col->bon_id === $item->id){
                                    $c++;
                                }
                            }
                            echo $c;
                            @endphp
                        </td>
                        <td class="row">
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
            $('#Envoie').DataTable();
        });
        $(document).ready( function () {
            $('#recu').DataTable();
        });
    </script>
@endsection