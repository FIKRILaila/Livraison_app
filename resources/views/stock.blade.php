@extends('adminLte.dashboard')
{{-- @extends('layouts.app') --}}
@section('stock')
active
@endsection
@section('stock_actu')
active
@endsection
@section('content')
<div class="container">
    <h1 class="mt-4">Stock Actuel</h1>
    <div class="col-md-12 mt-4 card">
        <div class="m-4">
        <table id="stock" class="display">
          <thead>
              <tr>
                  <th>Article</th>
                  <th>Type d'Article</th>
                  <th>Quantité</th>
              </tr>
          </thead>
          <tbody>
            @foreach ($stock as $s)   
              <tr>
                <td>{{$s->name}}</td>
                <td>{{$s->type}}</td>
                <td>{{$s->quantite}}</td>
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
          $('#stock').DataTable();
        });
    </script>
@endsection