@extends('adminLte.dashboard')
@section('admins')
active
@endsection
@section('users')
active
@endsection
@section('content')
    <div class="container">
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