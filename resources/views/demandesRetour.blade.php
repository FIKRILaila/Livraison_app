@extends('adminLte.dashboard')
@section('demandesRetour')
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
            Nouvelle Demande
        </button>
        </p>
        <div class="collapse" id="collapseExample">
        <div class="card card-body">
            <form action="{{route('newDemande')}}" method="post">
                @csrf
                <input type="hidden" name="type" value="Retour">
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
            <h4 class="font-weight-bold m-2">Liste des demandes de retour</h4>
        </div>
        <div class="card-body">
            <table id="demandes" class="display">
                <thead>
                    <tr>
                        @if (Auth::user()->role == 'admin')
                        <th>Message</th>
                        <th>Par</th>
                        <th>Date</th>
                        <th>Actions</th>
                        @endif

                        @if (Auth::user()->role == 'client')
                        <th>Message</th>
                        <th>Date</th>
                        <th>Etat</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($demandes as $demande) 
                    <tr>
                        @if (Auth::user()->role == 'admin')
                        <td>{{ $demande->message }}</td>
                        <td>{{ $demande->nomComplet }}</td>
                        <td>{{$demande->created_at}}</td>
                        <td>
                            <form action="{{route('TraiterDemande')}}" method="post">
                                @csrf
                                <input type="hidden" name="demande_id" value="{{$demande->id}}">
                                <button type="submit" class="btn btn-success">traiter</button>
                            </form>
                        </td>
                        @endif

                        @if (Auth::user()->role == 'client')
                        <td>{{ $demande->message }}</td>
                        <td>{{$demande->created_at}}</td>
                        <td>
                            @if ($demande->traiter)
                                <p class="text-success">Déja Traiter</p>
                            @else
                                <p class="text-danger">En cours de traitement</p>
                            @endif
                        </td>
                        @endif
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