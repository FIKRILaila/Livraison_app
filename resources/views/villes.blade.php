@extends('adminLte.dashboard')
@section('villes')
active
@endsection
@section('content')
<div class="container">
    <div class="col-md-12 d-flex justify-content-end mt-4 mb-4">
        <button type="button" class="btn btn-primary mr-2" data-toggle="modal" data-target="#region">
            Nouvelle région
        </button>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ville">
            Nouvelle ville
        </button>
    </div>
    <div class="col-md-12 mt-4 card">
      <div class="m-4">
      <table id="regions" class="display">
        <thead>
            <tr>
                <th>Région</th>
                <th>Ville</th>
                <th>Frais de Livraison (MAD)</th>
            </tr>
        </thead>
        <tbody>
          @foreach ($villes as $v)
            <tr>
              <td>
                @foreach ($regions as $r)
                @if ($r->id == $v->region_id)  
                  {{$r->region}}
                @endif
                @endforeach
              </td>
              <td>{{$v->ville}}</td>
              <td>{{$v->frais_livraison}}</td>
            </tr>
            @endforeach
        </tbody>
      </table>
    </div>
    </div>



  <!-- Region -->
  <div class="modal fade" id="region" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Nouvelle région</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{route('newRegion')}}" method="post" class="col-md-12">
            @csrf
            <div class="form-group">
                <label for="region" class="mb-2 col-form-label">{{ __('Nom de la Région') }}</label>
                <div>
                    <input id="region" type="text" class="form-control @error('region') is-invalid @enderror" name="region" value="{{ old('region') }}" required autocomplete="on">
                </div>
            </div>
            <div class="form-group mb-0 d-flex justify-content-end">
                <div class="mr-2">
                    <a href="{{route('villes')}}" class="btn btn-secondary">{{ __('Annuler') }}</a>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary">{{ __('Enregistrer') }}</button>
                </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Ville -->
  <div class="modal fade" id="ville" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Nouvelle Ville</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{route('newVille')}}" method="post" class="col-md-12">
                @csrf
                <div class="form-group">
                    <label for="ville" class="mb-2 col-form-label">{{ __('Nom de la Ville') }}</label>
                    <div>
                        <input id="ville" type="text" class="form-control @error('ville') is-invalid @enderror" name="ville" value="{{ old('ville') }}" required autocomplete="on">
                    </div>
                </div>
                <div class="form-group">
                    <label for="frais_livraison" class="mb-2 col-form-label">{{ __('Frais de Livraison') }}</label>
                    <div>
                        <input id="frais_livraison" type="number" min="1" class="form-control @error('prix') is-invalid @enderror" name="frais_livraison" value="{{ old('frais_livraison') }}" required autocomplete="on">
                    </div>
                </div>
                <div class="form-group">
                    <label for="region_id" class="mb-2 col-form-label">{{ __('Région') }}</label>
                    <div>
                        <select name="region_id" id="region_id" class="form-control @error('region_id') is-invalid @enderror" value="{{ old('region_id') }}" required  autofocus autocomplete="on">
                            <option value="">Région</option>
                            @foreach ($regions as $r)
                                <option value="{{$r->id}}">{{$r->region}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group mb-0 d-flex justify-content-end">
                    <div class="mr-2">
                        <a href="{{route('villes')}}" class="btn btn-secondary">{{ __('Annuler') }}</a>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary">{{ __('Enregistrer') }}</button>
                    </div>
                </div>
              </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
    <script>
        $(document).ready( function () {
          $('#regions').DataTable();
        });
    </script>
@endsection