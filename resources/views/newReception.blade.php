@extends('adminLte.dashboard')
@section('Reception')
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
        {{-- @foreach ($bon as $bon) --}}
        <p class="m-2"><span class="font-weight-bold">Date de Création :</span> {{$bon->created_at}} </p>
        {{-- @endforeach --}}
    </div>
    <div class="card">
        <div class="m-4">
            <form action="{{route('ReceptionCode')}}" method="post" class="row">
                @csrf
                <input type="hidden" name="bon_id" value="{{$bon->id}}">
                <div class="row col-md-10">
                    <label for="code_suivi" class="col-md-2 text-right col-form-label">Code Suivi * :</label>
                    <input type="text" name="code_suivi" class="form-control col-md-10">
                </div>
                <div class="row col-md-2 ml-2">
                    <button type="submit" class="btn btn-info">Ajouter</button>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="m-4">
            <table id="reception" class="display">
                <thead>
                    <tr>
                        <th>Code Suivi</th>
                        <th>Destinataire</th>
                        <th>Date de Création</th>
                        <th>Prix</th>
                        <th>Ville</th>
                        <th>Status</th>
                        <th><input type="checkbox"></th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @foreach ($lines as $line) --}}
                        {{-- @if ($line->bon_id == $bon->id)   --}}
                        @foreach ($colis as $coli)
                            {{-- @if ($line->colis_id == $coli->id) --}}
                            <tr>
                                <td>{{$coli->code}}</td>
                                <td>{{$coli->destinataire}}</td>
                                <td>{{$coli->created_at}}</td>
                                <td>{{$coli->prix}}</td>
                                <td>{{$coli->ville}}</td>
                                <td>{{$coli->etat}}</td>
                                <th><input type="checkbox"></th>
                            </tr>
                            {{-- @endif --}}
                        @endforeach
                        {{-- @endif --}}
                    {{-- @endforeach --}}

                    {{-- @foreach ($reception as $item)
                    @if ($item->bon === $bon->id) 
                    <tr>
                        <td>{{$item->code}}</td>
                        <td>{{$item->destinataire}}</td>
                        <td>{{$item->created_at}}</td>
                        <td>{{$item->prix}}</td>
                        <td>{{$item->ville}}</td>
                        <td>{{$item->etat}}</td>
                        <th><input type="checkbox"></th>
                    </tr>
                    @endif 
                    @endforeach --}}
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script>
        $(document).ready( function () {
            $('#reception').DataTable();
        });
    </script>
@endsection