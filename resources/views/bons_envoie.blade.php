@extends('adminLte.dashboard')
@section('bon_envoie')
active
@endsection
@section('bonenvoie')
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
@endsection
@section('script')
<script>
</script>
@endsection

