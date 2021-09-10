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
        <div class="m-4">
            <table id="myTable" class="display">
                <thead>
                    <tr>
                        <th></th>
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
                        <td>
                            <form action="" method="post">
                                <input type="hidden" name="colis_id" value="{{$item->id}}">
                                <input type="checkbox" name="selectionner" id="selectionner">
                            </form>
                        </td>
                        <td>{{$item->destinataire}}</td>
                        <td>{{$item->name}}</td>
                        <td>{{$item->adresse}}</td>
                        <td>{{$item->prix}}</td>
                        <td>
                            @php
                                echo $item->code_bar."<span class=\"font-weight-bold\">".$item->id."</span>";
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
@section('script')
    <script>
        $(document).ready( function () {
            $('#myTable').DataTable();
        });
    </script>
@endsection