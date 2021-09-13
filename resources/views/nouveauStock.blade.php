@extends('adminLte.dashboard')
{{-- @extends('layouts.app') --}}
@section('stock')
active
@endsection
@section('nouveauStock')
active
@endsection
@section('content')
<div class="container">
    <h1 class=" m-4">Nouveau Stock</h1>
    <div class="card">
        <div class="m-4">
            <form action="" method="post" class="col-md-12">
                @csrf
                <div class="form-group">
                    <label for="region_id" class="mb-2 col-form-label">{{ __('Article') }}</label>
                    <div>
                        <select name="region_id" id="region_id" class="form-control @error('region_id') is-invalid @enderror" value="{{ old('region_id') }}" required  autofocus autocomplete="on">
                            <option value="">article</option>
                            <option value="">article</option>
                            <option value="">article</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="mb-2 col-form-label">{{ __('Quantité') }}</label>
                    <div>
                        <input id="name" type="number" min="1" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="on">
                    </div>
                </div>
                <div class="form-group mt-4 mb-0 d-flex justify-content-end">
                    <div class="mr-2">
                        <a href="#" class="btn btn-secondary">{{ __('Annuler') }}</a>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary">{{ __('Enregistrer') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
