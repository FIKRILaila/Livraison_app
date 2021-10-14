@extends('adminLte.dashboard')
@section('Reception')
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
        <h4 class="m-2"><span class="font-weight-bold text-info">Bon :</span> {{$bon->ref}} / <span class="font-weight-bold text-info">Date de Création :</span> {{$bon->created_at}} </h4>
    </div>
    <div class="card">
        <div class="m-4">
            <form action="{{route('ReceptionCode')}}" method="post" class="row">
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
        </div>
    </div>
    <div class="card">
        <div class="mt-4 ml-4" >
            <form id="retirer_colis" action="{{ route('RetirerReception')}}" method="post" class="d-none">
                @csrf
                <input type="text" name="bon_id" value="{{$bon->id}}">
                <input type="text" name="colis" id="colis" value="">
            </form>
            <i class="fas fa-level-down-alt"></i>
            <input type="checkbox" name="selectAll" id="selectAll">
            <span class="mr-4">Tout Cocher</span>
            <span>Avec la Selection :</span> 
            <button class="btn btn-info" onclick="Retirer()">Retirer</button>
        </div>
        <div class="m-4">
            <table id="reception" class="display">
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
            $('#reception').DataTable();
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