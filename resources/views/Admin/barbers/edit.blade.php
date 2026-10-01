
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Barber</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin/users/create.css') }}">

</head>

<body class="d-flex justify-content-center align-items-center vh-100">

<div class="container-box">

    <div class="title-badge">Edit Barber</div>

        @if($errors->any())
        <div class="alert alert-danger user-header">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
        @endif

    <form method="POST" enctype="multipart/form-data" action="{{route('barbers.update', $barber->id)}}">
            @csrf
            @method('PUT')

        <div class="mb-3">
            <input type="text" name="nama" value="{{$barber->nama}}" class="form-control custom-input" placeholder="Nama">
        </div>

        <div class="mb-3">
            <input type="text" name="no_hp" value="{{$barber->no_hp}}" class="form-control custom-input" placeholder="No Telp">
        </div>

        <div class="mb-3">
            <input type="text" name="alamat" value="{{$barber->alamat}}" class="form-control custom-input" placeholder="Alamat">
        </div>

        <div class="mb-3">
            <input type="file" name="image" class="form-control custom-input" placeholder="Gambar">
        </div>

        <div class="row">
            <div class="col-md-6">
                <a class="btn btn-cancel w-100" href="{{route('barbers.index')}}">Cancel</a>
            </div>

            <div class="col-md-6">
                <button type="submit" class="btn btn-save w-100">Save</button>
            </div>
        </div>

    </form>

</div>

</body>
</html>