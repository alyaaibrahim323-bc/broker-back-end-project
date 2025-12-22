@extends('layouts.dashboardUI')

@section('title', 'Create Role')

@section('content')
<div class="container mt-5">
    <!-- Back Button -->
    <a href="{{ route('roles.index') }}" style="text-decoration: none;">
        <div style="inline-size: 197px; block-size: 50px; position: relative; margin-block-end: 20px;">
            <div style="inline-size: 100%; block-size: 100%; position: absolute; background: #FAFAFA; border-radius: 33.33px;"></div>
            <div style="inline-size: 58px; block-size: 50px; position: absolute; inset-inline-start: 139px; inset-block-start: 0; background: #1F1F1F; border-radius: 33.33px;"></div>
            <div style="inset-inline-start: 14px; inset-block-start: 16.23px; position: absolute; color: black; font-size: 11.69px; font-family: Poppins; font-weight: 400; line-height: 17.54px; word-wrap: break-word">Back</div>
            <div style="inset-inline-start: 158px; inset-block-start: 3px; position: absolute; color: white; font-size: 30.30px; font-family: Poppins; font-weight: 400; line-height: 45.45px; word-wrap: break-word">←</div>
        </div>
    </a>

    <!-- Form Container -->
    <div class="table-container mt-5">
        <h2 class="mb-4">Create Role</h2>
        
        <form action="{{ route('roles.store') }}" method="post">
            @csrf
            <div class="mb-4">
                <label for="name" class="form-label" style="font-size: 18px; font-weight: 500; color: #333;">Role Name</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    placeholder="Enter Role Name" 
                    value="{{ old('name') }}" 
                    class="form-control"
                    style="border: 1px solid #ddd; inline-size: 100%; max-inline-size: 600px; block-size: 50px; border-radius: 8px; padding: 10px 15px; font-size: 14px; font-family: Poppins;">
                @error('name')
                <div style="color: red; font-size: 13px;margin-block-start: 5px;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Permissions -->
            <div class="mb-4">
                <label class="form-label" style="font-size: 18px; font-weight: 500; color: #333;">Permissions</label>
                <div class="row mt-3">
                    @if ($permissions->isNotEmpty())
                        @foreach ($permissions as $permission)
                        <div class="col-md-3 mb-2">
                            <input 
                                type="checkbox" 
                                id="permission-{{ $permission->id }}" 
                                class="form-check-input" 
                                name="permission[]" 
                                value="{{ $permission->name }}">
                            <label for="permission-{{ $permission->id }}" class="form-check-label" style="font-size: 14px; color: #4b5563;">
                                {{ $permission->name }}
                            </label>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- Submit Button -->
            <button 
                type="submit" 
                class="btn" 
                style="background-color: #1F1F1F; color: #FEFEFF; padding: 10px 20px; font-size: 14px; font-family: Poppins; font-weight: 600; border-radius: 33.33px;">
                Submit
            </button>
        </form>
    </div>
</div>

<style>
    .table-container {
        background-color: #F5F5F5;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
    }

    .form-label {
        display: block;
        margin-block-end: 8px;
        font-weight: bold;
    }

    .form-control {
        display: block;
        inline-size: 100%;
        padding: 8px 12px;
        font-size: 14px;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
    }

    .form-control:focus {
        color: #495057;
        background-color: #fff;
        border-color: #80bdff;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
</style>
@endsection
