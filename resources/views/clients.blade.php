@extends('adminLte.dashboard')
@section('users')
active
@endsection
@section('clients')
active
@endsection
@section('content')
    <div class="container">
        <div>
            <p>
            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                Nouveau
            </button>
            </p>
            <div class="collapse" id="collapseExample">
            <div class="card card-body">
                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
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
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)       
                        <tr>
                            <td>{{$user->nomComplet}}</td>
                            <td>{{$user->phone}}</td>
                            <td>{{$user->role}}</td>
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