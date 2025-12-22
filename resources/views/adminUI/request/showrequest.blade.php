@extends('layouts.dashboardUI')

@section('title', 'Bookings')

@section('content')
<div class="container mt-5">
<h2 class="mb-4" style="font-weight: 900; font-family: 'Poppins', sans-serif; font-size: 36px;">
  Request
</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Search Box -->
    <div class="d-flex justify-content-end align-items-center mb-4">
        <form method="GET" action="{{ route('bookings.index') }}" class="d-flex align-items-center" style="width: 100%; max-width: 300px; height: 50px; background: #FAFAFA; border-radius: 33.33px; padding-right: 10px;">
            <input type="text" name="search" placeholder="Search bookings" class="form-control"
                style="border: none; width: 100%; height: 100%; background: transparent; padding-left: 20px; border-radius: 33.33px; font-size: 13.33px; font-family: Poppins; font-weight: 400; line-height: 20px; color: black;"
                value="{{ request('search') }}">
            <button type="submit" class="btn"
                style="background-color: #1F1F1F; color: #FEFEFF; font-size: 13.33px; font-family: Poppins; font-weight: 600; line-height: 50px; border-radius: 33.33px; padding: 0 20px;">
                Search
            </button>
        </form>

        <!-- Add New Booking Button -->
        <a href="{{ route('bookings.create') }}" style="text-decoration: none;">
                            <div style="inline-size: 197px; block-size: 50px; position: relative;">
                                <div style="inline-size: 100%; block-size: 100%; position: absolute; background: #FAFAFA; border-radius: 33.33px;"></div>
                                <div style="inline-size: 58px; block-size: 50px; position: absolute; inset-inline-start: 139px; inset-block-start: 0; background: #1F1F1F; border-radius: 33.33px;"></div>
                                <div style="inset-inline-start: 14px; inset-block-start: 16.23px; position: absolute; color: black; font-size: 11.69px; font-family: Poppins; font-weight: 400; line-height: 17.54px; word-wrap: break-word">Add new booking</div>
                                <div style="inset-inline-start: 158px; inset-block-start: 3px; position: absolute; color: white; font-size: 30.30px; font-family: Poppins; font-weight: 400; line-height: 45.45px; word-wrap: break-word">+</div>
                            </div>
                        </a>

     </div>

    <div class="table-container">
        <table class="table table-borderless align-middle custom-table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>phone number</th>
                    <th>Property</th>
                    <th>Status</th>
                    <th>Price</th>
                    <th>Booking Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                    <tr class="table-row">
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="{{ $booking->user && $booking->user->image ? asset('storage/' . $booking->user->image) : asset('default/user.png') }}"
                                     alt="User Image" class="rounded-circle user-avatar me-2" width="40" height="40">
                                <div>
                                    <div>{{ $booking->user->name ?? 'Unknown User' }}</div>
                                    <small class="text-muted">{{ $booking->user->email ?? 'N/A' }}</small>
                                </div>
                            </div>
                        </td>
                        <td>{{ $booking->phone_number ?? 'N/A' }}</td>

                        <td>{{ $booking->property->property_name ?? 'N/A' }}</td>
                        <td>
                            <span class="badge
                                @if($booking->status == 'Confirmed') bg-success
                                @elseif($booking->status == 'Cancelled') bg-danger
                                @else bg-warning @endif">
                                {{ $booking->status }}
                            </span>
                        </td>
                        <td>{{ $booking->price ? number_format($booking->price) : 'N/A' }}</td>
                        <td>{{ $booking->viewing_date ? \Carbon\Carbon::parse($booking->viewing_date)->format('Y-m-d') : 'N/A' }}</td>
                        <td>
                            <div class="d-flex">
                                <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-sm  btn-success me-2">
                                    <i class="fas fa-eye"></i>
                                </a>
                               <a href="{{ route('bookings.edit', $booking->id) }}" class="btn btn-sm me-2" style="background-color: #88601b; color: white;">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">No bookings found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="mt-4 d-flex justify-content-center">
            {{ $bookings->links() }}
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
    .custom-table th, .custom-table td {
        font-size: 14px;
        color: #4b5563;
        padding: 16px;
        vertical-align: middle;
    }
    .custom-table th {
        color: #9ca3af;
        font-weight: 600;
        border-bottom: 2px solid #e5e7eb;
    }
    .table-row {
        border-bottom: 1px solid #e5e7eb;
        transition: background-color 0.3s ease;
    }
    .table-row:hover {
        background-color: #f3f4f6;
    }
    .badge {
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    .bg-success {
        background-color: #0a9e6d !important;
    }
    .bg-danger {
        background-color: #ef4444 !important;
    }
    .bg-warning {
        background-color: #88601b !important;
    }
    .pagination {
    margin-top: 20px;
    justify-content: center;
}

.pagination .page-link {
    border-radius: 20px !important;
    margin: 0 5px;
    color: #1F1F1F;
    border-color: #e5e7eb;
}

.pagination .page-item.active .page-link {
    background-color: #1F1F1F;
    color: #fff;
    border-color: #1F1F1F;
}

</style>
@endsection
