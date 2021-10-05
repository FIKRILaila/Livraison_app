@extends('adminLte.dashboard')
@section('Reclamations')
active
@endsection
@section('demandes')
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

    @if (Auth::user()->role == 'client')
    <div>
        <p class="row justify-content-end">
        <button class="btn btn-info mt-4 mr-2" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
            Nouvelle Réclamation
        </button>
        </p>
        <div class="collapse" id="collapseExample">
        <div class="card card-body">
            <form action="{{route('newDemande')}}" method="post">
                @csrf
                <input type="hidden" name="type" value="Reclamation">
                <div class="form-group">
                    <label for="message"> Message : </label>
                    <textarea name="message" id="message" class="form-control" cols="30" rows="5"></textarea>
                </div>
                <div class="row justify-content-end">
                    <button type="submit" class="btn btn-info">Envoyer</button>
                </div>
            </form>         
        </div>
        </div>
    </div>
    @endif
    <div class="card mt-4">
        <div class="card-header">
            <h4 class="font-weight-bold m-2">Liste des Réclamations</h4>
        </div>
        <div class="card-body">
            <table id="demandes" class="display">
                <thead>
                    <tr>
                        @if (Auth::user()->role == 'admin')
                        <th>type</th>
                        <th>Par</th>
                        <th>Date</th>
                        <th>Actions</th>
                        @endif

                        @if (Auth::user()->role == 'client')
                        <th>type</th>
                        <th>Date</th>
                        <th>Etat</th>
                        <th>Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($demandes as $demande) 
                    <tr>
                        @if (Auth::user()->role == 'admin')
                        <td>Reclamation</td>
                        <td>{{ $demande->nomComplet }}</td>
                        <td>{{$demande->created_at}}</td>
                        @endif
                        @if (Auth::user()->role == 'client')
                        <td>Reclamation</td>
                        <td>{{$demande->created_at}}</td>
                        <td>
                            @if ($demande->traiter)
                                <p class="text-success font-weight-bold">Déja Traiter</p>
                            @else
                                <p class="text-danger font-weight-bold">En cours de traitement</p>
                            @endif
                        </td>
                        @endif
                        <td class="d-flex">
                            @if (Auth::user()->role == 'admin')
                            <form action="{{route('TraiterDemande')}}" method="post">
                                @csrf
                                <input type="hidden" name="demande_id" value="{{$demande->id}}">
                                <button type="submit" class="btn btn-success"><i class="fas fa-check"></i></button>
                            </form>
                            @endif
                            <button type="button" class="btn btn-light" data-toggle="modal" data-target="{{'#model_'.$demande->id}}">
                                <i class="fas fa-info-circle"></i>
                            </button>
                            <div class="modal fade" id="{{'model_'.$demande->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle ">Reclamation @if (Auth::user()->role == 'admin') par : {{ $demande->nomComplet }} @endif</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        <p><span class="font-weight-bold">Message :</span><br>{{$demande->message}}</p>
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
            $('#demandes').DataTable();
        });
    </script>
@endsection