
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin/users/create.css') }}">

</head>

<body class="d-flex justify-content-center align-items-center vh-100">

<div class="container-box">

    <div class="title-badge">Edit User</div>

        @if($errors->any())
        <div class="alert alert-danger user-header">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
        @endif

    <form method="POST" action="{{route('users.update', $user->id)}}">
            @csrf
            @method('PUT')

        <div class="mb-3">
            <input type="text" name="username" value="{{$user->username}}" class="form-control custom-input" placeholder="Username">
        </div>

        <div class="mb-3">
            <input type="password" name="password" value="{{$user->password}}" class="form-control custom-input" placeholder="Password">
        </div>

        <div class="mb-3">
            <input type="email" name="email" value="{{$user->email}}" class="form-control custom-input" placeholder="Email">
        </div>

        <div class="mb-4">
            <select name="role" class="form-select custom-input role-select">
                <option selected disabled>Role</option>
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="kasir" {{ $user->role == 'kasir' ? 'selected' : '' }}>Kasir</option>
                <option value="customer" {{ $user->role == 'customer' ? 'selected' : '' }}>Customer</option>
            </select>
        </div>

        <div class="row">
            <div class="col-md-6">
                <a class="btn btn-cancel w-100" href="{{route('users.index')}}">Cancel</a>
            </div>

            <div class="col-md-6">
                <button type="submit" class="btn btn-save w-100">Save</button>
            </div>
        </div>

    </form>

</div>

</body>
</html>