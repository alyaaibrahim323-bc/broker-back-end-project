@extends('layouts.dashboardUI')

@section('title', 'Profile Settings')

@section('content')
<div class="container mt-5">
    <!-- Header -->
    <div class="card-header d-flex justify-content-between align-items-center bg-light padding-bottom: 0; ">
        <h2 class="fw-bold mb-0">Profile Settings</h2>
    </div>
    <div class="card1  border-0">
        <!-- Form -->
        <div class="">
            <form action="#" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Public Profile -->
                <div class="profile-container" style="width: 100%; display: flex; flex-direction: row; justify-content: space-between; gap: 15px; padding: 10px;">
                    <!-- Left Section (Title + Description) -->
                    <div class="left-section" style="flex: 1; display: flex; flex-direction: column; gap: 5px;">
                        <!-- Title Section -->
                        <div class="title-section" style="display: flex; align-items: center; gap: 5px;">
                            <div style="color: #1E293B; font-size: 16px; font-weight: 700;">Profile</div>
                            <div style="width: 24px; height: 24px; background-color: #94A3B8; border-radius: 50%"></div>
                        </div>
                        <!-- Description Section -->
                        <div style="color: #475569; font-size: 14px; line-height: 1.6;">Main profile details</div>
                    </div>

                    <!-- Right Section (Input Fields + Buttons) -->
                    <div class="right-section" style="flex: 1; display: flex; flex-direction: column; gap: 5px; align-items: center; padding-top: 10px;">
                        <!-- Name Input -->
                        <div style="background: white; border-radius: 50px; padding: 10px; border: 1px solid #CBD5E1; display: flex; flex-direction: row; justify-content: space-between; align-items: center; width: 100%; max-width: 300px;">
                            <input type="text" id="username" placeholder="Enter your username" value="{{ auth()->user()->name }}" style="border: none; outline: none; flex: 1; padding: 8px; font-size: 14px;">
                        </div>

                        <!-- Email Input -->
                        <div style="background: white; border-radius: 50px; padding: 10px; border: 1px solid #CBD5E1; display: flex; flex-direction: row; justify-content: space-between; align-items: center; width: 100%; max-width: 300px;">
                            <input type="email" id="email" placeholder="Enter your email" value="{{ auth()->user()->email }}" style="border: none; outline: none; flex: 1; padding: 8px; font-size: 14px;">
                        </div>
                    </div>
                </div>
                <hr>

                <!-- Bio Description -->
                <div class="profile-container" style="width: 100%; display: flex; flex-direction: row; justify-content: space-between; gap: 15px; padding: 10px;">
                    <!-- Left Section (Title + Description) -->
                    <div class="left-section" style="flex: 1; display: flex; flex-direction: column; gap: 5px;">
                        <!-- Title Section -->
                        <div class="title-section" style="display: flex; align-items: center; gap: 5px;">
                            <div style="color: #1E293B; font-size: 16px; font-weight: 700;">Details</div>
                            <div style="width: 24px; height: 24px; background-color: #94A3B8; border-radius: 50%"></div>
                        </div>
                        <!-- Description Section -->
                        <div style="color: #475569; font-size: 14px; line-height: 1.6;">Your personal information</div>
                    </div>

                    <!-- Right Section (Input Fields) -->
                    <div class="right-section" style="flex: 1; display: flex; flex-direction: column; gap: 10px; align-items: center; padding-top: 10px;">
                        <!-- Role Input -->
                        <div style="background: white; border-radius: 50px; padding: 10px; border: 1px solid #CBD5E1; display: flex; flex-direction: row; justify-content: space-between; align-items: center; width: 100%; max-width: 300px;">
                            <span style="font-size: 14px; color: #1E293B;">
                                @foreach(auth()->user()->roles as $role)
                                    {{ $role->name }}{{ !$loop->last ? ', ' : '' }}
                                @endforeach
                            </span>
                        </div>

                        <!-- City Input -->
                        <div style="background: white; border-radius: 50px; padding: 10px; border: 1px solid #CBD5E1; display: flex; flex-direction: row; justify-content: space-between; align-items: center; width: 100%; max-width: 300px;">
                            <input type="text" id="city" name="city" class="form-control" value="{{ auth()->user()->city }}" placeholder="Enter your city" style="border: none; outline: none; flex: 1; padding: 8px; font-size: 14px;">
                        </div>

                        <!-- Phone Input -->
                        <div style="background: white; border-radius: 50px; padding: 10px; border: 1px solid #CBD5E1; display: flex; flex-direction: row; justify-content: space-between; align-items: center; width: 100%; max-width: 300px;">
                            <input type="text" id="phone" name="phone" class="form-control" value="{{ auth()->user()->phone_number }}" placeholder="Enter your phone number" style="border: none; outline: none; flex: 1; padding: 8px; font-size: 14px;">
                        </div>
                    </div>
                </div>
                    <hr>


                <!-- Profile Picture -->
                <div class="mb-4">
                    <h5 class="fw-bold text-muted">Profile Picture</h5>
                    <div class="d-flex align-items-center gap-3">
                        <div class="profile-picture1">
                            <img src="{{ asset('storage/' . auth()->user()->image) }}" alt="User Image">
                        </div>
                    </div>
                </div>
               <hr>
                <!-- Save Buttons -->
                {{-- <div class="d-flex justify-content-between mt-4">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger w-100">Logout</button>
                    </form>
                </div> --}}
            </form>
            <div class="d-flex justify-content-between mt-4">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger w-100">Logout</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
