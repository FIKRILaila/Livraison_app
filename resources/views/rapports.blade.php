@extends('adminLte.dashboard')
@section('rapports')
    active
@endsection
@section('content')
    <div class="m-4">
        <div class="card mt-4">
            <div class="card-header">
                <h4 class="font-weight-bold m-2 text-info">Liste des rapports bancaire</h4>
            </div>
            <div class="card-body">
                <table id="rapports" class="display">
                    <thead>
                        <tr>
                            <th>Réference</th>
                            <th>Date de création</th>
                            <th>Facture</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rapports as $item) 
                        <tr>
                            <td>{{ $item->reference }}</td>
                            <td>{{$item->created_at}}</td>
                            <td>
                                @php
                                $c = 0;
                                foreach ($lines as $line){
                                    if ($line->rapport_id == $item->id){
                                        $c++;
                                    }
                                }
                                echo $c;
                                @endphp
                            </td>
                            <td class="d-flex">
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
                                                    <th scope="col">Facture</th>
                                                    <th scope="col">Nom de Magasin</th>
                                                    <th scope="col">Montant</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($lines as $line)
                                                    @if ($line->rapport_id === $item->id)
                                                        <tr>
                                                            <td>{{$line->reference }}</td>
                                                            <td>{{$line->nomMagasin }}</td>
                                                            <td>{{$line->Montant }}</td>
                                                        </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <form action="{{route('imprimerRaport')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="rapport_id" value="{{ $item->id }}">
                                    <button type ="submit" class="btn btn-light"><i class="fas fa-print"></i></button>
                                </form>
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
        $('#rapports').DataTable();
    });
</script>
@endsection