<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Units List') }} (Total: {{ $total }})
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="mb-4">Units</h1>
                    @if (session()->has('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <a href="{{ route('admin/units/create') }}" class="btn btn-primary mb-4">Add Unit</a>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($units as $unit)
                            <div class="border rounded-lg shadow-md p-6 bg-white dark:bg-gray-700">
                                <!-- Carousel for multiple images -->
                                <div id="carousel-{{ $unit->id }}" class="carousel slide mb-4" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        @php
                                            $images = json_decode($unit->images);
                                        @endphp
                                        @if ($images && is_array($images))
                                            @foreach ($images as $index => $image)
                                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                                    <img src="{{ asset('storage/' . $image) }}" alt="Unit Image" class="w-full h-48 object-cover rounded">
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="w-full h-48 bg-gray-200 rounded flex items-center justify-center text-gray-500">
                                                No Image
                                            </div>
                                        @endif
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carousel-{{ $unit->id }}" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#carousel-{{ $unit->id }}" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    </button>
                                </div>

                                <!-- Unit details -->
                                <h3 class="text-lg font-semibold mb-2 flex items-center">
                                    <x-heroicon-o-home class="w-5 h-5 mr-2 text-blue-500"/> {{ $unit->type }}
                                </h3>
                                <p><strong>Location:</strong> <i class="fas fa-map-marker-alt mr-1 text-purple-500"></i> {{ $unit->location }}</p>
                                <p><strong>Description:</strong> {{ Str::limit($unit->description, 50) }}</p>

                                <!-- Additional details -->
                                <div class="flex flex-wrap mt-4">
                                    @if ($unit->bedrooms)
                                        <div class="flex items-center mr-4">
                                            <i class="icon ion-md-bed mr-1 text-purple-500"></i>
                                            <span><strong>Bedrooms:</strong> {{ $unit->bedrooms }}</span>
                                        </div>
                                    @endif
                                    @if ($unit->bathrooms)
                                        <div class="flex items-center mr-4">
                                            <i class="fas fa-bath mr-1 text-purple-500"></i> 
                                            <span><strong>Bathrooms:</strong> {{ $unit->bathrooms }}</span>
                                        </div>
                                    @endif
                                    @if ($unit->roof_space)
                                        <div class="flex items-center mr-4">
                                            <span class="w-5 h-5 mr-1 text-purple-500">☀️</span> 
                                            <span><strong>Roof Space:</strong> {{ $unit->roof_space }} sqm</span>
                                        </div>
                                    @endif
                                    @if ($unit->garden_space)
                                        <div class="flex items-center">
                                            <span class="w-5 h-5 mr-1 text-purple-500">🍃</span> 
                                            <span><strong>Garden Space:</strong> {{ $unit->garden_space }} sqm</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Toggle for full description -->
                                <div x-data="{ showDetails: false }" class="mt-2">
                                    <button @click="showDetails = !showDetails" class="text-blue-500 hover:underline">
                                        View More
                                    </button>
                                    <div x-show="showDetails" class="mt-2">
                                        <p><strong>Full Description:</strong> {{ $unit->description }}</p>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <a href="{{ route('admin/units/edit', $unit->id) }}" class="text-blue-500 hover:underline">Edit</a>
                                    <form action="{{ route('admin/units/delete', $unit->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline ml-2">Delete</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Alpine.js for toggling details and Bootstrap JS for carousel functionality -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</x-app-layout>
