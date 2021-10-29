@extends('adminLte.dashboard')
@section('DistributionLivreur')
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
    <div class="mt-4 card col-md-12">
            <div class="card-header">
                <p class="font-weight-bold">Liste des bons de distribution</p>
            </div>
            <div class="m-4 card-body">
                <table id="Distribution" class="display">
                    <thead>
                        <tr>
                            <th>Réf</th>
                            <th>Date de création</th>
                            <th>Date d'enregistrement</th>
                            <th>Status</th>
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
                            <td class="d-flex">
                                <button type="button" class="btn btn-light" data-toggle="modal" data-target="{{'#model_'.$item->id}}">
                                    <i class="fas fa-info-circle"></i>
                                </button>
                                <div class="modal fade bd-example-modal-lg" id ="{{'model_'.$item->id}}"tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th scope="col">Code Barre</th>
                                                <th scope="col">Destinataire</th>
                                                <th scope="col">Téléphone</th>
                                                <th scope="col">Etat</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($colis as $ele)
                                                @if ($ele->bon_id === $item->id)
                                                    <tr>
                                                        <td>
                                                            @php
                                                                echo $ele->code_bar."<span class=\"font-weight-bold\">".$ele->code."</span>";
                                                            @endphp
                                                        </td>
                                                        <td>{{$ele->destinataire }}</td>
                                                        <td>{{$ele->telephone }}</td>
                                                        <td>{{$ele->etat }}</td>
                                                    </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                </div>
                                
                                <form action="{{route('imprimerDistribution')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="bon" value="{{ $item->id }}">
                                    <button type ="submit" class="btn btn-light"><i class="fas fa-print"></i></button>
                                </form>
                            </td>
                        </tr>
                        {{-- @endif --}}
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