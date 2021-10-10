@extends('adminLte.dashboard')
@section('Envoi')
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
            <p class="font-weight-bold m-2">Liste des Colis a envoyer</p>
        </div>
        <div class="card-body">
            <table id="envoyer" class="display">
                <thead>
                    <tr>
                        <th>Code d'Envoie</th>
                        <th>Date de creation</th>
                        <th>Téléphone</th>
                        <th>Nom du Magasin</th>
                        <th>Etat</th>
                        <th>Status</th>
                        <th>Région</th>
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
                                <td>{{$item->region}}</td>
                                <td>{{$item->ville}}</td>
                                <td>{{$item->prix}} DH</td>
                            </tr>
                        {{-- @endif --}}
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card mt-4">
        <div class="m-4">
            <form action="{{route('newEnvoi')}}" method="post" class="row">
                @csrf
                <div class="row col-md-10">
                    <label for="region_id" class="text-right col-md-2 col-form-label">{{ __('Region :') }}</label>
                    <select name="region_id" id="region_id" class="col-md-10 form-control" value="{{ old('region_id') }}" required  autofocus autocomplete="on">
                        <option value="region">region</option>
                        @foreach ($regions as $r)
                            @if ($r->region != "Grand Casablanca")
                            <option value="{{$r->id}}">{{$r->region}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="row col-md-2 ml-2">
                    <button type="submit" class="btn btn-info ml-4">Nouveau Bon</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <p class="font-weight-bold m-2">Liste des Bons d'Envoie</p>
        </div>
        <div class="card-body">
            <table id="Envoie" class="display">
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
                            <form action="{{route('editEnvoi')}}" method="get">
                                @csrf
                                <input type="hidden" name="bon_id" value="{{$item->id}}">
                                <button type="submit" class="btn btn-light"><i class="fas fa-edit"></i></button>
                            </form>
                                <form action="{{route('EnvoiValider')}}" method="get">
                                    @csrf
                                    <input type="hidden" name="bon_id" value="{{$item->id}}">
                                    <button type = "submit" class="btn btn-light"><i class="fas fa-check"></i></button>
                                </form>
                            @endif
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
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Destinataire</th>
                                                <th scope="col">Téléphone</th>
                                                <th scope="col">Etat</th>
                                                <th scope="col">Code Barre</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($colis as $ele)
                                                @if ($ele->bon_id === $item->id)
                                                    <tr>
                                                        <th scope="row">{{ $ele->bon }}</th>
                                                        <td>{{$ele->destinataire }}</td>
                                                        <td>{{$ele->telephone }}</td>
                                                        <td>{{$ele->etat }}</td>
                                                        <td>
                                                            @php
                                                                echo $ele->code_bar."<span class=\"font-weight-bold\">".$ele->code."</span>";
                                                            @endphp
                                                        </td>
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
            $('#Envoie').DataTable();
        });
        $(document).ready( function () {
            $('#envoyer').DataTable();
        });
    </script>
@endsection