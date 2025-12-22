@extends('layouts.dashboardUI')

@section('title', 'Properties')

@section('content')
<div class="container-fluid">
    <div class="property-container" style="background: white; border-radius: 29.27px; padding: 20px;">
        <h1 style="color: black; font-size: 2.5rem; font-family: Poppins; font-weight: 700;">Properties</h1>
        @if(session('success'))
            <div style="color: green; margin-block-start: 10px;">{{ session('success') }}</div>
        @endif

        <div class="row mb-4">
            <div class="col-12 text-end">
                <div class="col-md-12 text-end">
                    <div class="d-flex justify-content-end align-items-center" style="margin-block-start: 20px; ">
                        <!-- Search Box -->
                        <form method="GET" action="{{ url()->current() }}" class="d-flex align-items-center" style="inline-size:  100%; max-inline-size:350px; block-size: 50px; background: #FAFAFA; border-radius: 33.33px;">
                            <!-- حقل البحث -->
                            <input type="text" name="type" placeholder="Search a PROPERTY" class="form-control"
                                style="border: none; inline-size: 100%;  block-size: 100%;  background: transparent; padding-inline-start: 20px; border-radius: 33.33px; font-size: 13.33px; font-family: Poppins; font-weight: 400; line-height: 20px; color: black;"
                                value="{{ request()->input('type') }}">

                            <!-- زر البحث -->
                            <button type="submit" class="btn"
                                style="background-color: #1F1F1F; color: #FEFEFF; font-size: 13.33px; font-family: Poppins; font-weight: 600; line-height: 50px; border-radius: 33.33px; padding: 0 20px;">
                                Search
                            </button>
                        </form>
                        <!-- Add New Property Button -->
                        <a href="{{ route('properties.add') }}" style="text-decoration: none;">
                            <div style="inline-size: 197px; block-size: 50px; position: relative;">
                                <div style="inline-size: 100%; block-size: 100%; position: absolute; background: #FAFAFA; border-radius: 33.33px;"></div>
                                <div style="inline-size: 58px; block-size: 50px; position: absolute; inset-inline-start: 139px; inset-block-start: 0; background: #1F1F1F; border-radius: 33.33px;"></div>
                                <div style="inset-inline-start: 14px; inset-block-start: 16.23px; position: absolute; color: black; font-size: 11.69px; font-family: Poppins; font-weight: 400; line-height: 17.54px; word-wrap: break-word">Add new Property</div>
                                <div style="inset-inline-start: 158px; inset-block-start: 3px; position: absolute; color: white; font-size: 30.30px; font-family: Poppins; font-weight: 400; line-height: 45.45px; word-wrap: break-word">+</div>
                            </div>
                        </a>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            @foreach ($units as $unit)
                <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                    <div class="property-card" style="background: #FAFAFA; border-radius: 8px; overflow: hidden; position: relative;">
                        <!-- Carousel -->
                        <div id="carousel-{{ $unit->id }}" class="carousel slide" data-bs-ride="carousel" style="block-size: 300px;">
                            <div class="carousel-inner">
                                    @php 
                                        $images = is_string($unit->images) ? json_decode($unit->images, true) : (array)$unit->images;
                                    @endphp                               
                                    @if ($images && is_array($images))
                                    @foreach ($images as $index => $image)
                                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                            <img src="{{ asset('storage/' . $image) }}" alt="Property Image" class="d-block w-100" style="block-size: 300px; border-radius: 8px; object-fit: cover;">
                                        </div>
                                    @endforeach
                                @else
                                    <div class="d-flex justify-content-center align-items-center bg-gray-200" style="block-size: 300px; color: #aaa;">
                                        No Image
                                    </div>
                                @endif
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carousel-{{ $unit->id }}" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carousel-{{ $unit->id }}" data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                        </div>

                        <!-- Details -->
                        <div class="p-3">
                            <h5 class="fw-bold">{{ $unit->property_name }}</h5>
                            <p class="text-muted">{{ Str::limit($unit->description, 25) }} <span class="text-primary" style="cursor: pointer;">Read More</span></p>

                            <!-- Features with Icons -->
                            <div class="d-flex justify-content-between align-items-center mb-2" style="gap: 1px;">
                                @if ($unit->rooms)
                                    <span class="badge bg-dark icon-badge"><i class="fas fa-bed" style=" margin-inline-end: 5px;"></i> {{ $unit->rooms }} Bedrooms</span>
                                @endif
                                @if ($unit->bathrooms)
                                    <span class="badge bg-dark icon-badge"><i class="fas fa-bath" style="margin-inline-end: 5px;"></i> {{ $unit->bathrooms }} Bathrooms</span>
                                @endif
                                @if ($unit->type)
                                    <span class="badge bg-dark icon-badge"><i class="fas fa-home" style="margin-inline-end: 5px;"></i> {{ ucfirst($unit->type) }}</span>
                                @endif
                            </div>

                            <!-- Price, Down Payment, Installment, and Buttons -->
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <div class="text-muted" style=" margin-block-end:5px;">Price</div>
                                    <div class="fw-bold" style="color: black; margin-inset-inline-start: 2px; font-size: 1.3rem;">${{ number_format($unit->price, 2) }}</div>

                                    <div class="d-flex mb-1" style="background: #EAEEFD; border-radius: 8.349px; padding: 5px;">
                                        <div class="text-primary" style=" margin-inline-end: 5px;">Down Payment:</div>
                                    </div>
                                    <div class="d-flex flex-column" style="background: #EAEEFD; border-radius: 8.349px; padding: 5px;">
                                        <div class="text-primary mb-1 fw-bold">Installment Plans:</div>
                                            <?php
                                                $installmentsRaw = $unit->installment_options;
                                            
                                                if (is_string($installmentsRaw)) {
                                                    $installments = json_decode($installmentsRaw, true);
                                                } else {
                                                    $installments = $installmentsRaw; // هي بالفعل array
                                                }
                                            
                                                if ($installments && is_array($installments)) {
                                                    foreach ($installments as $plan) {
                                                        $initial_price = isset($plan['initial_price']) ? number_format($plan['initial_price']) . ' EGP' : 'N/A';
                                                        $years = isset($plan['years']) ? $plan['years'] : 'years';
                                                        $monthly_amount = isset($plan['monthly_amount']) ? number_format($plan['monthly_amount']) . ' month' : 'month';
                                            
                                                        echo '<div class="text-primary" style="margin-bottom: 4px;">';
                                                        echo " $initial_price /$monthly_amount    $years years ";
                                                        echo '</div>';
                                                    }
                                                } else {
                                                    echo '<div class="text-danger">No installment data available.</div>';
                                                }
                                            ?>

                                    </div>




                                </div>
                                <div class="d-flex flex-column align-items-end" style="margin-inset-block-start: 35px;">
                                    <a href="{{ route('properties.update', $unit->id) }}" class="btn btn-proshoedite mb-2">Edit</a>
                                    <form action="{{ route('units.delete', $unit->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this unit?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-proshodelet">Delete</button>
                                    </form>
                                    {{-- <form action="{{ route('admin.units.delete', $unit->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit">حذف الوحدة</button>
                                    </form> --}}

                                </div>
                            </div>

                            <div class="text-muted mt-2" style="font-size: 0.9rem; margin-block-start: 2px !important;">
                                Added on {{ $unit->created_at->format('d-m-Y') }}
                            </div>                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Include Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<style>
    /* Add space between icons */
    .icon-badge {
        font-size: 11.5px;
         margin-inline-end: 0.05px;
        display: flex;
        padding: 4.596px 9.544px;
        align-items: center;
        gap: 1.200px;
        border-radius: 23.088px;
        border: 0.825px solid #FFF;
        background: #3A3A3A;
        color: white;
    }

    /* Media Queries for better responsiveness */
    @media (max-inline-size:1200px) {
        .property-card {
            margin-block-end: 20px;
            margin-inline-start: 10px;
            margin-inline-end: 10px;
        }
    }
    @media (max-inline-size:992px) {
        .property-card {
            margin-block-end: 20px;
        }
    }
    @media (max-inline-size:767px) {
        .property-card {
            inline-size:100%;
            margin-block-end: 20px;
        }
        .icon-badge {
            font-size: 9px;
            padding: 3px 8px;
        }
    }

</style>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        window.Echo.channel('unit') // استخدم القناة 'unit'
            .listen('UnitEvent', (e) => { // استخدم الحدث 'UnitEvent'
                const notifications = document.getElementById('notifications');
                const notification = document.createElement('div');
                notification.textContent = e.message;
                notifications.appendChild(notification);
            });
    });
</script>

@endsection
