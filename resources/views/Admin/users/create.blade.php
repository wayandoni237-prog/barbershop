<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add User</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin/users/create.css') }}">

</head>

<body class="d-flex justify-content-center align-items-center vh-100">

    <div class="container-box">

        <div style="width: 20%;" class="title-badge">Tambah User</div>

        @if($errors->any())
        <div class="alert alert-danger user-header">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{route('users.store')}}">
            @csrf

            <div class="mb-3">
                <input type="text" name="nama" class="form-control custom-input" placeholder="nama">
            </div>

            <div class="mb-3">
                <input type="text" name="username" class="form-control custom-input" placeholder="Username">
            </div>

            <div class="mb-3">
                <input type="password" name="password" class="form-control custom-input" placeholder="Password">
            </div>

            <div class="mb-3">
                <input type="password" name="password_confirmation" class="form-control custom-input" placeholder="Konfirmasi Password">
            </div>

            <div class="mb-3">
                <input type="email" name="email" class="form-control custom-input" placeholder="Email">
            </div>

            <div class="mb-4">
                <select id="role" name="role" class="form-select custom-input role-select">
                    <option value="" selected disabled>Pilih Role</option>
                    <option value="admin">Admin</option>
                    <option value="kasir">Kasir</option>
                    <option value="customer">Customer</option>
                </select>
            </div>

            <div id="customerForm" style="display:none;">

                <div class="mb-3">
                    <label>No HP</label>
                    <input class="form-control custom-input" type="text" name="no_hp" placeholder="Nomor HP">
                </div>

                <div class="mb-3">
                    <label>Alamat</label>
                    <input class="form-control custom-input" type="text" name="alamat" placeholder="Alamat">
                </div>

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

<script>
    document.getElementById('role').addEventListener('change', function() {

        let role = this.value
        let customerForm = document.getElementById('customerForm')

        if (role === 'customer' || role === 'kasir') {
            customerForm.style.display = 'block'
        } else {
            customerForm.style.display = 'none'
        }

    });
</script>

</html>