@extends('adminLte.dashboard')
{{-- @extends('layouts.app') --}}
@section('stock')
active
@endsection
@section('article')
active
@endsection
@section('content')
<div class="container">
    <h1 class=" m-4">Nouveau Article</h1>
    <div class="card">
        <div class="m-4">
            <form action="" method="post" class="col-md-12">
                @csrf
                <div class="form-group">
                    <label for="name" class="mb-2 col-form-label">{{ __('Article') }}</label>
                    <div>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="on">
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="mb-2 col-form-label">{{ __('Type d\'Article') }}</label>
                    <div>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="on">
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


