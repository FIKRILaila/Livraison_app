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
                            <td class="d-flex">
                                @if ($item->etat == 'Nouveau')
                                <form action="{{route('editReception')}}" method="get">
                                    @csrf
                                    <input type="hidden" name="bon_id" value="{{$item->id}}">
                                    <button type="submit" class="btn btn-light"><i class="fas fa-edit"></i></button>
                                </form>
                                    <form action="{{route('receptionValider')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="bon_id" value="{{$item->id}}">
                                        <button type = "submit" class="btn btn-light"><i class="fas fa-check"></i></button>
                                    </form>
                                @endif
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
                                                    <th scope="col">#</th>
                                                    <th scope="col">Destinataire</th>
                                                    <th scope="col">Téléphone</th>
                                                    <th scope="col">Code Barre</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($colis as $ele)
                                                    @if ($ele->bon_id === $item->id)
                                                        <tr>
                                                            <th scope="row">{{ $ele->bon }}</th>
                                                            <td>{{$ele->destinataire }}</td>
                                                            <td>{{$ele->telephone }}</td>
                                                            <td>
                                                                @php
                                                                    echo $ele->code_bar."<span class=\"font-weight-bold\">".$ele->code."</span>";
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
                                </div>
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