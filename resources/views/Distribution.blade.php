@extends('adminLte.dashboard')
@section('Distribution')
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

    <div class="card mt-4">
        <div class="m-4">
            <form action="{{route('newDistribution')}}" method="post" class="row">
                @csrf
                <div class="row col-md-10">
                    <label for="region" class="text-right col-md-2 col-form-label">{{ __('Region :') }}</label>
                    <select name="region" id="region" class="col-md-10 form-control @error('region') is-invalid @enderror" value="{{ old('region') }}" required  autofocus autocomplete="on">
                        <option value="region">region</option>
                        @foreach ($regions as $r)     
                            <option value="{{$r->region}}">{{$r->region}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="row justify-content-end col-md-2 ml-2">
                    <a href="#" class="btn btn-primary mr-2">Annuler</a>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="mt-4 card col-md-12">
            <div class="card-header">
                <p class="font-weight-bold">Liste des bons de distribution</p>
            </div>
            <div class="m-4 card-body">
                <table id="Distribution" class="display">
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
                            <td class="row">
                                @if ($item->etat == 'Nouveau')
                                <form action="{{route('editDistribution')}}" method="get">
                                    @csrf
                                    <input type="hidden" name="bon_id" value="{{$item->id}}">
                                    <button type="submit" class="btn btn-light"><i class="fas fa-edit"></i></button>
                                </form>
                                    <form action="{{route('distributionValider')}}" method="post">
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
            $('#Distribution').DataTable();
        });
    </script>
@endsection