@extends('adminLte.dashboard')
@section('Reception')
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
        <a href="{{route('newReception')}}" class="btn btn-primary col-md-2">Ajouter</a>
    </div>
    <div class="mt-4 card col-md-12">
            <div class="card-header">
                <p class="font-weight-bold">Liste bons de reception</p>
            </div>
            <div class="m-4 card-body">
                <table id="Reception" class="display">
                    <thead>
                        <tr>
                            <th>Réf</th>
                            <th>Agence</th>
                            <th>Pour</th>
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
                            <td></td>
                            <td></td>
                            <td>{{$item->created_at}}</td>
                            <td>
                                @if ($item->etat_r == 'Enregistré')
                                {{$item->updated_at}}
                                @endif
                            </td>
                            <td>{{$item->etat_r}}</td>
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
                                <form action="{{route('editReception')}}" method="get">
                                    @csrf
                                    <input type="hidden" name="bon_id" value="{{$item->id}}">
                                    <button type="submit" class="btn btn-light"><i class="fas fa-edit"></i></button>
                                </form>
                                @if ($item->etat_r == 'Nouveau')
                                    <form action="{{route('valider')}}" method="post">
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
            $('#Reception').DataTable();
        });
    </script>
@endsection