<style>
/* General Container */
.container {
    margin-top: 50px;
}

.card1 {
    border-radius: 1px;
    overflow: hidden;
    box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
    background: #ffffff;
    padding: 20px;
}

/* Profile Picture */
.profile-picture1 {
    inline-size: 100px;
    block-size: 100px;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 10px;
    overflow: hidden;
    background-color: #f5f5f5;
}

.profile-picture1 img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Form Elements */
input[type="text"],
input[type="email"],
textarea,
input[type="file"] {
    padding: 6px 10px;
    font-size: 13px;
    border-radius: 8px;
    border: 1px solid #ddd;
    width: 100%;
    max-width: 280px;
}

input[type="text"]:focus,
input[type="email"]:focus,
input[type="file"]:focus,
textarea:focus {
    border-color: #007bff;
    outline: none;
    box-shadow: 0px 0px 5px rgba(0, 123, 255, 0.3);
}

/* Buttons */
.btn {
    border-radius: 8px;
    font-size: 14px;
    padding: 8px 15px;
}

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
}

.btn-danger {
    background-color: #dc3545;
    border-color: #dc3545;
}

.btn-logout {
    background-color: #dc3545;
    border-color: #dc3545;
    padding: 12px 20px;
    font-size: 16px;
    font-weight: 600;
    border-radius: 8px;
    transition: background-color 0.3s ease;
}

.btn-logout:hover {
    background-color: #c82333;
}

.btn-primary:hover {
    background-color: #0056b3;
}

.btn-danger:hover {
    background-color: #c82333;
}

/* Section Styling */
.profile-container {
    display: flex;
    justify-content: space-between;
    gap: 15px;
    padding: 10px;
}

