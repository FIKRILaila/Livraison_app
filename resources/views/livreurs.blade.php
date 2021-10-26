@extends('adminLte.dashboard')
@section('users')
active
@endsection
@section('livreurs')
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
        <div>
            <p class="row justify-content-end">
            <button class="btn btn-info mt-4 mr-2" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
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
                        <label for="commission" class="col-md-4 col-form-label text-md-right">{{ __('Commission') }}</label>

                        <div class="col-md-6">
                            <input id="commission" type="number" class="form-control" name="commission" value="{{ old('commission') }}" required autocomplete="on">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="ville_id" class="col-md-4 col-form-label text-md-right">{{ __('Ville') }}</label>
                        <div class="col-md-6">
                            <select name="ville_id" id="ville_id" class="form-control @error('ville_id') is-invalid @enderror" value="{{ old('ville_id') }}" required  autofocus autocomplete="on">
                                <option value="">Ville</option>
                                @foreach ($villes as $v)     
                                    <option value="{{$v->id}}">{{$v->ville}}</option>
                                @endforeach
                            </select>
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
                            <a href="{{route('livreurs')}}" class="btn btn-secondary">Annuler</a>
                            <button type="submit" class="btn btn-info">Enregistrer</button>
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
                            <th>Ville</th>
                            <th>Commission</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)       
                        <tr>
                            <td>{{$user->nomComplet}}</td>
                            <td>{{$user->phone}}</td>
                            <td>{{$user->ville}}</td>
                            <td>{{$user->commission}}</td>
                            <td>
                                <button type="button" class="btn btn-light" data-toggle="modal" data-target="{{'#edit_'.$user->id}}"><i class="fas fa-user-edit"></i></button>
                                <div class="modal fade" id="{{'edit_'.$user->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="m-4">
                                                <form method="POST" action="{{route('updateCompte')}}" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="admin" value="oui">
                                                    <input type="hidden" name="user_id" value="{{$user->id}}">
                                                    <input type="hidden" name="role" value="livreur"/>
                                                    <div class="row">
                                                        <div class="form-group col-md-6">
                                                            <label for="nomComplet" class="col-form-label">{{ __('Nom Complet :') }}</label>
                                                            <div>
                                                                <input id="nomComplet" type="text" class="form-control" name="nomComplet" value="{{$user->nomComplet}}" required autocomplete="on" autofocus>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="cin" class="col-form-label">{{ __('CIN :') }}</label>
                                                            <div>
                                                                <input id="cin" type="text" class="form-control" name="cin" value="{{$user->cin}}" required autocomplete="on" autofocus>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-md-6">
                                                            <label for="email" class="col-form-label">{{ __('E-Mail :') }}</label>
                                                            <div>
                                                                <input id="email" type="email" class="form-control" name="email" value="{{$user->email}}" required autocomplete="email" autofocus>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="phone" class="col-form-label">{{ __('Télèphone :') }}</label>
                                                            <div>
                                                                <input id="phone" type="tel" class="form-control" name="phone" value="{{$user->phone}}" required autocomplete="on" autofocus>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-md-6">
                                                            <label for="RIB" class="col-form-label">{{ __('RIB:') }}</label>
                                                            <div>
                                                                <input id="RIB" type="text" class="form-control" name="RIB" value="{{$user->RIB}}" required autocomplete="on" autofocus>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="ville_id" class="col-form-label">{{ __('Ville') }}</label>
                                                            <div>
                                                                <select name="ville_id" id="ville_id" class="form-control" required  autofocus autocomplete="on">
                                                                    @foreach ($villes as $v)     
                                                                        @if ($user->ville_id == $v->id)
                                                                        <option value="{{$v->id}}">{{$v->ville}}</option>
                                                                        @endif
                                                                    @endforeach
                                                                    @foreach ($villes as $v)     
                                                                        <option value="{{$v->id}}">{{$v->ville}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-md-12">
                                                            <label for="adresse" class="col-form-label">{{ __('Adresse :') }}</label>
                                                            <div>
                                                                <input id="adresse" type="text" class="form-control" name="adresse" value="{{$user->adresse}}" required autocomplete="on" autofocus>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-md-12">
                                                            <label for="password" class="col-form-label">{{ __('Mot de passe :') }}</label>
                                                            <div>
                                                                <input id="password" type="password" class="form-control" name="password" required autocomplete="new-password">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group d-flex justify-content-end">
                                                        <div class="mr-2">
                                                            <a href="{{route('livreurs')}}" class="btn btn-secondary">{{ __('Annuler') }}</a>
                                                        </div>
                                                        <div>
                                                            <button type="submit" class="btn btn-info">{{ __('Enregistrer') }}</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
            $('#users').DataTable();
        });
    </script>
@endsection