@extends('adminLte.dashboard')
@section('colis')
active
@endsection
@section('mesColis')
active
@endsection
@section('content')
<div class="container">
    {{-- @php
        foreach($colis as $item){
            echo $item->code_bar;
        }
    @endphp --}}
    {{-- @foreach ($colis as $item) 
    {{echo $item->code_bar}}
    @endforeach --}}
    <div class="mt-4 card col-md-12">
        <div class="m-4">
            <table id="myTable" class="display">
                <thead>
                    <tr>
                        <th>Destinataire</th>
                        <th>Ville</th>
                        <th>Adresse</th>
                        <th>Prix</th>
                        <th>Code Barre</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($colis as $item) 
                    <tr>
                        <td>{{$item->destinataire}}</td>
                        <td>{{$item->name}}</td>
                        <td>{{$item->adresse}}</td>
                        <td>{{$item->prix}}</td>
                        <td>
                            @php
                                echo $item->code_bar;
                            @endphp
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

