@extends('adminLte.dashboard')
{{-- @extends('layouts.app') --}}
@section('factures')
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
    @if (Auth::user()->role == 'admin')  
    <div class="card mt-4">
        <div class="m-4">
            <form action="{{route('filtreColisFacture')}}" method="post" class="row">
                @csrf
                <div class="row col-md-10">
                    <label for="client_id" class="text-right col-md-2 col-form-label">{{ __('Nom de Magasin :') }}</label>
                    <select name="client_id" id="client_id" class="col-md-10 form-control " value="{{ old('client_id') }}" required  autofocus autocomplete="on">
                        <option value="magasin">Nom de Magasin</option>
                        @foreach ($clients as $c)
                            <option value="{{$c->id}}">{{$c->nomMagasin}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="d-flex justify-content-end ml-2">
                    <button type="submit" class="btn btn-info ">Filtrer</button>
                </div>
            </form>
        </div>
    </div>
    <div class="card mt-4">
        <div class="card-header">
            <h4 class="font-weight-bold m-2 text-info">Liste des Colis Non Facturé</h4>
        </div>
        <div class="mt-4 ml-4" >
            <form id="facture" action="{{ route('StoreFacture')}}" method="POST" class="d-none">
                @csrf
                <input type="text" name="colis" id="colis" value="" required>
                <input type="text" name="client" id="client" value="" required>
            </form>
            <i class="fas fa-level-down-alt"></i>
            <input type="checkbox" name="selectAll" id="selectAll">
            <span class="mr-4">Tout Cocher</span>
            <span>Avec la Selection :</span> 
            <button class="btn btn-info" onclick="Facture()">Nouvelle Facture</button>
        </div>
        <div class="card-body">
            <table id="attente" class="display">
                <thead>
                    <tr>
                        <th></th>
                        <th>Code Suivi</th>
                        <th>Date de creation</th>
                        <th>Téléphone</th>
                        <th>Nom du Magasin</th>
                        <th>Ville</th>
                        <th>Prix</th>
                        <th>Etat</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($Attente as $item) 
                            <tr>
                                <th><input type="checkbox" name="generer" value ="{{$item->id}}_{{$item->client_id}}"></th>
                                <td>{{$item->code}}</td>
                                <td>{{$item->created_at}}</td>
                                <td>{{$item->telephone}}</td>
                                <td>{{$item->nomMagasin}}</td>
                                <td>{{$item->ville}}</td>
                                <td>{{$item->prix}} DH</td>
                                <td>{{$item->etat}}</td>
                            </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
    <div class="card mt-4">
        <div class="card-header">
            <h4 class="font-weight-bold m-2 text-info">Liste des Factures</h4>
        </div>
        <div class="card-body">
            <table id="factures" class="display">
                <thead>
                    <tr>
                        <th>Réf</th>
                        <th>Date de création</th>
                        @if (Auth::user()->role == 'admin')  
                        <th>Client</th>
                        <th>Nom de Magasin </th>
                        @endif
                        <th>Colis</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($factures as $item) 
                    <tr>
                        <td>{{ $item->reference }}</td>
                        <td>{{$item->created_at}}</td>
                        @if (Auth::user()->role == 'admin')  
                        <td>{{$item->nomComplet}}</td>
                        <td>{{$item->nomMagasin}}</td>
                        @endif
                        <td>
                            @php
                            $c = 0;
                            foreach ($colis as $col){
                                if ($col->facture_id == $item->id){
                                    $c++;
                                }
                            }
                            echo $c;
                            @endphp
                        </td>
                        <td class="d-flex">
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
                                                <th scope="col">Code Barre</th>
                                                <th scope="col">Destinataire</th>
                                                <th scope="col">Téléphone</th>
                                                <th scope="col">Etat</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($colis as $ele)
                                                @if ($ele->facture_id === $item->id)
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
                            </div>
                            <form action="{{route('imprimerFacture')}}" method="post">
                                @csrf
                                <input type="hidden" name="facture_id" value="{{ $item->id }}">
                                <button type ="submit" class="btn btn-light"><i class="fas fa-print"></i></button>
                            </form>
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
            $('#attente').DataTable();
        });
        $(document).ready( function () {
            $('#factures').DataTable();
        });
        function Facture(){
        var form = document.querySelector("#facture");
        var colis = document.querySelector("#colis");
        var client = document.querySelector("#client");
        colis.value ="";
        client.value ="";
        var ele=document.getElementsByName('generer');  
                for(var i=0; i<ele.length; i++){  
                    if(ele[i].checked === true){
                        colis.value += ele[i].value.split('_')[0] + "_" ;
                        client.value += ele[i].value.split('_')[1] + "_" ;
                        // colis.value += ele[i].value + "_" ;
                        // client.value += ele[i].value + "_" ;
                    }
                }  
                if(client.value != "" &&  colis.value != ""){ 
                    form.submit();
                }
        }

        document.querySelector("#selectAll").addEventListener('click',function(){
            let select = document.querySelector("#selectAll").checked
            if(select === true){
                var ele=document.getElementsByName('generer');  
                    for(var i=0; i<ele.length; i++){  
                            ele[i].checked=true;  
                    }  
            }else{
                var ele=document.getElementsByName('generer');  
                    for(var i=0; i<ele.length; i++){  
                            ele[i].checked=false;  
                    } 
            }
        });
    </script>
@endsection