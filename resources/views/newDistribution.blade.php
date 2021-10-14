@extends('adminLte.dashboard')
@section('Distribution')
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
    @if ($bon->livreur_id != NULL)
    <div class="card mt-4">
        <h3 class="m-2 font-weight-bold"><span class="text-info">Bon :</span> {{$bon->ref}} / <span class=" text-info">Région :</span> {{$bon->region}} / <span class="text-info">Date de Création :</span> {{$bon->created_at}} </h3>
    </div>
    <div class="card mt-4">
        <div class="card-header">
            <h4 class="font-weight-bold m-2">Liste des Colis a Distribuer</h4>
        </div>
        <div class="card-body">
            <table id="recu" class="display">
                <thead>
                    <tr>
                        <th>Code d'Envoie</th>
                        <th>Date de creation</th>
                        <th>Téléphone</th>
                        <th>Nom du Magasin</th>
                        <th>Status</th>
                        <th>Ville</th>
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
    <div class="card">
        <div class="m-4">
            @if ($bon->livreur_id == NULL)
                <form action="{{route('Distributeur')}}" method="post" class="row">
                    @csrf
                    <input type="hidden" name="bon_id" value="{{$bon->id}}">
                    <div class="row col-md-10">
                        <label for="livreur_id" class="text-right col-md-2 col-form-label">{{ __('Livreur: *') }}</label>
                        <select name="livreur_id" id="livreur_id" class="col-md-10 form-control @error('livreur_id') is-invalid @enderror" value="{{ old('livreur_id') }}" required  autofocus autocomplete="on">
                            <option value="">Livreur</option>
                            @foreach ($livreurs as $liv)     
                                <option value="{{$liv->id}}">{{$liv->nomComplet}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row col-md-2 ml-2">
                        <button type="submit" class="btn btn-info">Ajouter</button>
                    </div>
                </form>
            @else
                <form action="{{route('DistributionCode')}}" method="post" class="row">
                    @csrf
                    <input type="hidden" name="bon_id" value="{{$bon->id}}">
                    <div class="row col-md-10">
                        <label for="code_suivi" class="col-md-2 text-right col-form-label">Code Suivi * :</label>
                        <input type="text" name="code_suivi" class="form-control col-md-10">
                    </div>
                    <div class="row col-md-2 ml-2">
                        <button type="submit" class="btn btn-info">Ajouter</button>
                    </div>
                </form>
            @endif
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h4 class="font-weight-bold m-2">Liste des Colis Ajouter</h4>
        </div>
        <div class="mt-4 ml-4" >
            <form id="retirer_colis" action="{{ route('RetirerDistribution')}}" method="POST" class="d-none">
                @csrf
                <input type="text" name="colis" id="colis" value="">
                <input type="text" name="bon_id" id="colis" value="{{$bon->id}}">
            </form>
            <i class="fas fa-level-down-alt"></i>
            <input type="checkbox" name="selectAll" id="selectAll">
            <span class="mr-4">Tout Cocher</span>
            <span>Avec la Selection :</span> 
            <button class="btn btn-info" onclick="Retirer()">Retirer</button>
        </div>
        <div class="m-4">
            <table id="envoi" class="display">
                <thead>
                    <tr>
                        <th></th>
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
                            <tr>
                                <th><input type="checkbox" name="retirer" value ="{{$coli->id}}"></th>
                                <td>{{$coli->code}}</td>
                                <td>{{$coli->destinataire}}</td>
                                <td>{{$coli->created_at}}</td>
                                <td>{{$coli->prix}}</td>
                                <td>{{$coli->ville}}</td>
                                <td>{{$coli->etat}}</td>
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
            $('#recu').DataTable();
        });
        $(document).ready( function () {
            $('#envoi').DataTable();
        });
        function Retirer(){
        var form = document.querySelector("#retirer_colis");
        var input = document.querySelector("#colis");
        input.value ="";
        var ele=document.getElementsByName('retirer');  
                for(var i=0; i<ele.length; i++){  
                    if(ele[i].checked === true){
                        input.value += ele[i].value + "_" ;
                    }
                }  
                form.submit();
        }
        document.querySelector("#selectAll").addEventListener('click',function(){
            let select = document.querySelector("#selectAll").checked
            if(select === true){
                var ele=document.getElementsByName('retirer');  
                    for(var i=0; i<ele.length; i++){  
                            ele[i].checked=true;  
                    }  
            }else{
                var ele=document.getElementsByName('retirer');  
                    for(var i=0; i<ele.length; i++){  
                            ele[i].checked=false;  
                    } 
            }
        });
    </script>
@endsection



   
    