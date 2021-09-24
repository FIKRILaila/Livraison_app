@extends('adminLte.dashboard')
@section('newenvoie')
active
@endsection
@section('bonenvoie')
active
@endsection
@section('content')
<div class="container">
            @if (Session::get('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
            @endif
            @if (Session::get('fail'))
                <div class="alert alert-danger">{{ Session::get('fail') }}</div>
            @endif
            <div class="mt-4 card col-md-12" >
                <form id="bon_livraison" action="{{ route('store')}}" method="POST">
                    @csrf
                    <input type="text" hidden name="colis" id="colis" value="">
                    <div class="form-group">
                        <label for="region_id" class="mb-2 col-form-label">{{ __('Région') }}</label>
                        <div>
                            <select name="region_id" id="region_id" class="form-control @error('region_id') is-invalid @enderror" value="{{ old('region_id') }}" required  autofocus autocomplete="on">
                                <option value="">Région</option>
                              @foreach ($regions as $region)     
                                    <option value="{{$region->id}}">{{$region->name}}</option>
                              @endforeach
                            </select>
                        </div>
                        <button class="btn btn-primary offset-md-10 mb-4" onclick="demande_livraison()">Bon de Livraison</button>
                    </div>
                </form>

                {{-- <i class="fas fa-level-down-alt"></i>
                <input type="checkbox" name="selectAll" id="selectAll">
                <span class="mr-4">Tout Cocher</span>
                <span>Avec la Selection :</span>  --}}
            </div>
            <div class="mt-4 card col-md-12">
                <div class="m-4">
                    <table id="colis_env" class="display">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Destinataire</th>
                                <th>Région</th>
                                <th>Adresse</th>
                                <th>Prix</th>
                                <th>Code Barre</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($colis as $item) 
                            @if ($item->etat == 'ramasse')
                            <tr>
                                <td><input type="checkbox" name="bon" value="{{$item->id}}"></td>
                                <td>{{$item->destinataire}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->adresse}}</td>
                                <td>{{$item->prix}}</td>
                                <td>
                                    @php
                                        echo $item->code_bar."<span class=\"font-weight-bold\">".$item->code."</span>";
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
@endsection
@section('script')
<script>
     $(document).ready( function () {
            $('#colis_env').DataTable();
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

