@extends('layouts.dashboardUI')

@section('title', 'Sales')

@section('content')
<!-- Include Alpine.js and Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Start Content -->
<div class="container mt-5">
    <h2 class="mb-4">Sales</h2>
    @if(session('success'))
    <div style="color: green;  margin-block-start: 10px;">{{ session('success') }}</div>
    @endif
    <div class="d-flex justify-content-end align-items-center" style=" margin-block-start: 20px; position: relative;">
        <!-- Search Box -->
        <form method="GET" action="{{ url()->current() }}" class="d-flex align-items-center" style="inline-size: 100%; max-inline-size: 300px; block-size: 50px; background: #FAFAFA; border-radius: 33.33px; padding-inline-end: 10px;">
            <input type="text" name="type" placeholder="Search a Sales" class="form-control"
                style="border: none; inline-size: 100%; block-size: 100%; background: transparent; padding-inline-start: 20px; border-radius: 33.33px; font-size: 13.33px; font-family: Poppins; font-weight: 400; line-height: 20px; color: black;"
                value="{{ request()->input('type') }}">
            <button type="submit" class="btn"
                style="background-color: #1F1F1F; color: #FEFEFF; font-size: 13.33px; font-family: Poppins; font-weight: 600; line-height: 50px; border-radius: 33.33px; padding: 0 20px;">
                Search
            </button>
        </form>


        <!-- Add New Property Button -->
        <a href="{{route('sales.add')}}" style="text-decoration: none;">
            <div style="inline-size: 197px;block-size: 50px; position: relative;">
                <div style="inline-size: 100%; block-size: 100%; position: absolute; background: #FAFAFA; border-radius: 33.33px;"></div>
                <div style="inline-size: 58px; block-size: 50px; position: absolute;  inset-inline-start: 139px; inset-block-start: 0; background: #1F1F1F; border-radius: 33.33px;"></div>
                <div style="inset-inline-start: 14px;  inset-block-start: 16.23px; position: absolute; color: black; font-size: 11.69px; font-family: Poppins; font-weight: 400; line-height: 17.54px; word-wrap: break-word">Add new Sales</div>
                <div style="inset-inline-start: 158px; inset-block-start: 3px; position: absolute; color: white; font-size: 30.30px; font-family: Poppins; font-weight: 400; line-height: 45.45px; word-wrap: break-word">+</div>
            </div>
        </a>

    </div>
    <div class="table-container">
        <table class="table table-borderless align-middle custom-table">
            <thead>
                <tr>
                    <th style="inline-size: 15%;">Name</th>
                    <th style="inline-size: 20%;">Email</th>
                    <th style="inline-size: 15%;">Phone Number</th>
                    <th style="inline-size: 10%;">Units Count</th>
                    <th style="inline-size: 10%;"><i class="fas fa-pen"></i></th>
                    <th style="inline-size: 10%;"><i class="fas fa-trash"></i></th>
                </tr>
            </thead>
            <tbody>
                @foreach($sale as $sale)
                <tr class="table-row">
                    <td>
                        <div class="d-flex align-items-center">
                            <!-- عرض صورة افتراضية إذا لم يكن هناك صورة -->
                            <img src="{{ $sale->image ? asset('storage/' . $sale->image) : asset('default-avatar.png') }}"
                                 alt="Sales Image"
                                 class="rounded-circle Sales-avatar"
                                 style="inline-size: 40px; block-size: 40px;">
                            <span class="ms-2">{{ $sale->name }}</span>
                        </div>
                    </td>
                    <td>{{ $sale->email ?? 'N/A' }}</td>
                    <td>{{ $sale->contact_info ?? 'N/A' }}</td>
                    <td>{{ $sale->units_count }}</td>

                    <td>
                        <button class="btn btn-edit" title="Edit" onclick="window.location.href='{{route('sales.update',['id'=>$sale->id])}}'">
                            <i class="fas fa-edit"></i>
                        </button>
                    </td>
                    <td>
                        <form action="{{route('sales.delete',['id'=>$sale->id])}}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-delete" title="Delete" type="submit">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>
<!-- End Content -->

<!-- Styles for the page -->
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f9fafb;
    }
    .container3 {
        max-inline-size: 1200px;
        margin-block-start: 40px;
        color: white;

    }
    h2 {
        font-size: 28px;
        font-weight: bold;
        color: #333;
    }
    .btn-add-user {
        background-color: #333;
        color: white;
        border-radius: 50px;
        padding: 10px 20px;
        font-size: 16px;
    }
    .search-bar {
        inline-size: 300px;
        border-radius: 5px;
        border: 1px solid #d1d5db;
    }
    .search-button {
        background-color: #333;
        color: white;
        font-size: 14px;
        padding: 5px 15px;
        border-radius: 5px;
    }
    .table-container {
        background-color: #F5F5F5;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
    }
    .custom-table th, .custom-table td {
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
        border-block-end: 1px  solid #e5e7eb;
        transition: background-color 0.3s ease;
    }
    .table-row:hover {
        background-color: #f3f4f6;
    }
    .user-avatar {
        inline-size: 40px;
        block-size: 40px;
        object-fit: cover;
        margin-inline-end: 10px;
    }
    .account-tier {
        color: #2563eb;
        font-weight: bold;
    }
    .last-active {
        color: #6b7280;
    }
    .btn-edit, .btn-delete {
        background: none;
        border: none;
        color: #4b5563;
        font-size: 18px;
        transition: color 0.3s ease;
    }
    .btn-edit:hover, .btn-delete:hover {
        color: #0a9e6d;
    }
</style>
@endsection
