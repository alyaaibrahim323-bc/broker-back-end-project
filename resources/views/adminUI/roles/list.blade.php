@extends('layouts.dashboardUI')

@section('title', 'Roles')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Roles</h2>

    <div class="d-flex justify-content-end align-items-center" style="margin-block-start: 20px; position: relative;">
        <!-- Add Role Button -->
        <a href="{{ route('roles.create') }}" style="text-decoration: none;">
            <div style="inline-size: 197px; block-size: 50px; position: relative;">
                <div style="inline-size: 100%; block-size: 100%; position: absolute; background: #FAFAFA; border-radius: 33.33px;"></div>
                <div style="inline-size: 58px; block-size: 50px; position: absolute; inset-inline-start: 139px; inset-block-start: 0; background: #1F1F1F; border-radius: 33.33px;"></div>
                <div style="inset-inline-start: 14px; inset-block-start: 16.23px; position: absolute; color: black; font-size: 11.69px; font-family: Poppins; font-weight: 400; line-height: 17.54px; word-wrap: break-word">Add Role</div>
                <div style="inset-inline-start: 158px; inset-block-start: 3px; position: absolute; color: white; font-size: 30.30px; font-family: Poppins; font-weight: 400; line-height: 45.45px; word-wrap: break-word">+</div>
            </div>
        </a>
    </div>

    <div class="table-container mt-5">
        <table class="table table-borderless align-middle custom-table">
            <thead>
                <tr>
                    <th style=" inline-size: 10%;">#</th>
                    <th style=" inline-size: 40%;">Name</th>
                    <th style=" inline-size: 30%;">Permissions</th>
                    <th style=" inline-size: 20%; text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @if($roles->isNotEmpty())
                @foreach ($roles as $role)
                <tr class="table-row">
                    <td>{{ $role->id }}</td>
                    <td>{{ $role->name }}</td>
                    <td>{{ $role->permissions->pluck('name')->implode(', ') }}</td>
                    <td class="text-center">
                        <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-edit">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </td>
                    <td>
                        <button class="btn btn-delete" title="Delete" onclick="window.location.href='{{ route('roles.delete', ['id' => $role->id]) }}'">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                    
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="4" class="text-center">No roles available.</td>
                </tr>
                @endif
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $roles->links() }}
        </div>
    </div>
</div>
<style>
    .table-container {
        background-color: #F5F5F5;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
    }

    .custom-table th,
    .custom-table td {
        font-size: 14px;
        color: #4b5563;
        padding: 16px;
        vertical-align: middle;
    }

    .custom-table th {
        color: #9ca3af;
        font-weight: 600;
        border-block-end: 2px solid #e5e7eb;
    }

    .table-row {
        border-block-end: 1px solid #e5e7eb;
        transition: background-color 0.3s ease;
    }

    .table-row:hover {
        background-color: #f3f4f6;
    }

    .btn-edit,
    .btn-delete {
        background: none;
        border: none;
        color: #4b5563;
        font-size: 14px;
        padding: 5px 10px;
        border-radius: 8px;
        transition: color 0.3s ease, background-color 0.3s ease;
    }

    .btn-edit:hover {
        color: #0a9e6d;
        background-color: #eef2ff;
    }

    .btn-delete:hover {
        color: #dc2626;
        background-color: #fee2e2;
    }
</style>
@endsection
