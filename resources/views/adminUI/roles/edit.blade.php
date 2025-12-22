@extends('layouts.dashboardUI')

@section('title', 'Edit Role')

@section('content')
<!-- Start Content -->
<div class="container mt-5">
    <h2 class="mb-4">Edit Role</h2>
    

    <div class="d-flex justify-content-end align-items-center mb-4" style="position: relative;">
        <!-- Back Button -->
        <a href="{{ route('roles.index') }}" style="text-decoration: none;">
            <div style="inline-size: 197px; block-size: 50px; position: relative;">
                <div style="inline-size: 100%; block-size: 100%; position: absolute; background: #FAFAFA; border-radius: 33.33px;"></div>
                <div style="inline-size: 58px; block-size: 50px; position: absolute; inset-inline-start: 139px; inset-block-start: 0; background: #1F1F1F; border-radius: 33.33px;"></div>
                <div style="inset-inline-start: 14px; inset-block-start: 16.23px; position: absolute; color: black; font-size: 11.69px; font-family: Poppins; font-weight: 400; line-height: 17.54px; word-wrap: break-word">Back to List</div>
                <div style="inset-inline-start: 158px; inset-block-start: 3px; position: absolute; color: white; font-size: 30.30px; font-family: Poppins; font-weight: 400; line-height: 45.45px; word-wrap: break-word">←</div>
            </div>
        </a>
    </div>

    <div class="form-container">
        sssss
        <form action="{{ route('roles.update', $role->id) }}" method="post">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="form-label">Role Name</label>
                <input 
                    value="{{ old('name', $role->name) }}" 
                    name="name" 
                    placeholder="Enter Role Name" 
                    type="text" 
                    class="form-control @error('name') is-invalid @enderror">
                @error('name')
                <div class="text-danger mt-2" style="font-size: 0.9rem;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Permissions -->
            <div class="mb-4">
                <label class="form-label">Permissions</label>
                <div class="row mt-3">
                    @if ($permissions->isNotEmpty())
                        @foreach ($permissions as $permission)
                        <div class="col-md-3 mb-2">
                            <input 
                                {{ $hasPermissions->contains($permission->name) ? 'checked' : '' }} 
                                type="checkbox" 
                                id="permission-{{ $permission->id }}" 
                                class="form-check-input" 
                                name="permission[]" 
                                value="{{ $permission->name }}">
                            <label for="permission-{{ $permission->id }}" class="form-check-label">
                                {{ $permission->name }}
                            </label>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <button type="submit" class="btn-submit">Update Role</button>
        </form>
    </div>
</div>

<style>
    .form-container {
        background-color: #F5F5F5;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        max-inline-size: 90%;
        inline-size: 1800px;
        margin: 0 auto;
    }

    .form-label {
        display: block;
        font-weight: bold;
        font-size: 1.2rem;
        color: #4b5563;
        margin-block-end: 10px;
    }

    .form-control {
        inline-size: 100%;
        padding: 12px;
        font-size: 1rem;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        background-color: #ffffff;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    .form-control:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.3);
        outline: none;
    }

    .is-invalid {
        border-color: #dc2626;
    }

    .btn-submit {
        background-color: #1F1F1F;
        color: #FEFEFF;
        padding: 12px 24px;
        font-size: 1.1rem;
        font-family: Poppins, sans-serif;
        font-weight: 600;
        line-height: 1.5;
        border-radius: 8px;
        border: none;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .btn-submit:hover {
        background-color: #333333;
        transform: translateY(-2px);
    }

    /* Responsive adjustments */
    @media (max-inline-size: 768px) {
        .form-container {
            padding: 20px;
            max-inline-size: 100%; 
        }
    }
</style>
@endsection
