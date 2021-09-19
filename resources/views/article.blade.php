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
    @if (Session::get('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
            @endif
            @if (Session::get('fail'))
                <div class="alert alert-danger">{{ Session::get('fail') }}</div>
            @endif
    <div class="card">
        <div class="m-4">
            <form action="{{route('storeArticle')}}" method="post" class="col-md-12">
                @csrf
                <div class="form-group">
                    <label for="name" class="mb-2 col-form-label">{{ __('Article') }}</label>
                    <div>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="on">
                    </div>
                </div>
                <div class="form-group">
                    <label for="type" class="mb-2 col-form-label">{{ __('Type d\'Article') }}</label>
                    <div>
                        <input id="type" type="text" class="form-control @error('type') is-invalid @enderror" name="type" value="{{ old('type') }}" required autocomplete="on">
                    </div>
                </div>
                <div class="form-group mt-4 mb-0 d-flex justify-content-end">
                    <div class="mr-2">
                        <a href="{{route('article')}}" class="btn btn-secondary">{{ __('Annuler') }}</a>
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