.left-section {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.title-section {
    display: flex;
    align-items: center;
    gap: 5px;
}

.icon {
    width: 24px;
    height: 24px;
    background-color: #94A3B8;
    border-radius: 50%;
}

.right-section {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 10px;
    align-items: center;
    padding-top: 10px;
}

/* Form Elements */
input[type="text"],
input[type="email"],
input[type="file"],
textarea {
    padding: 6px 10px;
    font-size: 13px;
    border-radius: 8px;
    border: 1px solid #ddd;
    width: 100%;
    max-width: 280px; /* يمكنك تقليص هذا الحجم إذا كنت ترغب في حجم أصغر */
    height: 35px; /* تحديد ارتفاع أصغر */
}

input[type="text"]:focus,
input[type="email"]:focus,
input[type="file"]:focus,
textarea:focus {
    border-color: #007bff;
    outline: none;
    box-shadow: 0px 0px 5px rgba(0, 123, 255, 0.3);
}

/* تحسين أزرار المدخلات */
.input-group {
    background: white;
    border-radius: 50px;
    padding: 8px;
    border: 1px solid #CBD5E1;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    max-width: 280px;
}

.input-group input {
    border: none;
    outline: none;
    flex: 1;
    padding: 8px;
    font-size: 14px;
    height: 30px; /* تقليص ارتفاع المدخلات */
}


/* Header */
.card-header {
    padding: 20px;
    background-color: #ffffff;
    border-block-end: 1px solid #e4e4e7;
    font-size: 1.25rem;
}

/* Footer */
.card-footer {
    padding: 20px;
    background-color: #f8f9fa;
    border-block-start: 1px solid #e4e4e7;
}


</style>




{{-- @extends('layouts.dashboardUI')

@section('title', 'Profile Settings')

@section('content')
<div class="container mt-5">
    <!-- Card Header -->
    <div class="card-header d-flex justify-content-between align-items-center bg-light">
        <h2 class="fw-bold mb-0">Profile Settings</h2>
    </div>

    <div class="card mt-3">
        <div class="card-body">
            <!-- Tabs -->
            <div class="d-flex border-bottom pb-3 mb-4">
                <button class="btn btn-link active" id="tab-details">Details</button>
                <button class="btn btn-link" id="tab-personal">Personal</button>
                <button class="btn btn-link" id="tab-account">Account</button>
                <button class="btn btn-link" id="tab-profile">Profile</button>
                <button class="btn btn-link" id="tab-security">Security</button>
                <button class="btn btn-link" id="tab-appearance">Appearance</button>
                <button class="btn btn-link" id="tab-api">API</button>
            </div>

            <!-- Tab Content -->
            <div id="tab-content-details" class="tab-content">
                <h5 class="mb-2">Profile Details</h5>
                <form action="#" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control" value="{{ auth()->user()->name }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Profile URL</label>
                        <input type="text" class="form-control" value="{{ auth()->user()->profile_url }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Bio Description</label>
                        <input type="text" class="form-control" value="{{ auth()->user()->bio }}">
                    </div>
                    <hr />
                    <div>
                        <h5 class="mb-2">Profile Picture</h5>
                        <div class="d-flex align-items-center gap-3">
                            <img src="{{ asset('storage/' . auth()->user()->image) }}" alt="Profile" class="rounded-circle" width="80" height="80">
                            <div class="border border-dashed rounded-lg p-4 text-center">
                                <svg class="mb-2" width="24" height="24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0 2a2 2 0 0 1 2-2h20a2 2 0 0 1 2 2v20a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2z" />
                                </svg>
                                <p>Click to upload or drag and drop</p>
                                <small>Supported formats: SVG, PNG, JPG (Max 800x400px)</small>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-4 gap-2">
                        <button class="btn btn-outline-secondary">Cancel</button>
                        <button class="btn btn-primary">Save Settings</button>
                    </div>
                </form>
            </div>

            <!-- Content for Other Tabs -->
            <div id="tab-content-personal" class="tab-content" style="display: none;">
                <h5 class="mb-2">Personal Info</h5>
                <div class="mb-3">
                    <label class="form-label">City</label>
                    <input type="text" class="form-control" value="{{ auth()->user()->city }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Phone</label>
                    <input type="text" class="form-control" value="{{ auth()->user()->phone_number }}">
                </div>
            </div>

            <div id="tab-content-account" class="tab-content" style="display: none;">
                <h5 class="mb-2">Account Settings</h5>
                <!-- Add Account Settings Fields Here -->
            </div>

            <div id="tab-content-profile" class="tab-content" style="display: none;">
                <h5 class="mb-2">Profile Settings</h5>
                <!-- Add Profile Settings Fields Here -->
            </div>

            <div id="tab-content-security" class="tab-content" style="display: none;">
                <h5 class="mb-2">Security Settings</h5>
                <!-- Add Security Settings Fields Here -->
            </div>

            <div id="tab-content-appearance" class="tab-content" style="display: none;">
                <h5 class="mb-2">Appearance Settings</h5>
                <!-- Add Appearance Settings Fields Here -->
            </div>

            <div id="tab-content-api" class="tab-content" style="display: none;">
                <h5 class="mb-2">API Settings</h5>
                <!-- Add API Settings Fields Here -->
            </div>
        </div>
    </div>
</div>

<script>
    // Handle tab switching
    document.getElementById('tab-details').addEventListener('click', function() {
        showTab('details');
    });
    document.getElementById('tab-personal').addEventListener('click', function() {
        showTab('personal');
    });
    document.getElementById('tab-account').addEventListener('click', function() {
        showTab('account');
    });
    document.getElementById('tab-profile').addEventListener('click', function() {
        showTab('profile');
    });
    document.getElementById('tab-security').addEventListener('click', function() {
        showTab('security');
    });
    document.getElementById('tab-appearance').addEventListener('click', function() {
        showTab('appearance');
    });
    document.getElementById('tab-api').addEventListener('click', function() {
        showTab('api');
    });

    // Function to switch tabs
    function showTab(tabName) {
        const allTabs = document.querySelectorAll('.tab-content');
        allTabs.forEach(function(tab) {
            tab.style.display = 'none';
        });
        document.getElementById('tab-content-' + tabName).style.display = 'block';

        // Update active tab button
        const allButtons = document.querySelectorAll('.btn-link');
        allButtons.forEach(function(button) {
            button.classList.remove('active');
        });
        document.getElementById('tab-' + tabName).classList.add('active');
    }
</script>
@endsection --}}

