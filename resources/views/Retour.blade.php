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
            <h4 class="font-weight-bold m-2">Liste des Colis a retourner</h4>
        </div>
        <div class="card-body">
            <table id="attente" class="display">
                <thead>
                    <tr>
                        <th>Code Suivi</th>
                        <th>Date de creation</th>
                        <th>Téléphone</th>
                        <th>Nom du Magasin</th>
                        <th>Status</th>
                        <th>Région Retour</th>
                        <th>Ville Retour</th>
                        <th>Prix</th>
                        <th>Etat</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($Attente as $item) 
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
                                <td>{{$item->region}}</td>
                                <td>{{$item->ville}}</td>
                                <td>{{$item->prix}} DH</td>
                                <td>{{$item->etat}}</td>
                            </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card mt-4">
        <div class="m-4">
            <form action="{{route('newRetour')}}" method="post" class="row">
                @csrf
                <div class="row col-md-10">
                    <label for="region_id" class="text-right col-md-2 col-form-label">{{ __('Region :') }}</label>
                    <select name="region_id" id="region_id" class="col-md-10 form-control" value="{{ old('region_id') }}" required  autofocus autocomplete="on">
                        <option value="region">region</option>
                        @foreach ($regions as $r)     
                            <option value="{{$r->id}}">{{$r->region}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="row col-md-2 ml-2">
                    <button type="submit" class="btn btn-info ">Nouveau Bon</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <h4 class="font-weight-bold m-2">Liste des Bons de retour</h4>
        </div>
        <div class="card-body">
            <table id="Retour" class="display">
                <thead>
                    <tr>
                        <th>Réf</th>
                        <th>Région</th>
                        <th>Date de création</th>
                        <th>Date d'enregistrement</th>
                        <th>Status</th>
                        <th>Colis</th>
                        <th>Reçu</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bons as $item) 
                    <tr>
                        <td>{{ $item->ref }}</td>
                        <td>{{ $item->region }}</td>
                        <td>{{$item->created_at}}</td>
                        <td>
                            @if ($item->etat == 'Enregistré')
                            {{$item->updated_at}}
                            @endif
                        </td>
                        <td> 
                            @if ($item->etat == 'Enregistré')
                            <p class="text-center border border-info">{{$item->etat}}</p>
                            @else
                            <p class="text-center border border-warning">{{$item->etat}}</p>
                            @endif
                        </td>
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
                        <td>
                            @php
                            $r = 0;
                            foreach ($colis as $col){
                                if ($col->bon_id === $item->id){
                                    if($col->valide == true){
                                        $r++;
                                    }
                                }
                            }
                            echo $r;
                            @endphp
                        </td>
                        <td class="d-flex">
                            @if ($item->etat == 'Nouveau')
                            <form action="{{route('editRetour')}}" method="get">
                                @csrf
                                <input type="hidden" name="bon_id" value="{{$item->id}}">
                                <button type="submit" class="btn btn-light"><i class="fas fa-edit"></i></button>
                            </form>
                                <form action="{{route('RetourValider')}}" method="get">
                                    @csrf
                                    <input type="hidden" name="bon_id" value="{{$item->id}}">
                                    <button type = "submit" class="btn btn-light"><i class="fas fa-check"></i></button>
                                </form>
                            @endif
                            <button type="button" class="btn btn-light" data-toggle="modal" data-target="{{'#model_'.$item->id}}">
                                <i class="fas fa-info-circle"></i>
                            </button>
                            <div class="modal fade bd-example-modal-lg" id ="{{'model_'.$item->id}}"tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th scope="col">Code Barre</th>
                                            <th scope="col">Destinataire</th>
                                            <th scope="col">Téléphone</th>
                                            <th scope="col">Etat</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($colis as $ele)
                                            @if ($ele->bon_id === $item->id)
                                                <tr>
                                                    <td>
                                                        @php
                                                            echo $ele->code_bar."<span class=\"font-weight-bold\">".$ele->code."</span>";
                                                        @endphp
                                                    </td>
                                                    <td>{{$ele->destinataire }}</td>
                                                    <td>{{$ele->telephone }}</td>
                                                    <td>{{$ele->etat }}</td>
                                                </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
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
            $('#Retour').DataTable();
        });
        $(document).ready( function () {
            $('#attente').DataTable();
        });
    </script>
@endsection