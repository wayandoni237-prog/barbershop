<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Service</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin/users/create.css') }}">

</head>

<body class="d-flex justify-content-center align-items-center vh-100">

    <div class="container-box">

        <div class="title-badge">Edit Service</div>

        @if($errors->any())
        <div class="alert alert-danger user-header">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('services.update', $service->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <input type="text" name="nama_service" value="{{ $service->nama_service }}" class="form-control custom-input" placeholder="nama service">
            </div>

            <div class="mb-3">
                <input type="number" name="harga" value="{{ $service->harga }}" class="form-control custom-input" placeholder="harga">
            </div>

            <div class="mb-3">
                <input type="number" name="estimasi_menit" value="{{ $service->estimasi_menit }}" class="form-control custom-input" placeholder="durasi">
            </div>

            <div class="mb-3">
                <select name="is_active" class="form-control custom-input">

                    <option value="1" {{$service->is_active == 1 ? 'selected' : ''}}>
                        Active
                    </option>

                    <option value="0" {{$service->is_active == 0 ? 'selected' : ''}}>
                        Inactive
                    </option>

                </select>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <a class="btn btn-cancel w-100" href="{{ route('services.index') }}">Cancel</a>
                </div>

                <div class="col-md-6">
                    <button type="submit" class="btn btn-save w-100">Save</button>
                </div>
            </div>

        </form>

    </div>

</body>

</html>