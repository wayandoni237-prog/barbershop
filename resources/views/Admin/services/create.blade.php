<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Service</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin/users/create.css') }}">

</head>

<body class="d-flex justify-content-center align-items-center vh-100">

    <div class="container-box">

        <div style="width: 23%;" class="title-badge">Tambah Service</div>

        @if($errors->any())
        <div class="alert alert-danger user-header">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('services.store') }}">
            @csrf

            <div class="mb-3">
                <input type="text" name="nama_service" class="form-control custom-input" placeholder="nama service" required>
            </div>

            <div class="mb-3">
                <input type="number" name="harga" class="form-control custom-input" placeholder="harga" required>
            </div>

            <div class="mb-3">
                <input type="number" name="estimasi_menit" class="form-control custom-input" placeholder="durasi" required>
            </div>


            <div class="row">
                <div class="col-md-6">
                    <a class="btn btn-cancel w-100" href="{{route('services.index')}}">Cancel</a>
                </div>

                <div class="col-md-6">
                    <button type="submit" class="btn btn-save w-100">Save</button>
                </div>
            </div>

        </form>

    </div>

</body>

</html>