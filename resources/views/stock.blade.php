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
    <h1 class="text-center m-4">Gestion de Stock</h1>
    <div class="col-md-12 card">
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
              <tr>
                <td>Article</td>
                <td>Type d'Article</td>
                <td>Quantité</td>
              </tr>
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