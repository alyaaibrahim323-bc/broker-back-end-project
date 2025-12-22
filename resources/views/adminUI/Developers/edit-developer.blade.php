<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Developer Property</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="50x50" href="{{ asset('images/logo.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Segoe+UI:wght@400;600&display=swap" rel="stylesheet">


    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f8f9fa;
        }

        .container {
            max-width: 1600px;
            background-color: #fff;
            padding: 30px;
            border-radius: 32px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: relative;
            min-height: 1000px;
        }

        .upload-area {
            max-width: 550px;
            border: 2px solid #ccc;
            border-radius: 10px;
            padding: 60px;
            text-align: center;
            margin-bottom: 30px;
            background-color: #F7F7FC;
            cursor: pointer;
            border-radius: 40px;
            margin-top: 60px;
            margin-left: 70px;
        }
        /* Make sure the inline style in HTML for upload-area is:
           style="position: relative; width: 100%; height: 300px; border: 1px solid #ccc; border-radius: 50px; display: flex; justify-content: center; align-items: center; overflow: hidden;"
        */

        .upload-area:hover {
            border-color: #007bff;
        }

        .upload-area p {
            color: #666;
        }

        .form-section {
            display: flex;
            gap: 20px;
            justify-content: flex-start;
            flex-wrap: wrap;
            border-radius: 60px;
        }

        .form-section .left,
        .form-section .right {
            flex: 1;
            min-width: 48%;
        }

        .form-section .right {
            margin-left: -20px;
            margin-top: -330px;
            width: 450px;
        }

        .btn-custom {
            padding: 12px 20px;
            background: #E9E9E9;
            border-radius: 10.85px;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            font-family: Urbanist, sans-serif;
            font-weight: 500;
            font-size: 16px;
            color: #4C4C4C;
            line-height: 1.2;
            border: none;
            cursor: pointer;
        }

        .btn-publish {
            background-color: #0a9e6d;
        }

        .btn-cancel {
            background-color: #dc3545;
            color: #fff;
        }

        .form-control, .form-select {
            border-radius: 4px;
        }

        .form-label {
            color: black;
            font-size: 34.43px;
            font-family: Urbanist, sans-serif;
            font-weight: 500;
            line-height: 51.65px;
            word-wrap: break-word;
        }

        .description-label {
            font-size: 34.43px;
            font-weight: 500;
            font-family: Urbanist, sans-serif;
            color: black;
            margin-bottom: 8px;
            display: block;
            margin-left: 70px;
            width: fit-content;
        }

        #description-display-wrapper {
            margin-top: 10px;
            margin-left: 70px;
            width: calc(100% - 140px);
            max-width: 430px;
            box-sizing: border-box;
        }

        #description-display {
            background: transparent;
            border: none;
            padding: 0;
            margin: 0;
            color: #8C8C8C;
            font-size: 14px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-weight: 400;
            line-height: 20px;
            word-wrap: break-word;
            white-space: pre-wrap;
            cursor: pointer;
            transition: max-height 0.3s ease-out;
            overflow: hidden;
        }

        .read-more-btn {
            color: #007bff;
            cursor: pointer;
            font-size: 14px;
            font-family: Urbanist, sans-serif;
            font-weight: 500;
            padding: 0;
            margin-top: 5px;
            text-decoration: underline;
            display: inline-block;
        }

        .read-more-btn:hover {
            color: #0056b3;
        }

        #description-edit-textarea {
            margin-left: 70px;
            width: calc(100% - 140px);
            max-width: 430px;
            background: #F7F7FC;
            border-radius: 8px;
            padding: 10px 15px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            margin-top: 10px;
            color: #333;
            font-size: 16px;
            font-family: Urbanist, sans-serif;
            font-weight: 400;
            line-height: 24px;
            resize: vertical;
            height: 240px;
            overflow-y: auto;
            display: none;
        }

        .from-font1 {
            color: #080808;
            font-size: 28.04px;
            font-family: Urbanist;
            font-weight: 500;
            line-height: 40.56px;
            word-wrap: break-word;
        }

        .form-select {
            background: #F7F7FC;
            border-radius: 37.34px;
            padding: 10px;
            border: 1px solid #E0E0E0;
            font-family: Urbanist, sans-serif;
            font-size: 16px;
        }

        .form-section .right .form-control {
            width: 100%;
            max-width: 450px;
            margin-left: 0;
            box-sizing: border-box;
            background: #F7F7FC;
            border-radius: 37.34px;
            padding: 10px 15px;
            border: 1px solid #ccc;
        }

        .carousel-container {
            position: relative;
            width: 100%;
            overflow: hidden;
            margin-top: 10px;
            padding: 0 20px; /* Space for arrows */
        }

        .carousel-wrapper {
            display: flex;
            overflow-x: auto;
            scroll-behavior: smooth;
            padding-bottom: 10px;
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .carousel-wrapper::-webkit-scrollbar {
            display: none;
        }

        .btn-primary {
            background-color: #0a9e6d;
            border-color: #0a9e6d;
            margin-left: 70px;
            margin-top: 20px;
            border-radius: 8px;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: 500;
        }
        .btn-primary:hover {
            background-color: #088a5c;
            border-color: #088a5c;
        }

        /* MODIFIED: Project and Offer Card Specific Styles - Removed all borders and adjusted padding/margins */
        .project-card, .offer-card {
            flex: 0 0 180px; /* Adjusted width */
            margin: 0 8px; /* Spacing between cards */
            border: none; /* Removed border */
            border-radius: 12px;
            background: #fff;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05); /* Keep a subtle shadow for separation */
            overflow: hidden;
            padding-bottom: 10px; /* Padding at the bottom of the card */
        }

        .project-card:first-child, .offer-card:first-child {
            margin-left: 0;
        }

        .project-card img, .offer-card img {
            width: 100%;
            height: 120px; /* Image height */
            object-fit: cover;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
            border-bottom: none; /* Removed border below image */
        }

        .project-info, .offer-info {
            padding: 8px 10px; /* Padding inside the text area */
            text-align: left;
        }
        .project-info h5, .offer-info h5 {
            font-size: 14px;
            margin-bottom: 2px; /* Tighter spacing */
            font-weight: 600; /* Semi-bold for titles */
            color: #333;
            line-height: 1.2;
        }
        .project-info p, .offer-info p {
            font-size: 12px;
            color: #666;
            margin-bottom: 0; /* No bottom margin for location */
            line-height: 1.2; /* Tighter line height for location */
        }

        /* REMOVED: Specific styles for additional project/offer details */

        .carousel-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.4);
            color: #fff;
            border: none;
            padding: 0;
            cursor: pointer;
            z-index: 10;
            font-size: 20px;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: background-color 0.2s ease;
        }
        .carousel-arrow:hover {
            background-color: rgba(0, 0, 0, 0.6);
        }

        .left-arrow {
            left: 0;
        }

        .right-arrow {
            right: 0;
        }

        .from-font1[for="offersDetails"] {
            margin-top: 20px;
            display: block;
        }

        /* Media Queries for mobile responsiveness */
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }

            .upload-area {
                margin-left: 0;
                margin-top: 30px;
                width: 100%;
                padding: 40px;
            }

            .form-section {
                flex-direction: column;
            }

            .form-section .left,
            .form-section .right {
                min-width: 100%;
                margin-bottom: 20px;
            }

            .description-label, #description-display-wrapper, #description-edit-textarea {
                margin-left: 0;
                width: 100%;
                max-width: none;
            }

            .btn-custom {
                width: 100%;
                padding: 12px;
            }

            .btn-publish,
            .btn-cancel {
                width: 100%;
                padding: 12px;
                margin-top: 20px;
            }

            .form-label {
                font-size: 28px;
            }

            .form-section .right .form-control {
                max-width: 100%;
            }

            .carousel-container {
                padding: 0;
            }

            .carousel-wrapper {
                padding: 0 10px;
            }
            .project-card, .offer-card {
                margin: 0 5px;
                flex: 0 0 200px;
            }
            .project-card:first-child, .offer-card:first-child {
                margin-left: 0;
            }

            .btn-primary {
                margin-left: 0;
                width: 100%;
                text-align: center;
            }
             .carousel-arrow {
                width: 30px;
                height: 30px;
                font-size: 18px;
            }
        }

        @media (max-width: 992px) {
            .form-section {
                flex-direction: column;
            }

            .upload-area {
                margin-left: 0;
                width: 100%;
            }

            .form-section .right {
                margin-left: 0;
                margin-top: 20px;
                width: 100%;
            }

            .description-label, #description-display-wrapper, #description-edit-textarea {
                margin-left: 0;
                width: 100%;
                max-width: none;
            }
            .btn-primary {
                margin-left: 0;
                width: 100%;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <a href="{{ route('developers.show') }}" style="text-decoration: none;">
        <div style="display: flex; align-items: center; width: 197px; height: 50px; margin-bottom: 20px; position: relative;">
            <div style="color: rgb(5, 5, 5); font-size: 30.30px; font-family: Poppins; font-weight: 400; line-height: 45.45px; margin-right: 10px;">←</div>
            <div style="color: black; font-size: 11.69px; font-family: Poppins; font-weight: 400; line-height: 17.54px;">Back</div>
        </div>
    </a>
    <form action="{{ route('developers.update', $developer->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="upload-area" style="position: relative; width: 100%; height: 300px; border: 1px solid #ccc; border-radius: 50px; display: flex; justify-content: center; align-items: center; overflow: hidden;">
            <input type="file" id="imageUpload" name="image" style="display: none;" accept="image/*" onchange="previewImage(event)">
            <img id="imagePreview" src="{{ asset('storage/' . $developer->image ?? '') }}" alt="Click to upload image" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; cursor: pointer;" onclick="document.getElementById('imageUpload').click();">
            @if(empty($developer->image))
                <p style="position: absolute; text-align: center; color: #666;">Click here to upload your files or drag.<br><span class="text-muted" style="font-size: 12px;">Supported formats: SVG, JPG, PNG (1200 x 800)</span></p>
            @endif
            @error('image')
                <span class="text-red-500 text-sm" style="position: absolute; bottom: 10px;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-section">
            <div class="left">
                <div class="mb-3">
                    <label for="description" class="description-label">Description</label>

                    <div id="description-display-wrapper">
                        <div id="description-display">
                            {{ old('description', $developer->description) }}
                        </div>
                        <span id="read-more-btn" class="read-more-btn" style="display: none;">Read More</span>
                    </div>

                    <textarea id="description-edit-textarea" name="description" class="form-control" placeholder="Click to edit...">{{ old('description', $developer->description) }}</textarea>

                    @error('description')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <a href="{{ route('project.add', ['developer_id' => $developer->id]) }}" class="btn btn-primary">
                    Add New Project
                </a>
            </div>

            <div class="right">
                <div class="mb-3">
                    <label for="name" class="form-label">Developer Name</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $developer->name) }}" placeholder="Developer Name">
                    @error('name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="contact_info" class="from-font1">Phone Number</label>
                    <input type="text" id="contact_info" name="contact_info" class="form-control" value="{{ old('contact_info', $developer->contact_info) }}" placeholder="Phone Number">
                    @error('contact_info')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="location" class="from-font1">Office Location</label>
                    <input type="text" id="location" name="location" class="form-control" value="{{ old('location', $developer->location) }}" placeholder="Enter location">
                    @error('location')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="from-font1">Compound </label>
                    <div id="projectsDetails" class="carousel-container">
                        @if($developer->projects->isNotEmpty())
                            <button class="carousel-arrow left-arrow">❮</button>
                            <div class="carousel-wrapper">
                                @foreach($developer->projects as $project)
                                    <div class="project-card" data-url="{{ route('compounds.update', $project->id) }}">
                                        <img src="{{ asset('storage/' . $project->image) }}" alt="Project Image">
                                        <div class="project-info">
                                            <h5>{{ $project->name }}</h5>
                                            <p>{{ $project->location }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button class="carousel-arrow right-arrow">❯</button>
                        @else
                            <p style="text-align: center; padding: 20px;">There is no Compound for this developer.</p>
                        @endif
                    </div>

                    <label class="from-font1" style="margin-top: 20px; display: block;">Offers</label>
                    <div id="offersDetails" class="carousel-container">
                        @if($offers->isNotEmpty())
                            <button class="carousel-arrow left-arrow">❮</button>
                            <div class="carousel-wrapper">
                                @foreach($offers as $offer)
                                    <div class="offer-card" data-url="{{ route('offers.edit', $offer->id) }}">
                                        <img src="{{ asset('storage/' . $offer->image) }}" alt="Offer Image">
                                        <div class="offer-info">
                                            <h5>{{ $offer->name }}</h5>
                                            <p>{{ $offer->location }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button class="carousel-arrow right-arrow">❯</button>
                        @else
                            <p style="text-align: center; padding: 20px;">There are no Offers available.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end" style="position: relative; bottom: 10px; right: 10px; margin-top: 20px;">
            <button type="submit" class="btn btn-publish btn-custom">Update</button>
        </div>

    </form>
</div>

<script>
    function previewImage(event) {
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = function() {
            const imagePreview = document.getElementById('imagePreview');
            imagePreview.src = reader.result;
            const placeholder = imagePreview.nextElementSibling;
            if (placeholder && placeholder.tagName === 'P') {
                placeholder.style.display = 'none';
            }
        };

        if (file) {
            reader.readAsDataURL(file);
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const carouselContainers = document.querySelectorAll('.carousel-container');

        carouselContainers.forEach(container => {
            const wrapper = container.querySelector('.carousel-wrapper');
            const leftArrow = container.querySelector('.left-arrow');
            const rightArrow = container.querySelector('.right-arrow');

            if (leftArrow && rightArrow && wrapper) {
                leftArrow.addEventListener('click', () => {
                    wrapper.scrollBy({ left: -250, behavior: 'smooth' });
                });

                rightArrow.addEventListener('click', () => {
                    wrapper.scrollBy({ left: 250, behavior: 'smooth' });
                });
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const projectCards = document.querySelectorAll('.project-card');
        projectCards.forEach(card => {
            card.addEventListener('click', () => {
                const url = card.getAttribute('data-url');
                if (url) {
                    window.location.href = url;
                }
            });
        });

        const offerCards = document.querySelectorAll('.offer-card');
        offerCards.forEach(card => {
            card.addEventListener('click', () => {
                const url = card.getAttribute('data-url');
                if (url) {
                    window.location.href = url;
                }
            });
        });
    });


    document.addEventListener('DOMContentLoaded', function() {
        const descriptionDisplayWrapper = document.getElementById('description-display-wrapper');
        const descriptionDisplay = document.getElementById('description-display');
        const descriptionEdit = document.getElementById('description-edit-textarea');
        const readMoreBtn = document.getElementById('read-more-btn');

        if (!descriptionDisplayWrapper || !descriptionDisplay || !descriptionEdit || !readMoreBtn) {
            console.warn("One or more description elements not found. 'Read More' / 'Click to Edit' functionality may not work.");
            return;
        }

        const maxLines = 3;
        const lineHeight = 20;
        const maxHeightPx = maxLines * lineHeight;

        let fullText = descriptionEdit.value.trim();

        function setupDisplay() {
            descriptionDisplay.textContent = fullText;
            descriptionDisplay.style.maxHeight = 'none';
            descriptionDisplay.style.overflow = 'visible';
            readMoreBtn.style.display = 'none';

            requestAnimationFrame(() => {
                const naturalHeight = descriptionDisplay.scrollHeight;

                if (naturalHeight > maxHeightPx + 5) {
                    descriptionDisplay.style.maxHeight = `${maxHeightPx}px`;
                    descriptionDisplay.style.overflow = 'hidden';
                    readMoreBtn.textContent = 'Read More';
                    readMoreBtn.style.display = 'inline-block';
                } else {
                    descriptionDisplay.style.maxHeight = 'none';
                    descriptionDisplay.style.overflow = 'visible';
                    readMoreBtn.style.display = 'none';
                }
            });
        }

        setupDisplay();

        readMoreBtn.addEventListener('click', function(e) {
            e.stopPropagation();

            if (descriptionDisplay.style.maxHeight !== 'none') {
                descriptionDisplay.style.maxHeight = 'none';
                descriptionDisplay.style.overflow = 'visible';
                readMoreBtn.textContent = 'Read Less';
            } else {
                setupDisplay();
            }
        });

        descriptionDisplay.addEventListener('click', function() {
            descriptionDisplayWrapper.style.display = 'none';
            descriptionEdit.style.display = 'block';
            descriptionEdit.focus();
            descriptionEdit.value = fullText;
            descriptionEdit.scrollTop = 0;
        });

        descriptionEdit.addEventListener('blur', function() {
            fullText = descriptionEdit.value.trim();
            setupDisplay();
            descriptionDisplayWrapper.style.display = 'block';
            descriptionEdit.style.display = 'none';
        });

        descriptionEdit.addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                descriptionEdit.blur();
            }
        });
    });
</script>
</body>
</html>