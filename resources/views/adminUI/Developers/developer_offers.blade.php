@extends('layouts.dashboardUI')

@section('title', 'Offers')

@section('content')
<div class="container-fluid">


    <div style="inline-size: 100%; block-size: 100%; background: white; border-radius: 29.27px; padding: 20px;">
        <a href="{{ route('developers.show') }}" style="text-decoration: none;">
            <div style="display: flex; align-items: center; inline-size: 197px; block-size: 50px; margin-block-end: 20px; position: relative;">
                <div style="color: rgb(5, 5, 5); font-size: 30.30px; font-family: Poppins; font-weight: 400; line-height: 45.45px; margin-inline-end: 10px;">←</div>
                <div  style="color: black; font-size: 11.69px; font-family: Poppins; font-weight: 400; line-height: 17.54px;">Back</div>
            </div>
        </a>
        <div style="color: black; font-size: 60.36px; font-family: Poppins; font-weight: 700; line-height: 84.51px; word-wrap: break-word">{{ $developer->name }}</div>
        @if(session('success'))
        <div style="color: green;  margin-block-start: 10px;">{{ session('success') }}</div>
        @endif
        <div class="row mb-4">
            <div class="col-md-12 text-end">
                <div class="d-flex justify-content-end align-items-center" style=" margin-block-start: 20px; position: relative;">
                    <!-- Add New Offer Button -->
                    <a href="{{ route('offers.add') }}" style="text-decoration: none;">
                        <div style="inline-size: 197px;block-size: 50px; position: relative;">
                            <div style="inline-size: 100%; block-size: 100%; position: absolute; background: #FAFAFA; border-radius: 33.33px;"></div>
                            <div style="inline-size: 58px; block-size: 50px; position: absolute; inset-inline-start: 139px; inset-block-start: 0; background: #1F1F1F; border-radius: 33.33px;"></div>
                            <div style="inset-inline-start: 14px; inset-block-start: 16.23px; position: absolute; color: black; font-size: 11.69px; font-family: Poppins; font-weight: 400; line-height: 17.54px; word-wrap: break-word">Add New Offer</div>
                            <div style="inset-inline-start: 158px; inset-block-start: 3px; position: absolute; color: white; font-size: 30.30px; font-family: Poppins; font-weight: 400; line-height: 45.45px; word-wrap: break-word">+</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div style="position: relative; inset-block-start: -30px;">
            <!-- التبديل للتحكم في الصفحات -->
            <label class="switch">
                <input type="checkbox" id="pageSwitch" onclick="togglePage()">
                <span class="slider"></span>
                <!-- النص داخل الدائرة: اليسار -->
                <span class="circle-text left-text">Offers</span>
                <!-- النص داخل الدائرة: اليمين -->
                <span class="circle-text right-text">Properties</span>
            </label>
        </div>

        <div class="offers-gallery" style="display: flex; flex-wrap: wrap; gap: 20px;">
            @foreach($offers as $offer)
                <div class="col-md-4 mb-4" style="flex: 1 1 calc(33.333% - 20px); max-width: calc(33.333% - 20px);">
                    <a href="{{ route('offers.edit', $offer->id) }}" style="text-decoration: none;">
                        <div style="position: relative; background: #FAFAFA; border-radius: 20px; overflow: hidden;">
                            <!-- عرض الصورة -->
                            <img src="{{ asset('storage/' . $offer->image) }}" alt="Offer Image" style="inline-size: 100%; block-size: auto; border-radius: 20px;">

                            <!-- النصوص -->
                            <div style="position: absolute; bottom: 0; width: 100%; background: rgba(0, 0, 0, 0.5); color: white; text-align: center; padding: 15px 0; display: flex; justify-content: space-around; align-items: center;">
                                <!-- Downpayment -->
                                <div style="text-align: center;">
                                    <span style="font-size: 18px; font-weight: bold; display: block;">
                                        {{ round($offer->downpayment ?? 0) }}%
                                    </span>
                                    <span style="font-size: 16px; font-weight: normal; display: block; margin-top: 5px;">
                                        Downpayment
                                    </span>
                                </div>
                                <!-- Installment -->
                                <div style="text-align: center;">
                                    <span style="font-size: 18px; font-weight: bold; display: block;">
                                        {{ round($offer->installment_years ?? 0) }} years
                                    </span>
                                    <span style="font-size: 16px; font-weight: normal; display: block; margin-top: 5px;">
                                        Installment
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>


    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function togglePage() {
        const checkbox = document.getElementById("pageSwitch");

        if (checkbox.checked) {
            window.location.href = "{{ route('developers.offers', $developer->id) }}"; // توجيه إلى صفحة العروض
        } else {
            window.location.href = "{{ route('developers.properties', $developer->id) }}"; // توجيه إلى صفحة العقارات
        }
    }

    window.onload = function() {
        const checkbox = document.getElementById("pageSwitch");

        const isOffersPage = "{{ request()->is('developers/'.$developer->id.'/offers') }}";
        if (isOffersPage) {
            checkbox.checked = true;
        } else {
            checkbox.checked = false;
        }
    };
</script>

@endsection
