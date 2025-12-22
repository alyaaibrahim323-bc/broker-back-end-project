@extends('layouts.dashboardUI')

@section('title', 'Compounds')

@section('content')
<div class="container-fluid">
    <div style="inline-size: 100%; block-size: 100%; background: white; border-radius: 29.27px; padding: 20px;">

        <div style="color: black; font-size: 50.36px; font-family: Poppins; font-weight: 600; line-height: 84.51px; word-wrap: break-word">Compounds</div>
        @if(session('success'))
        <div style="color: green;  margin-block-start: 10px;">{{ session('success') }}</div>
        @endif
        <div class="row mb-4">
            <div class="col-md-12 text-end">
                <div class="d-flex justify-content-end align-items-center" style=" margin-block-start: 20px; position: relative;">
                    <!-- Search Box -->
                    <form method="GET" action="{{ url()->current() }}" class="d-flex align-items-center" style="inline-size: 100%; max-inline-size: 300px;block-size: 50px; background: #FAFAFA; border-radius: 33.33px; padding-inline-end: 10px;">
                        <input type="text" name="type" placeholder="Search a compound" class="form-control"
                            style="border: none; inline-size: 100%; block-size: 100%; background: transparent; padding-inline-start: 20px; border-radius: 33.33px; font-size: 13.33px; font-family: Poppins; font-weight: 400; line-height: 20px; color: black;"
                            value="{{ request()->input('type') }}">
                        <button type="submit" class="btn"
                            style="background-color: #1F1F1F; color: #FEFEFF; font-size: 13.33px; font-family: Poppins; font-weight: 600; line-height: 50px; border-radius: 33.33px; padding: 0 20px;">
                            Search
                        </button>
                    </form>

                    <!-- Add New Property Button -->
                    <a href="{{ route('compounds.add') }}" style="text-decoration: none;">
                        <div style="inline-size: 197px;block-size: 50px; position: relative;">
                            <div style="inline-size: 100%; block-size: 100%; position: absolute; background: #FAFAFA; border-radius: 33.33px;"></div>
                            <div style="inline-size: 58px; block-size: 50px; position: absolute;  inset-inline-start: 139px; inset-block-start: 0; background: #1F1F1F; border-radius: 33.33px;"></div>
                            <div style="inset-inline-start: 14px;  inset-block-start: 16.23px; position: absolute; color: black; font-size: 11.69px; font-family: Poppins; font-weight: 400; line-height: 17.54px; word-wrap: break-word">Add new compound</div>
                            <div style="inset-inline-start: 158px; inset-block-start: 3px; position: absolute; color: white; font-size: 30.30px; font-family: Poppins; font-weight: 400; line-height: 45.45px; word-wrap: break-word">+</div>
                        </div>
                    </a>

                </div>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-md-4 g-2">
            @foreach($compounds as $compound)
            <div class="col mb-3 p-1">
                <div class="card1 h-100 border-0">
                    <a href="" class="text-decoration-none text-dark">
                        <div class="position-relative">
                            <!-- compound Image -->
                            <img src="{{ asset('storage/' . $compound->image) }}" alt="Compound Image"
                                 class="img-fluid rounded-4 shadow"
                                 style="height: 340px; width: 250.24px; object-fit: cover; border-radius: 28.21px;">

                            <!-- Edit Button -->
                            <a href="{{ route('compounds.update', $compound->id) }}"
                               class="btn position-absolute start-50 translate-middle"
                               style="top: 85%; background-color:  #0a9e6d; color: white; border: none; padding: 10px 20px; border-radius: 5px; text-decoration: none;">
                                Edit
                            </a>
                        </div>

                        <!-- Text Content -->
                        <div class="mt-3 p-2">
                            <h5 class="fw-bold mb-1" style="font-size: 1.2rem; font-family: Poppins;">
                                {{ $compound->name }}
                            </h5>

                        </div>
                    </a>
                </div>
            </div>
            @endforeach
        </div>


    </div>
</div>
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

<!-- Include Alpine.js for toggling details and Bootstrap JS for carousel functionality -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
