@extends('adminLte.dashboard')
@section('livraison')
active
@endsection
@section('content')

@if (Auth::user()->role == 'client')
<div class="m-4">
    <div class="mt-4 card col-md-12">
            <div class="m-4">
                <table id="livraison" class="display">
                    <thead>
                        <tr>
                            {{-- <th>#</th> --}}
                            <th>Reference</th>
                            <th>Date</th>
                            <th>Colis</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bons as $item) 
                        @if ($item->client_id === Auth::user()->id)
                        <tr>
                            {{-- <td>{{ $item->id }}</td> --}}
                            <td>{{$item->ref}}</td>
                            <td>{{$item->created_at}}</td>
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
                                <button type="button" class="btn btn-light" data-toggle="modal" data-target="{{'#model_'.$item->id}}">
                                    <i class="fas fa-info-circle"></i>
                                </button>
                                <form action="{{route('imprimer')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="bon" value="{{ $item->id }}">
                                    <button type ="submit" class="btn btn-light"><i class="fas fa-print"></i></button>
                                </form>
                                 <!-- Details de bon -->
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
                                                    {{-- <th scope="col">#</th> --}}
                                                    <th scope="col">Destinataire</th>
                                                    <th scope="col">Téléphone</th>
                                                    <th scope="col">Etat</th>
                                                    <th scope="col">Code Barre</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($colis as $ele)
                                                    @if ($ele->client_id === Auth::user()->id)
                                                    @if ($ele->bon_id === $item->id)
                                                        <tr>
                                                            {{-- <th scope="row">{{ $ele->bon }}</th> --}}
                                                            <td>{{$ele->destinataire }}</td>
                                                            <td>{{$ele->telephone }}</td>
                                                            <td>{{$ele->etat}}</td>
                                                            <td>
                                                                @php
                                                                    echo $ele->code_bar."<span class=\"font-weight-bold\">".$ele->code."</span>";
                                                                @endphp
                                                            </td>
                                                                {{-- @if ($ele->val == false)
                                                                    <button class="btn-success btn">Valider</button>
                                                                @else
                                                                    echo "Déjà valider"
                                                                @endif --}}
                                                            {{-- </td> --}}
                                                        </tr>
                                                    @endif
                                                    @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <form action="{{route('stickers')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="bon" value="{{ $item->id }}">
                                    <button type ="submit" class="btn btn-light"><i class="fas fa-ticket-alt"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif

@if (Auth::user()->role == 'admin')
<div class="m-4">
    <div class="mt-4 card col-md-12">
            <div class="m-4">
                <table id="livraison" class="display">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Reference</th>
                            <th>Date</th>
                            <th>Colis</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bons as $item) 
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{$item->ref}}</td>
                            <td>{{$item->created_at}}</td>
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
                                <button type="button" class="btn btn-light" data-toggle="modal" data-target="{{'#model_'.$item->id}}">
                                    <i class="fas fa-info-circle"></i>
                                </button>
                                <form action="{{route('imprimer')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="bon" value="{{ $item->id }}">
                                    <button type ="submit" class="btn btn-light"><i class="fas fa-print"></i></button>
                                </form>
                                 <!-- Details de bon -->
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
                                <form action="{{route('stickers')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="bon" value="{{ $item->id }}">
                                    <button type ="submit" class="btn btn-light"><i class="fas fa-ticket-alt"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>  
@endif
@endsection

@section('script')
    <script>
        $(document).ready( function () {
            $('#livraison').DataTable();
        });
    </script>
@endsection