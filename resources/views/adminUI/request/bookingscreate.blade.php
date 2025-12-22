@extends('layouts.dashboardUI')

@section('title', 'Create Booking')

@section('content')
<div class="container">
    <a href="{{ route('bookings.index') }}" style="text-decoration: none;">
        <div style="display: flex; align-items: center; inline-size: 197px; block-size: 50px; margin-block-end: 20px; position: relative;">
            <div style="color: rgb(5, 5, 5); font-size: 30.30px; margin-inline-end: 10px;">←</div>
            <div style="color: black; font-size: 11.69px;">Back</div>
        </div>
    </a>

    <h2 style="margin-block-start: 30px; margin-inline-start: 40px;font-size: 40.48px; font-family: Urbanist; font-weight: 600; line-height: 60.72px;">Create New Booking</h2>

    <form method="POST" action="{{ route('bookings.store') }}">
        @csrf
        <div class="form-section">
            <!-- الصف الأول: الاسم ورقم التليفون -->
            <div class="row mb-4" style="margin-inline-start: 70px; gap: 20px;">
                <div style="flex: 1;">
                    <label class="form-label">User *</label>
                    <select class="form-select" name="user_id" required style="inline-size: 90%;">
                        <option value="">Select User</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="flex: 1;">
                    <label class="form-label">Phone Number *</label>
                    <input type="text" class="form-control" name="phone_number" required style="inline-size: 90%;">
                </div>
            </div>

            <!-- الصف الثاني: الوحدة - الحالة - السعر - الفينال بوكينج -->
            <div class="row mb-4" style="margin-inline-start: 70px; gap: 15px;">
                <div style="flex: 1; max-inline-size: 23%;">
                    <label class="form-label">Property *</label>
                     <select class="form-select" name="property_id" required>
                        <option value="">Select Property</option>
                        @foreach($units as $property)
                            <option value="{{ $property->id }}">{{ $property->property_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="flex: 1; max-inline-size: 23%;">
                    <label class="form-label">Status *</label>
                    <select class="form-select" name="status" required>
                        <option value="Pending">Pending</option>
                        <option value="Confirmed">Confirmed</option>
                        <option value="Cancelled">Cancelled</option>
                    </select>
                </div>
                <div style="flex: 1; max-inline-size: 23%;">
                    <label class="form-label">Price *</label>
                    <input type="number" class="form-control" name="price" step="0.01" required>
                </div>
                <div style="flex: 1; max-inline-size: 23%; margin-block-start: 30px;">
                    <div class="form-check form-switch">
<input class="form-check-input" type="checkbox" name="is_final_booking" value="1">
                        <label class="form-check-label">Final Booking</label>
                    </div>
                </div>
            </div>

            <!-- الصف الثالث: التواريخ -->
            <div class="row mb-4" style="margin-inline-start: 70px; gap: 20px;">
                <div style="flex: 1;">
                    <label class="form-label">Booking Date *</label>
                    <input type="datetime-local" class="form-control" name="booking_date" required>
                </div>
                <div style="flex: 1;">
                    <label class="form-label">Viewing Date</label>
                    <input type="datetime-local" class="form-control" name="viewing_date">
                </div>
            </div>

            <!-- الصف الرابع: الشركة والمشروع -->
            <div class="row mb-4" style="margin-inline-start: 70px; gap: 20px;">
                <div style="flex: 1;">
                    <label class="form-label">Developer Name</label>
                    <input type="text" class="form-control" name="developer_name">
                </div>
                <div style="flex: 1;">
                    <label class="form-label">Project Name</label>
                    <input type="text" class="form-control" name="project_name">
                </div>
            </div>

            <!-- الملاحظات -->
            <div class="mb-4" style="margin-inline-start: 70px; inline-size: 65%;">
                <label class="form-label">Notes</label>
                <textarea class="form-control" name="notes" rows="4" style="background: #F7F7FC; border-radius: 37.34px;"></textarea>
            </div>
        </div>

        <!-- الأزرار -->
        <div class="d-flex justify-content-end mt-4" style="margin-inline-end: 70px;">
            <button type="button" class="btn btn-custom me-3" onclick="window.history.back()">Cancel</button>
            <button type="submit" class="btn btn-custom" style="background: #007bff; color: white;">Create Booking</button>
        </div>
    </form>
</div>

<style>
/* نفس الاستايل الأصلي بالضبط */
.container {
    max-inline-size: 1600px;
    background-color: #fff;
    padding: 30px;
    border-radius: 28px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    position: relative;
    min-block-size: 1100px;
}

.form-label {
    inline-size: 80%;
    color: black;
    font-size: 34.43px;
    font-family: Urbanist;
    font-weight: 500;
    line-height: 51.65px;
}

.form-control, .form-select {
    inline-size: 100%;
    block-size: 60px;
    background: #F7F7FC;
    border-radius: 37.34px;
    padding: 17px 25px;
    border: 1px solid #E0E0E0;
    font-size: 16px;
}

.btn-custom {
    padding: 15px 30px;
    border-radius: 10.85px;
    font-family: Urbanist;
    font-weight: 500;
    font-size: 16px;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

.form-check-input {
    width: 3em !important;
    height: 1.5em !important;
}

.row.mb-4 {
    margin-block-end: 30px;
}
</style>
@endsection
