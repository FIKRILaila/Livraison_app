@extends('adminLte.dashboard')
{{-- @extends('layouts.app') --}}
@section('home')
active
@endsection
@section('content')
<div class="m-4">
    
        {{-- tous les colis --}}
        @php
        $livre = 0;
        $Retourné = 0;
        $Refusé = 0;
        $en_cours = 0;
        $Annulé = 0;
        $nbr = 0;
        $total_colis = 0;
        @endphp
        @foreach ($colis as $col)
            @php $total_colis++; @endphp
            @if($col->etat == "Livré") @php $livre++; $nbr++; @endphp @endif
            @if($col->etat == "Retourné") @php $Retourné++; @endphp @endif
            @if($col->etat == "Annulé") @php $Annulé++; @endphp @endif
            @if($col->etat == "Refusé") @php $Refusé++; @endphp @endif
            @if($col->etat == "En Attente de Ramassage" or $col->etat == "Reçu" or $col->etat == "Ramasse" or $col->etat == "En Distribution" or $col->etat == "Expedié") @php $en_cours++; @endphp @endif
        @endforeach
        <div class="text-success p-2 col-md-12 text-center m-4 rounded border border-success border-5">
            <h1 class="font-weight-bold" class="fs-1">@php echo $pourcentage = ($nbr *100)/$total_colis @endphp %
            </h1>
            <p>Taux de livraison</p>
        </div>
        <div class="row">
        <div class="col-md-6">
            <div class="card m-2">
                <div class="card-header font-weight-bold" style="font-size:30px;">
                    Statistique de Colis
                </div>
                <div class="row">
                    <div class="bg-success p-2 m-4 col-md-3  rounded m-2">
                        <h1 class="font-weight-bold">@php echo $livre @endphp</h1>
                        <p>Livré</p>
                    </div>
                    <div class="bg-info p-2 col-md-3  m-4 rounded m-2">
                        <h1 class="font-weight-bold">@php echo $Retourné @endphp</h1>
                        <p> Retourné</p>
                    </div>
                    <div class="bg-danger p-2 col-md-3 m-4 rounded m-2">
                        <h1 class="font-weight-bold">@php echo $Refusé @endphp</h1>
                        <p>Refusé</p>
                    </div>
                    <div class="bg-warning p-2 col-md-3  m-4 rounded m-2">
                        <h1 class="font-weight-bold">@php echo $Annulé @endphp</h1>
                        <p>Annulé</p>
                    </div>
                    <div class="bg-primary p-2 col-md-3 m-4 rounded m-2">
                        <h1 class="font-weight-bold">@php echo $en_cours @endphp</h1>
                        <p>En cours</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- colis par jour --}}
        @php
        $livre_jour = 0;
        $Retourné_jour = 0;
        $Refusé_jour = 0;
        $en_cours_jour = 0;
        $Annulé_jour = 0;
        @endphp
        @foreach ($parjour as $col)
            @if($col->etat == "Livré") @php $livre_jour++; @endphp @endif
            @if($col->etat == "Retourné") @php $Retourné_jour++; @endphp @endif
            @if($col->etat == "Annulé") @php $Annulé_jour++; @endphp @endif
            @if($col->etat == "Refusé") @php $Refusé_jour++; @endphp @endif
            @if($col->etat == "En Attente de Ramassage" or $col->etat == "Reçu" or $col->etat == "Ramasse" or $col->etat == "En Distribution" or $col->etat == "Expedié") @php $en_cours_jour++; @endphp @endif
        @endforeach
        <div class="col-md-6">
            <div class="card m-2">
            <div class="card-header font-weight-bold " style="font-size:30px;">
                Statistique de Colis par Jour : @php echo $jour = date("Y-m-d",time()) @endphp
            </div>
            <div class="row">
                <div class="border border-success border-5 text-success font-weight-bold p-2 m-4 col-md-3  rounded m-2">
                    <h1 class="font-weight-bold">@php echo $livre_jour @endphp</h1>
                    <p>Livré</p>
                </div>
                <div class="border border-info border-5 text-info p-2 font-weight-bold col-md-3  m-4 rounded m-2">
                    <h1 class="font-weight-bold">@php echo $Retourné_jour @endphp</h1>
                    <p> Retourné</p>
                </div>
                <div class="border border-danger border-5 text-danger font-weight-bold p-2 col-md-3 m-4 rounded m-2">
                    <h1 class="font-weight-bold">@php echo $Refusé_jour @endphp</h1>
                    <p>Refusé</p>
                </div>
                <div class="border border-warning border-5 text-warning font-weight-bold p-2 col-md-3  m-4 rounded m-2">
                    <h1 class="font-weight-bold">@php echo $Annulé_jour @endphp</h1>
                    <p>Annulé</p>
                </div>
                <div class="border border-primary border-5 text-primary font-weight-bold p-2 col-md-3 m-4 rounded m-2">
                    <h1 class="font-weight-bold">@php echo $en_cours_jour @endphp</h1>
                    <p>En cours</p>
                </div>
            </div>
            </div>
        </div>
    </div>
    <div class="row">
        
    {{-- colis par mois --}}
    @php
    $livre_mois = 0;
    $Retourné_mois = 0;
    $Refusé_mois= 0;
    $en_cours_mois = 0;
    $Annulé_mois = 0;
    @endphp
    @foreach ($parmois as $col)
        @if($col->etat == "Livré") @php $livre_mois++; @endphp @endif
        @if($col->etat == "Retourné") @php $Retourné_mois++; @endphp @endif
        @if($col->etat == "Annulé") @php $Annulé_mois++; @endphp @endif
        @if($col->etat == "Refusé") @php $Refusé_mois++; @endphp @endif
        @if($col->etat == "En Attente de Ramassage" or $col->etat == "Reçu" or $col->etat == "Ramasse" or $col->etat == "En Distribution" or $col->etat == "Expedié") @php $en_cours_mois++; @endphp @endif
    @endforeach
    <div class="col-md-6">
        <div class="card m-2">
        <div class="card-header font-weight-bold" style="font-size:30px;">
            Statistique de Colis par Mois : @php echo $mois = date("m",time()) @endphp
        </div>
        <div class="row">
            <div class="text-success font-weight-bold p-2 m-4 col-md-3  rounded m-2">
                <h1 class="font-weight-bold">@php echo $livre_mois @endphp</h1>
                <p>Livré</p>
            </div>
            <div class="text-info font-weight-bold p-2 col-md-3  m-4 rounded m-2">
                <h1 class="font-weight-bold">@php echo $Retourné_mois @endphp</h1>
                <p> Retourné</p>
            </div>
            <div class="text-danger font-weight-bold p-2 col-md-3 m-4 rounded m-2">
                <h1 class="font-weight-bold">@php echo $Refusé_mois @endphp</h1>
                <p>Refusé</p>
            </div>
            <div class="text-warning font-weight-bold p-2 col-md-3  m-4 rounded m-2">
                <h1 class="font-weight-bold">@php echo $Annulé_mois @endphp</h1>
                <p>Annulé</p>
            </div>
            <div class="text-primary font-weight-bold p-2 col-md-3 m-4 rounded m-2">
                <h1 class="font-weight-bold">@php echo $en_cours_mois @endphp</h1>
                <p>En cours</p>
            </div>
        </div>
    </div>
    </div>
    {{-- colis par annee --}}
    @php
    $livre_annee = 0;
    $Retourné_annee = 0;
    $Refusé_annee= 0;
    $en_cours_annee = 0;
    $Annulé_annee = 0;
    @endphp
    @foreach ($parannee as $col)
        @if($col->etat == "Livré") @php $livre_annee++; @endphp @endif
        @if($col->etat == "Retourné") @php $Retourné_annee++; @endphp @endif
        @if($col->etat == "Annulé") @php $Annulé_annee++; @endphp @endif
        @if($col->etat == "Refusé") @php $Refusé_annee++; @endphp @endif
        @if($col->etat == "En Attente de Ramassage" or $col->etat == "Reçu" or $col->etat == "Ramasse" or $col->etat == "En Distribution" or $col->etat == "Expedié") @php $en_cours_annee++; @endphp @endif
    @endforeach
    <div class="col-md-6">
        <div class="card m-2">
        <div class="card-header font-weight-bold" style="font-size:30px;">
            Statistique de Colis par Année : @php echo $annee = date("Y",time()) @endphp
        </div>
        <div class="row">
            <div class="bg-success p-2 m-4 col-md-3  rounded m-2">
                <h1 class="font-weight-bold">@php echo $livre_annee @endphp</h1>
                <p>Livré</p>
            </div>
            <div class="bg-info p-2 col-md-3  m-4 rounded m-2">
                <h1 class="font-weight-bold">@php echo $Retourné_annee @endphp</h1>
                <p> Retourné</p>
            </div>
            <div class="bg-danger p-2 col-md-3 m-4 rounded m-2">
                <h1 class="font-weight-bold">@php echo $Refusé_annee @endphp</h1>
                <p>Refusé</p>
            </div>
            <div class="bg-warning p-2 col-md-3  m-4 rounded m-2">
                <h1 class="font-weight-bold">@php echo $Annulé_annee @endphp</h1>
                <p>Annulé</p>
            </div>
            <div class="bg-primary p-2 col-md-3 m-4 rounded m-2">
                <h1 class="font-weight-bold">@php echo $en_cours_annee @endphp</h1>
                <p>En cours</p>
            </div>
        </div>
    </div>
    </div>
</div>
</div>
@endsection
