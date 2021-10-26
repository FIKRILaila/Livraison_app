@extends('adminLte.dashboard')
@section('BonPaiment')
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
    <div class="mt-4 card">
        <div class="m-4">
            <form action="{{route('filtrerPaiment')}}" method="post" class="row">
                @csrf
                <div class="row col-md-10">
                    <label for="livreur_id" class="text-right col-md-4 col-form-label">{{ __('Livreur :') }}</label>
                    <select name="livreur_id" id="livreur_id" class="col-md-8 form-control " value="{{ old('livreur_id') }}" required  autofocus autocomplete="on">
                        <option value="magasin">Livreur</option>
                        @foreach ($livreurs as $liv)
                            <option value="{{$liv->id}}">{{$liv->nomComplet}}</option>
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
            <h4 class="font-weight-bold m-2 text-info">Liste des Colis Livré</h4>
        </div>
        <div class="mt-4 ml-4" >
            <form id="bonPaiment" action="{{route('storePaiment')}}" method="POST" class="d-none">
                @csrf
                <input type="text" name="colis" id="colis" value="" required>
                <input type="text" name="livreur" id="livreur" value="" required>
            </form>
            <i class="fas fa-level-down-alt"></i>
            <input type="checkbox" name="selectAll" id="selectAll">
            <span class="mr-4">Tout Cocher</span>
            <span>Avec la Selection :</span> 
            <button class="btn btn-info" onclick="Paiment()">Nouveau Bon</button>
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
                                <th><input type="checkbox" name="generer" value ="{{$item->id}}_{{$item->livreur_id}}"></th>
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
            <h4 class="font-weight-bold m-2 text-info">Liste des Bons de Paiment</h4>
        </div>
        <div class="card-body">
            <table id="bons" class="display">
                <thead>
                    <tr>
                        <th>Réference</th>
                        <th>Date de creation</th>
                        @if (Auth::user()->role == 'admin')
                        <th>Livreur</th>
                        @endif
                        <th>Colis</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bons as $item) 
                            <tr>
                                <td>{{$item->ref}}</td>
                                <td>{{$item->created_at}}</td>
                                @if (Auth::user()->role == 'admin')
                                <td>{{$item->nomComplet}}</td>
                                @endif
                                <td>
                                    @php
                                    $c = 0;
                                    foreach ($colis as $col){
                                        if ($col->bon_id == $item->id){
                                            $c++;
                                        }
                                    }
                                    echo $c;
                                    @endphp
                                </td>
                                <td class="d-flex">
                                    <button type="button" class="btn btn-light" data-toggle="modal" data-target="{{'#model_'.$item->id}}"><i class="fas fa-info-circle"></i></button>
                                    
                                    <div class="modal fade bd-example-modal-lg" id="{{'model_'.$item->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
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
                                                        @if ($ele->bon_id == $item->id)
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
                                    <form action="{{route('imprimerPaiment')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="bon" value="{{ $item->id }}">
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
            $('#bons').DataTable();
        });
        function Paiment(){
        var form = document.querySelector("#bonPaiment");
        var colis = document.querySelector("#colis");
        var livreur = document.querySelector("#livreur");
        colis.value ="";
        livreur.value ="";
        var ele=document.getElementsByName('generer');  
                for(var i=0; i<ele.length; i++){  
                    if(ele[i].checked === true){
                        colis.value += ele[i].value.split('_')[0] + "_" ;
                        livreur.value += ele[i].value.split('_')[1] + "_" ;
                    }
                }  
                if(livreur.value != "" &&  colis.value != ""){ 
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