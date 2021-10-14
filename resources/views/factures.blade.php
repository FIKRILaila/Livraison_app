@extends('adminLte.dashboard')
{{-- @extends('layouts.app') --}}
@section('factures')
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
        <div class="m-4">
            <form action="{{route('filtreColisFacture')}}" method="post" class="row">
                @csrf
                <div class="row col-md-10">
                    <label for="client_id" class="text-right col-md-2 col-form-label">{{ __('Nom de Magasin :') }}</label>
                    <select name="client_id" id="client_id" class="col-md-10 form-control " value="{{ old('client_id') }}" required  autofocus autocomplete="on">
                        <option value="magasin">Nom de Magasin</option>
                        @foreach ($clients as $c)
                            <option value="{{$c->id}}">{{$c->nomMagasin}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="d-flex justify-content-end ml-2">
                    <button type="submit" class="btn btn-info ">Filtrer</button>
                </div>
            </form>
        </div>
    </div>
    <div class="card mt-4">
        <div class="card-header">
            <h4 class="font-weight-bold m-2 text-info">Liste des Colis Non Facturé</h4>
        </div>
        <div class="card-body">
            <table id="attente" class="display">
                <thead>
                    <tr>
                        <th>Code Suivi</th>
                        <th>Date de creation</th>
                        <th>Téléphone</th>
                        <th>Nom du Magasin</th>
                        <th>Status</th>
                        <th>Ville</th>
                        <th>Prix</th>
                        <th>Etat</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($Attente as $item) 
                            <tr>
                                <td>{{$item->code}}</td>
                                <td>{{$item->created_at}}</td>
                                <td>{{$item->telephone}}</td>
                                <td>{{$item->nomMagasin}}</td>
                                <td>
                                    @if ($item->paye == false)
                                        Non Payé
                                    @else
                                        Payé
                                    @endif
                                </td>
                                <td>{{$item->ville}}</td>
                                <td>{{$item->prix}} DH</td>
                                <td>{{$item->etat}}</td>
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
            $('#attente').DataTable();
        });
    </script>
@endsection