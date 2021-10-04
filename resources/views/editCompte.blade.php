@extends('adminLte.dashboard')
@section('parametres')
    active
@endsection
@section('editCompte')
    active
@endsection
@section('style')
<style>
    #logo_info {
        border: 2px dashed gray;
        border-radius: 15px;
        background-size: cover;
        overflow: hidden;
        width: 50%;
    }
    #logo {
        opacity: 0;
        object-fit: cover;
        border-radius: 15px;
        background-color: transparent;
        background-position: center center;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    #image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>
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
    <div class="row justify-content-center mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Modifier Mon Compte') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{route('updateCompte')}}" enctype="multipart/form-data">
                        @csrf

                        @if (Auth::user()->role == 'admin')
                            <input type="hidden" name="role" value="admin"/>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="nomComplet" class="col-form-label">{{ __('Nom Complet :') }}</label>
                                    <div>
                                        <input id="nomComplet" type="text" class="form-control" name="nomComplet" value="{{Auth::user()->nomComplet}}" required autocomplete="on" autofocus>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="cin" class="col-form-label">{{ __('CIN :') }}</label>
                                    <div>
                                        <input id="cin" type="text" class="form-control" name="cin" value="{{Auth::user()->cin}}" required autocomplete="on" autofocus>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="email" class="col-form-label">{{ __('E-Mail :') }}</label>
                                    <div>
                                        <input id="email" type="email" class="form-control" name="email" value="{{Auth::user()->email}}" required autocomplete="email" autofocus>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="phone" class="col-form-label">{{ __('Télèphone :') }}</label>
                                    <div>
                                        <input id="phone" type="tel" class="form-control" name="phone" value="{{Auth::user()->phone}}" required autocomplete="on" autofocus>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="ancien" class="col-form-label">{{ __('L\'ancien Mot de passe :') }}</label>
                                    <div>
                                        <input id="ancien" type="password" class="form-control" name="ancien" required autocomplete="new-password">
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="password" class="col-form-label">{{ __('Le Nouveau Mot de passe :') }}</label>
                                    <div>
                                        <input id="password" type="password" class="form-control" name="password" required autocomplete="new-password">
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if (Auth::user()->role == 'client')
                            <input type="hidden" name="role" value="client"/>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="nomComplet" class="col-form-label">{{ __('Nom Complet :') }}</label>
                                    <div>
                                        <input id="nomComplet" type="text" class="form-control" name="nomComplet" value="{{Auth::user()->nomComplet}}" required autocomplete="on" autofocus>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="cin" class="col-form-label">{{ __('CIN :') }}</label>
                                    <div>
                                        <input id="cin" type="text" class="form-control" name="cin" value="{{Auth::user()->cin}}" required autocomplete="on" autofocus>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="email" class="col-form-label">{{ __('E-Mail :') }}</label>
                                    <div>
                                        <input id="email" type="email" class="form-control" name="email" value="{{Auth::user()->email}}" required autocomplete="email" autofocus>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="phone" class="col-form-label">{{ __('Télèphone :') }}</label>
                                    <div>
                                        <input id="phone" type="tel" class="form-control" name="phone" value="{{Auth::user()->phone}}" required autocomplete="on" autofocus>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="adresse" class="col-form-label">{{ __('Adresse :') }}</label>
                                    <div>
                                        <input id="adresse" type="text" class="form-control" name="adresse" value="{{Auth::user()->adresse}}" required autocomplete="on" autofocus>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="ancien" class="col-form-label">{{ __('L\'ancien Mot de passe :') }}</label>
                                    <div>
                                        <input id="ancien" type="password" class="form-control" name="ancien" required autocomplete="new-password">
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="password" class="col-form-label">{{ __('Le Nouveau Mot de passe :') }}</label>
                                    <div>
                                        <input id="password" type="password" class="form-control" name="password" required autocomplete="new-password">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="nomMagasin" class="col-form-label">{{ __('Nom de Magasin : ') }}</label>
                                    <div>
                                        <input id="nomMagasin" type="text" class="form-control" name="nomMagasin" value="{{Auth::user()->nomMagasin}}" required autocomplete="on" autofocus>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="image" class="col-form-label">{{ __('Choisire votre Logo :') }}</label>
                                    <div id="logo_info">
                                        <img id="image" src="/images/{{Auth::user()->logo}}" alt="le logo">
                                        <input id="logo" type="file" class="col-md-12 h-100" onchange="addImage(this)" name="logo"  value="{{Auth::user()->logo}}" @if (!Auth::user()->logo) required @endif autocomplete="on" autofocus >
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if (Auth::user()->role == 'livreur')
                            <input type="hidden" name="role" value="livreur"/>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="nomComplet" class="col-form-label">{{ __('Nom Complet :') }}</label>
                                    <div>
                                        <input id="nomComplet" type="text" class="form-control" name="nomComplet" value="{{Auth::user()->nomComplet}}" required autocomplete="on" autofocus>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="cin" class="col-form-label">{{ __('CIN :') }}</label>
                                    <div>
                                        <input id="cin" type="text" class="form-control" name="cin" value="{{Auth::user()->cin}}" required autocomplete="on" autofocus>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="email" class="col-form-label">{{ __('E-Mail :') }}</label>
                                    <div>
                                        <input id="email" type="email" class="form-control" name="email" value="{{Auth::user()->email}}" required autocomplete="email" autofocus>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="phone" class="col-form-label">{{ __('Télèphone :') }}</label>
                                    <div>
                                        <input id="phone" type="tel" class="form-control" name="phone" value="{{Auth::user()->phone}}" required autocomplete="on" autofocus>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="RIB" class="col-form-label">{{ __('RIB:') }}</label>
                                    <div>
                                        <input id="RIB" type="text" class="form-control" name="RIB" value="{{Auth::user()->RIB}}" required autocomplete="on" autofocus>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="ville_id" class="col-form-label">{{ __('Ville') }}</label>
                                    <div>
                                        <select name="ville_id" id="ville_id" class="form-control" required  autofocus autocomplete="on">
                                            @foreach ($villes as $v)     
                                                @if (Auth::user()->ville_id == $v->id)
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
                                        <input id="adresse" type="text" class="form-control" name="adresse" value="{{Auth::user()->adresse}}" required autocomplete="on" autofocus>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="ancien" class="col-form-label">{{ __('L\'ancien Mot de passe :') }}</label>
                                    <div>
                                        <input id="ancien" type="password" class="form-control" name="ancien" required autocomplete="new-password">
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="password" class="col-form-label">{{ __('Le Nouveau Mot de passe :') }}</label>
                                    <div>
                                        <input id="password" type="password" class="form-control" name="password" required autocomplete="new-password">
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="form-group mb-0">
                            <div class="col-md-6 offset-md-10">
                                <button type="submit" class="btn btn-primary ml-4">{{ __('Modifier') }}</button>
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
    function addImage(input){
        var file=$("input[type=file]").get(0).files[0];
        if(file){
          var reader = new FileReader();
          reader.onload = function(){
            $('#image').attr("src",reader.result);
            $('#logo').attr("value",reader.result);
          }
          reader.readAsDataURL(file);
        }
    }
</script>
@endsection