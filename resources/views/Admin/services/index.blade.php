@extends('layouts.appadmin')

@section('title', 'Admin Panel · Service data')
@section('page-title', 'Service data')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/users/index.css') }}">
@endpush

@section('content')

<div class="breadcrumb-panel">
    <i style="color:black;" class="bi bi-house-door"></i> Panel /
    <span style="font-weight:500; color:black;">Service data</span>
</div>

<div class="container-fluid p-0 mt-4">
    <div class="user-card">

        <div class="user-header">
            <h5>⚙️ Service data</h5>
            <button class="btn-add" data-bs-toggle="modal" data-bs-target="#createModal">
                add Services +
            </button>
        </div>

        @if(session('success'))
            <div class="user-header">
                <p class="alert alert-success">{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="user-header">
                <p class="alert alert-danger">{{ session('error') }}</p>
            </div>
        @endif

        <div class="table-wrapper">
        <table class="table table-borderless user-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Services name</th>
                    <th>Price</th>
                    <th>Duration</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($services as $service)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $service->nama_service }}</td>
                    <td>{{ number_format($service->harga, 0, ',', '.') }}</td>
                    <td>{{ $service->estimasi_menit }} Minute</td>
                    <td>
                        @if($service->is_active == 1)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <button class="btn-edit"
                                data-bs-toggle="modal"
                                data-bs-target="#editModal-{{ $service->id }}">
                                Edit
                            </button>

                        @if($service->is_active == 1)
                            <form id="inactive-form-{{ $service->id }}" action="{{ route('services.destroy', $service->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn-delete" type="button"
                                    onclick="confirmInactive('{{ $service->id }}')">
                                    Inactive
                                </button>
                            </form>

                        @else
                            <form id="active-form-{{ $service->id }}" action="{{ route('services.active', $service->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-success"  type="button"
                                    onclick="confirmActive('{{ $service->id }}')">
                                    activate
                                </button>
                            </form>
                        @endif
                        </div>
                    </td>
                </tr>

                {{-- MODAL EDIT per baris --}}
                <div class="modal fade" id="editModal-{{ $service->id }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered" style="max-width:420px;">
                        <div class="modal-content bg-dark text-white border-0">
                            <div class="modal-header border-0 pb-0">
                                <span style="background:#2b2b2b; color:#fff; padding:8px 14px; border-radius:12px; font-size:.88rem; font-weight:600;">
                                    Edit Service
                                </span>
                            </div>
                            <form method="POST" action="{{ route('services.update', $service->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="modal-body d-flex flex-column gap-3">
                                    <input type="text" name="nama_service"
                                           class="form-control custom-input"
                                           placeholder="Services name"
                                           value="{{ $service->nama_service }}">

                                    <input type="number" name="harga"
                                           class="form-control custom-input"
                                           placeholder="Price"
                                           value="{{ $service->harga }}">

                                    <input type="number" name="estimasi_menit"
                                           class="form-control custom-input"
                                           placeholder="Duration"
                                           value="{{ $service->estimasi_menit }}">

                                    <select name="is_active" class="form-control custom-input">
                                        <option value="1" {{ $service->is_active == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ $service->is_active == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                                <div class="modal-footer border-0 d-flex gap-2">
                                    <button type="button" class="btn flex-fill"
                                            style="background:#dc3545; color:#fff; font-weight:600; height:45px;"
                                            data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn flex-fill"
                                            style="background:#a7b27a; color:#fff; font-weight:600; height:45px;">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                @endforeach
            </tbody>
        </table>
        </div>

    </div>
</div>

{{-- MODAL CREATE --}}
<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width:420px;">
        <div class="modal-content bg-dark text-white border-0">
            <div class="modal-header border-0 pb-0">
                <span style="background:#2b2b2b; color:#fff; padding:8px 14px; border-radius:12px; font-size:.88rem; font-weight:600;">
                    Add Service
                </span>
            </div>
            <form method="POST" action="{{ route('services.store') }}">
                @csrf
                <div class="modal-body d-flex flex-column gap-3">
                    <input type="text"   name="nama_service"   class="form-control custom-input" placeholder="Services name" required>
                    <input type="number" name="harga"          class="form-control custom-input" placeholder="Price"        required>
                    <input type="number" name="estimasi_menit" class="form-control custom-input" placeholder="Duration"       required>
                </div>
                <div class="modal-footer border-0 d-flex gap-2">
                    <button type="button" class="btn flex-fill"
                            style="background:#dc3545; color:#fff; font-weight:600; height:45px;"
                            data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn flex-fill"
                            style="background:#a7b27a; color:#fff; font-weight:600; height:45px;">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection