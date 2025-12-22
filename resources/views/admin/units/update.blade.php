<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Unit') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('admin/units/update', $unit->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 gap-6">
                            <!-- حقل اختيار المشروع -->
                            <div>
                                <label for="project_id" class="block text-sm font-medium text-gray-700">Select Project</label>
                                <select id="project_id" name="project_id" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <option value="">Select a project</option>
                                    @foreach($projects as $project)
                                        <option value="{{ $project->id }}" {{ $unit->project_id == $project->id ? 'selected' : '' }}>{{ $project->name }}</option>
                                    @endforeach
                                </select>
                                @error('project_id')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- حقل النوع -->
                            <div>
                                <label for="type" class="block text-sm font-medium text-gray-700">Unit Type</label>
                                <select id="type" name="type" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <option value="">Choose Unit Type</option>
                                    <option value="شقة" {{ $unit->type == 'شقة' ? 'selected' : '' }}>شقة</option>
                                    <option value="شاليه" {{ $unit->type == 'شاليه' ? 'selected' : '' }}>شاليه</option>
                                    <option value="دوبلكس" {{ $unit->type == 'دوبلكس' ? 'selected' : '' }}>دوبلكس</option>
                                    <option value="تاون هاوس" {{ $unit->type == 'تاون هاوس' ? 'selected' : '' }}>تاون هاوس</option>
                                    <option value="مكتب" {{ $unit->type == 'مكتب' ? 'selected' : '' }}>مكتب</option>
                                    <option value="استيديو" {{ $unit->type == 'استيديو' ? 'selected' : '' }}>استيديو</option>
                                    <option value="توين هاوس" {{ $unit->type == 'توين هاوس' ? 'selected' : '' }}>توين هاوس</option>
                                </select>
                                @error('type')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- حقل الحجم -->
                            <div>
                                <label for="size" class="block text-sm font-medium text-gray-700">Size (in sq. meters)</label>
                                <input type="number" name="size" id="size" value="{{ $unit->size }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                @error('size')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- حقل السعر -->
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                                <input type="number" name="price" id="price" value="{{ $unit->price }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                @error('price')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- حقل الموقع -->
                            <div>
                                <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                                <input type="text" name="location" id="location" value="{{ $unit->location }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                @error('location')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- حقل الوصف -->
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea name="description" id="description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ $unit->description }}</textarea>
                                @error('description')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- حقل عدد الغرف -->
                            <div>
                                <label for="rooms" class="block text-sm font-medium text-gray-700">Rooms</label>
                                <input type="number" name="rooms" id="rooms" value="{{ $unit->rooms }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                @error('rooms')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- حقل عدد الحمامات -->
                            <div>
                                <label for="bathrooms" class="block text-sm font-medium text-gray-700">Bathrooms</label>
                                <input type="number" name="bathrooms" id="bathrooms" value="{{ $unit->bathrooms }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                @error('bathrooms')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- حقل الصور -->
                            <div>
                                <label for="images" class="block text-sm font-medium text-gray-700">Upload Images</label>
                                <input type="file" name="images[]" id="images" multiple class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                @error('images.*')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- رابط الموقع -->
                            <div>
                                <label for="location_link" class="block text-sm font-medium text-gray-700">Location Link (optional)</label>
                                <input type="url" name="location_link" id="location_link" value="{{ $unit->location_link }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                @error('location_link')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- قائمة الوصف -->
                            <div>
                                <label for="list_of_description" class="block text-sm font-medium text-gray-700">List of Description (optional)</label>
                                <textarea name="list_of_description" id="list_of_description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ $unit->list_of_description }}</textarea>
                                @error('list_of_description')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- مساحة الحديقة -->
                            <div>
                                <label for="garden_size" class="block text-sm font-medium text-gray-700">Garden Size (optional)</label>
                                <input type="number" name="garden_size" id="garden_size" value="{{ $unit->garden_size }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                @error('garden_size')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- مساحة السطح -->
                            <div>
                                <label for="roof_size" class="block text-sm font-medium text-gray-700">Roof Size (optional)</label>
                                <input type="number" name="roof_size" id="roof_size" value="{{ $unit->roof_size }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                @error('roof_size')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="mt-6">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 disabled:opacity-25 transition">Update Unit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
