@extends('adminLte.dashboard')
@section('Envoi')
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
    <div class="card mt-4 row">
    <a href="{{route('newEnvoi')}}" class="btn btn-primary col-md-2">Ajouter</a>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <h4 class="font-weight-bold m-2">Liste des Bons d'Envoie</h4>
        </div>
        <div class="card-body">
            <table id="Envoie" class="display">
                <thead>
                    <tr>
                        <th>Réf</th>
                        <th>Date de création</th>
                        <th>Date d'enregistrement</th>
                        <th>Status</th>
                        <th>Colis</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bons as $item) 
                    <tr>
                        <td>{{ $item->ref }}</td>
                        <td>{{$item->created_at}}</td>
                        <td>
                            @if ($item->etat == 'Enregistré')
                            {{$item->updated_at}}
                            @endif
                        </td>
                        <td>{{$item->etat}}</td>
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
                        <td class="row">
                            @if ($item->etat == 'Nouveau')
                            <form action="{{route('editEnvoi')}}" method="get">
                                @csrf
                                <input type="hidden" name="bon_id" value="{{$item->id}}">
                                <button type="submit" class="btn btn-light"><i class="fas fa-edit"></i></button>
                            </form>
                                <form action="{{route('EnvoiValider')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="bon_id" value="{{$item->id}}">
                                    <button type = "submit" class="btn btn-light"><i class="fas fa-check"></i></button>
                                </form>
                            @endif
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
    </script>
@endsection