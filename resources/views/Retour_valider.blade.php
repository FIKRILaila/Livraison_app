@extends('adminLte.dashboard')
@section('Retour')
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
    <div class="card mt-4">
        <div class="card-header">
            <h4 class="font-weight-bold m-2">Liste des Colis non valide</h4>
        </div>
        <div class="card-body">
            <table id="attente" class="display">
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
                        @if($item->valide == false)
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
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card">
        <div class="m-4">
            <form action="{{route('ValiderCodeRetour')}}" method="post" class="row">
                @csrf
                <input type="hidden" name="bon_id" value="{{$bon->id}}">
                <div class="row col-md-10">
                    <label for="code_suivi" class="col-md-2 text-right col-form-label">Code Suivi * :</label>
                    <input type="text" name="code_suivi" class="form-control col-md-10">
                </div>
                <div class="row col-md-2 ml-2">
                    <button type="submit" class="btn btn-info">Valider</button>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h4 class="font-weight-bold m-2">Liste des Colis Valider</h4>
        </div>
        <div class="m-4">
            <table id="valider" class="display">
                <thead>
                    <tr>
                        <th>Code Suivi</th>
                        <th>Destinataire</th>
                        <th>Date de Création</th>
                        <th>Prix</th>
                        <th>Ville</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                        @foreach ($colis as $coli)
                        @if($coli->valide == true)
                            <tr>
                                <td>{{$coli->code}}</td>
                                <td>{{$coli->destinataire}}</td>
                                <td>{{$coli->created_at}}</td>
                                <td>{{$coli->prix}}</td>
                                <td>{{$coli->ville}}</td>
                                <td>{{$coli->etat}}</td>
                            </tr>
                        @endif
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
            $('#attente').DataTable();
        });
        $(document).ready( function () {
            $('#valider').DataTable();
        });
    </script>
@endsection
