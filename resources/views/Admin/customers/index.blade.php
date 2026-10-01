@extends('layouts.appadmin')

@section('title', 'Admin Panel · Customer data')
@section('page-title', 'Customer data')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/users/index.css') }}">
@endpush

@section('content')

<div class="breadcrumb-panel">
    <i style="color:black;" class="bi bi-house-door"></i> Panel /
    <span style="font-weight:500; color:black;">Customer's data</span>
</div>

<div class="container-fluid p-0 mt-4">
    <div class="user-card">
        <div class="user-header">
            <h5>👤 Customer's data</h5>
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
                        <th>Username</th>
                        <th>Address</th>
                        <th>Phone number</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($customers as $customer)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $customer->user->username ?? '-' }}</td>
                        <td>{{ $customer->alamat }}</td>
                        <td>{{ $customer->no_hp }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <button class="btn-edit"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editModal-{{ $customer->id }}">
                                    Edit
                                </button>
                                <form id="delete-form-{{ $customer->id }}" action="{{ route('customers.destroy', $customer->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-delete" type="button"
                                        onclick="confirmDelete('{{ $customer->id }}')">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    {{-- MODAL EDIT per baris --}}
                    <div class="modal fade" id="editModal-{{ $customer->id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered" style="max-width:420px;">
                            <div class="modal-content bg-dark text-white border-0">
                                <div class="modal-header border-0 pb-0">
                                    <span style="background:#2b2b2b; color:#fff; padding:8px 14px; border-radius:12px; font-size:.88rem; font-weight:600;">
                                        Edit Customer
                                    </span>
                                </div>
                                <form method="POST" action="{{ route('customers.update', $customer->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body d-flex flex-column gap-3">
                                        <input type="text" name="no_hp"
                                               class="form-control"
                                               placeholder="Phone number"
                                               value="{{ $customer->no_hp }}" required>
                                        <input type="text" name="alamat"
                                               class="form-control"
                                               placeholder="Address"
                                               value="{{ $customer->alamat }}">
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

@endsection