@extends('adminLte.dashboard')
@section('users')
active
@endsection
@section('livreurs')
active
@endsection
@section('content')
<div class="container">
        @if (Session::get('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
        @endif
        @if (Session::get('fail'))
            <div class="alert alert-danger">{{ Session::get('fail') }}</div>
        @endif
        <div>
            <p class="row justify-content-end">
            <button class="btn btn-primary mt-4 mr-2" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                Nouveau
            </button>
            </p>
            <div class="collapse" id="collapseExample">
            <div class="card card-body">
                <form method="POST" action="{{ route('newLivreur') }}">
                    @csrf
                    <div class="form-group row">
                        <label for="nomComplet" class="col-md-4 col-form-label text-md-right">{{ __('Nom Complet') }}</label>

                        <div class="col-md-6">
                            <input id="nomComplet" type="text" class="form-control @error('nomComplet') is-invalid @enderror" name="nomComplet" value="{{ old('nomComplet') }}" required autocomplete="nomComplet" autofocus>

                            @error('nomComplet')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail') }}</label>
                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Phone') }}</label>

                        <div class="col-md-6">
                            <input id="phone" type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone">

                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Mot de passe') }}</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirmez le mot de passe') }}</label>

                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>

                    <div class="form-group row m-2">
                        <div class="col-md-6 offset-md-10">
                            <a href="{{route('livreurs')}}" class="btn btn-primary">Annuler</a>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </div>
                </form>            
            </div>
            </div>
        </div>


        <div class="mt-4 card col-md-12">
            <div class="m-4">
                <table id="users" class="display">
                    <thead>
                        <tr>
                            <th>Nom Complet</th>
                            <th>Téléphone</th>
                            {{-- <th>Role</th> --}}
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)       
                        <tr>
                            <td>{{$user->nomComplet}}</td>
                            <td>{{$user->phone}}</td>
                            {{-- <td>{{$user->role}}</td> --}}
                            <td><i class="fas fa-user-edit"></i></td>
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
            $('#users').DataTable();
        });
    </script>
@endsection