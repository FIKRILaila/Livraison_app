@extends('adminLte.dashboard')
@section('colis')
active
@endsection
@section('mesColis')
active
@endsection
@section('content')
<div class="container">
    <div class="mt-4 card col-md-12">
        <div class="m-4" >
            <form id="bon_livraison" action="{{ route('store')}}" method="POST" class="d-none">
                @csrf
                <input type="text" name="colis" id="colis" value="">
            </form>
            <i class="fas fa-level-down-alt"></i>
            <input type="checkbox" name="selectAll" id="selectAll">
            <span class="mr-4">Tout Cocher</span>
            <span>Avec la Selection :</span> 
            <button class="btn btn-primary" onclick="demande_livraison()">Bon de Livraison</button>
        </div>
        <div class="m-4">
            <table id="myTable" class="display">
                <thead>
                    <tr>
                        <th></th>
                        <th>Code</th>
                        <th>Destinataire</th>
                        <th>Ville</th>
                        <th>Adresse</th>
                        <th>Prix</th>
                        <th>Code Barre</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($colis as $item) 
                    {{-- @if ($item->etat == 'Nouveau Colis') --}}
                    <tr>
                        <td><input type="checkbox" name="bon" value="{{$item->id}}"></td>
                        <td>{{$item->code}}</td>
                        <td>{{$item->destinataire}}</td>
                        <td>{{$item->ville}}</td>
                        <td>{{$item->adresse}}</td>
                        <td>{{$item->prix}}</td>
                        <td>
                            @php
                                echo $item->code_bar."<span class=\"font-weight-bold\">".$item->code."</span>";
                            @endphp
                        </td>
                    </tr>
                    {{-- @endif --}}
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
            $('#myTable').DataTable();
        });

    document.querySelector("#selectAll").addEventListener('click',function(){
        let select = document.querySelector("#selectAll").checked
        if(select === true){
            var ele=document.getElementsByName('bon');  
                for(var i=0; i<ele.length; i++){  
                        ele[i].checked=true;  
                }  
        }else{
            var ele=document.getElementsByName('bon');  
                for(var i=0; i<ele.length; i++){  
                        ele[i].checked=false;  
                } 
        }
    });

    function demande_livraison(){
        var form = document.querySelector("#bon_livraison");
        var input = document.querySelector("#colis");
        input.value ="";
        var ele=document.getElementsByName('bon');  
                for(var i=0; i<ele.length; i++){  
                    if(ele[i].checked === true){
                        // form.appendChild(ele[i]);
                        input.value += ele[i].value + "_" ;
                    }
                    // if(ele[i].checked === false){
                    //     form.removeChild(ele[i]);
                    // }
                }  
                form.submit();
    }

    </script>
@endsection