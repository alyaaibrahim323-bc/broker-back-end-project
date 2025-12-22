@extends('layouts.dashboardUI')

@section('title', 'offers')

@section('content')
<div class="container-fluid">
    <div style="inline-size: 100%; block-size: 100%; background: white; border-radius: 29.27px; padding: 20px;">

        <div style="color: black; font-size: 60.36px; font-family: Poppins; font-weight: 700; line-height: 84.51px; word-wrap: break-word">offers</div>
        @if(session('success'))
        <div style="color: green;  margin-block-start: 10px;">{{ session('success') }}</div>
        @endif
        <div class="row mb-4">
            <div class="col-md-12 text-end">
                <div class="d-flex justify-content-end align-items-center" style=" margin-block-start: 20px; position: relative;">
                    <!-- Search Box -->
                    <form method="GET" action="{{ url()->current() }}" class="d-flex align-items-center" style="inline-size: 100%; max-inline-size: 300px;block-size: 50px; background: #FAFAFA; border-radius: 33.33px; padding-inline-end: 10px;">
                        <input type="text" name="type" placeholder="Search a offer
                    " class="form-control"
                            style="border: none; inline-size: 100%; block-size: 100%; background: transparent; padding-inline-start: 20px; border-radius: 33.33px; font-size: 13.33px; font-family: Poppins; font-weight: 400; line-height: 20px; color: black;"
                            value="{{ request()->input('type') }}">
                        <button type="submit" class="btn"
                            style="background-color: #1F1F1F; color: #FEFEFF; font-size: 13.33px; font-family: Poppins; font-weight: 600; line-height: 50px; border-radius: 33.33px; padding: 0 20px;">
                            Search
                        </button>
                    </form>

                    <!-- Add New Property Button -->
                    <a href="{{ route('offers.add') }}" style="text-decoration: none;">
                        <div style="inline-size: 197px;block-size: 50px; position: relative;">
                            <div style="inline-size: 100%; block-size: 100%; position: absolute; background: #FAFAFA; border-radius: 33.33px;"></div>
                            <div style="inline-size: 58px; block-size: 50px; position: absolute;  inset-inline-start: 139px; inset-block-start: 0; background: #1F1F1F; border-radius: 33.33px;"></div>
                            <div style="inset-inline-start: 14px;  inset-block-start: 16.23px; position: absolute; color: black; font-size: 11.69px; font-family: Poppins; font-weight: 400; line-height: 17.54px; word-wrap: break-word">Add new offer

                            </div>
                            <div style="inset-inline-start: 158px; inset-block-start: 3px; position: absolute; color: white; font-size: 30.30px; font-family: Poppins; font-weight: 400; line-height: 45.45px; word-wrap: break-word">+</div>
                        </div>
                    </a>

                </div>
            </div>
        </div>

          <!-- Offers Gallery -->
          <div class="row">
            @foreach($offers as $offer)
            <div class="col-md-4 mb-4">
                <a href="{{ route('offers.edit', $offer->id) }}" style="text-decoration: none;">
                    <div style="position: relative; background: #FAFAFA; border-radius: 20px; overflow: hidden;">
                        <!-- عرض الصورة بحجم ثابت -->
                        <img
                            src="{{ asset('storage/' . $offer->image) }}"
                            alt="Offer Image"
                            style="width: 100%; height: 250px; border-radius: 20px; object-fit: cover;">

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

<!-- Include Alpine.js for toggling details and Bootstrap JS for carousel functionality -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
