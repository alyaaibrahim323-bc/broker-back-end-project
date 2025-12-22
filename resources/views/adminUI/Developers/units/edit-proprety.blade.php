<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Property</title>
        <link rel="icon" type="image/png" sizes="50x50" href="{{ asset('images/logo.png') }}">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Urbanist:wght@500&display=swap');
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1200px;
            margin: 40px auto;
            background: #ffffff;
            padding: 40px;
            border-radius: 50px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            padding: 10px 40px; /* تقليل المسافة العلوية والسفلية */
            font-size: 26px;
            color: #3A3A3A;
            margin-bottom: 10px; /* تقليل المسافة بين العنوان وقسم رفع الصور */
        }
        .upload-section {
            padding: 10px 40px; /* تقليل المسافة العلوية */
            display: flex;
            gap: 30px;
            margin-bottom: 30px;
            align-items: flex-start;
        }
        .upload-area {
            flex: 2;
            border: 2px solid #ccc;
            border-radius: 40px;
            padding: 60px;
            text-align: center;
            background-color: #F7F7FC;
            cursor: pointer;
            min-height: 110px;
        }
        .upload-area:hover {
            border-color: #1f7a5b;
        }
        .upload-area p {
            color: #1f7a5b;
            margin: 10px 0;
        }
        .upload-area button {
            width: 70%;
            padding: 15px;
            background: rgba(255, 255, 255, 0.80);
            box-shadow: 0px 1px 61px 1px rgba(0, 0, 0, 0.25);
            border-radius: 120px;
            border: none;
            margin-top: 30px;
            cursor: pointer;
        }
        .upload-area #uploadMessage {
            margin-top: 15px;
            color: green;
            font-size: 14px;
            display: none;
        }
        .extra-fields {
            flex: 3;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            align-content: start;
        }
        .form-section {
            margin-bottom: 30px;
            width: 100%;
        }
        .form-section h2 {
            font-size: 20px;
            color: #555;
            margin-bottom: 20px;
            border-bottom: 2px solid #eee;
            padding-bottom: 8px;
        }
        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .form-group {
            flex: 1;
            min-width: 250px;
        }
        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            color: #333;
        }
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
            background-color: #f8f9fa;
        }
        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }
        .button-group {
            text-align: right;
            margin-top: 30px;
        }
        .button-group button {
            padding: 12px 30px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .button-group .publish {
            background-color: #0a9e6d;
            color: #ffffff;
        }
        .button-group .publish:hover {
            background-color: #0a9e6d;
        }
        .button-group .cancel {
            background-color: #ff6b6b;
            color: #ffffff;
            margin-left: 15px;
        }
        .button-group .cancel:hover {
            background-color: #d9534f;
        }
        #field1 {
            width: 300px;
            height: 30px;
            border-radius: 57.45px;
            font-family: 'Urbanist', sans-serif;
            font-weight: 200;
            font-size: 20px;
            line-height: 30px;
            color: #174179;
            position: relative;
            margin-top: 3px; /* تحريك الحقل لأسفل قليلاً */
        }
        label[for="fa1"] {
            font-family: 'Urbanist', sans-serif;
            font-weight: 400;
            font-size: 32.61px;
            line-height: 40px;
            color: #1f7a5b;
            display: block;
            margin-bottom: 2px;
            margin-top: 3px; /* تحريك التسمية لأسفل قليلاً */
        }
        #input1{
            width: 204.18px;
            height: 42.89px;
            position: relative;
            margin-top: 5px;
            display: block;
            margin-left: 50px;
            border-radius: 37.29px;
            background-color: #F7F7FC;
            border: 1px solid #ccc;
            padding: 10px;
            box-sizing: border-box;
            font-family: 'Urbanist', sans-serif;
            font-size: 16px;
            color: #333;
            outline: none;
        }
        label[for="field2"] {
            font-family: 'Urbanist', sans-serif;
            font-weight: 400;
            font-size: 20.61px;
            line-height: 40px;
            color: #174179;
            display: block;
            margin-bottom: 2px;
            margin-left: 50px;  /* تحريك التسمية أيضًا لليسار بنفس مقدار الحقل */
        }
        #field3 {
            width: 220px;
            height: 15px;
            border-radius: 30.13px;
            position: relative;
            margin-top: 5px;
            display: block;
        }
        label[for="field3"] {
            font-family: 'Urbanist', sans-serif;
            font-weight: 400;
            font-size: 20.61px;
            line-height: 40px;
            color: #174179;
            display: block;
            margin-bottom: 2px;
        }
        .section1 {
            width: 1200px;       /* العرض */
            height: 140px;       /* الارتفاع */
            border-radius: 19px; /* تدوير الزوايا */
            background-color: #EDEDED; /* لون الخلفية */
            margin-top: 6px;  /* تقليل المسافة بين الكلمة والقسم */
            padding: 10px;


        }
        .form-row {
            display: flex;
            gap: 20px;               /* مسافة بين الحقول */
            margin-top: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;  /* لجعل اللابل فوق الحقل */
            align-items: flex-start; /* محاذاة للنصوص على اليسار */
        }

         label[for="No"]{
            font-family: 'Urbanist', sans-serif;
            font-weight: 300;
            font-size: 20.01px;
            line-height: 40.51px;
            color: #080808;
            margin-bottom: 5px;       /* مسافة بسيطة تحت اللابل */
        }
       #No{

            width: 157.17px;
            height: 47.03px;
            border-radius: 14.49px;
            background-color: #F7F7FC;
            border: 1px solid #ccc;
            padding: 10px;
            box-sizing: border-box;
            outline: none;
            font-family: 'Urbanist', sans-serif;
            font-size: 14px;
            color: #333;
        }
        .first-group {
            margin-left: 15px; /* إبعاد أول حقل عن بداية الـ div */
        }
        .form-row {
            display: flex;
            flex-wrap: wrap;   /* يسمح بانتقال الحقول للسطر التالي عند الحاجة */
            gap: 20px;         /* مسافة بين الحقول */
        }
        .form-group {
            display: flex;
            flex-direction: column;  /* يجعل اللابل فوق الحقل */
            width: 250px;            /* عرض الحقول */
            margin-left: 15px;       /* إبعاد الحقول عن اليسار قليلاً */
        }
        .form-group label {
            font-family: 'Urbanist', sans-serif;
            font-weight: 400;
            font-size: 18px;
            color:  #080808;
            margin-bottom: 5px;      /* مسافة صغيرة بين اللابل والحقل */
        }
        #input,
        .form-group input[type="url"] {
            width: 204.18px;              /* عرض الحقل */
            height: 42.89px;              /* ارتفاع الحقل */
            border-radius: 37.29px;       /* تدوير الزوايا */
            background-color: #F7F7FC;    /* لون الخلفية */
            border: 1px solid #ccc;       /* إطار خفيف */
            padding: 10px;                /* مسافة داخلية */
            box-sizing: border-box;       /* لضبط البُعد مع الحواف الداخلية */
            font-family: 'Urbanist', sans-serif;  /* الخط */
            font-size: 16px;              /* حجم الخط */
            color: #333;                  /* لون النص */
            outline: none;                /* إزالة الحدود عند التركيز */
            margin-left: 5px;             /* إبعاد الحقل قليلاً عن اليسار */
        }
        .form-group textarea {
            width: 204.18px;              /* نفس عرض الحقول النصية */
            height: 50px;                 /* تصغير ارتفاع التكست اريا */
            border-radius: 10px;          /* تدوير الزوايا */
            border: 1px solid #ccc;       /* إطار خفيف */
            background-color: #F7F7FC;    /* لون الخلفية */
            padding: 8px;                 /* مسافة داخلية */
            font-family: 'Urbanist', sans-serif;  /* الخط */
            font-size: 14px;              /* حجم الخط */
            color: #333;                  /* لون النص */
            outline: none;                /* إزالة الحدود عند التركيز */
            resize: vertical;             /* السماح بتغيير الحجم عموديًا فقط */
            box-sizing: border-box;       /* ضبط البُعد مع الحواف الداخلية */
            margin-left: 5px;             /* إبعاد Textarea قليلاً عن اليسار */
        }
    </style>
    <script>
      function handleFileSelect() {
    const input = document.getElementById('imageUpload');
    const files = input.files;

    if (files.length > 0) {
        const imageContainer = document.querySelector('.existing-images .flex');
        imageContainer.innerHTML = '';  // مسح الصور القديمة (اختياري)

        Array.from(files).forEach(file => {
            const reader = new FileReader();

            reader.onload = function(e) {
                const newImageDiv = document.createElement('div');
                newImageDiv.style.position = 'relative';
                newImageDiv.style.width = '150px';
                newImageDiv.style.height = '150px';
                newImageDiv.style.margin = '5px';

                const newImage = document.createElement('img');
                newImage.src = e.target.result;
                newImage.style.width = '100%';
                newImage.style.height = '100%';
                newImage.style.objectFit = 'cover';
                newImage.style.boxShadow = '0 0 15px rgba(0, 0, 0, 0.15)';

                newImageDiv.appendChild(newImage);
                imageContainer.appendChild(newImageDiv);
            };

            reader.readAsDataURL(file);
        });

        // عرض رسالة النجاح
        document.getElementById('uploadMessage').style.display = 'block';
    }
}



    </script>
    <script>
        const uploadArea = document.getElementById('uploadArea');
        const imageUpload = document.getElementById('imageUpload');
        const uploadMessage = document.getElementById('uploadMessage');

        uploadArea.addEventListener('click', () => imageUpload.click());

        uploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadArea.classList.add('dragover');
        });

        uploadArea.addEventListener('dragleave', () => {
            uploadArea.classList.remove('dragover');
        });

        uploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadArea.classList.remove('dragover');
            imageUpload.files = e.dataTransfer.files;
            handleFileSelect();
        });

        function triggerFileInput() {
            imageUpload.click();
        }

        function handleFileSelect() {
            if (imageUpload.files.length > 0) {
                uploadMessage.style.display = 'block';
                uploadMessage.textContent = 'Images added successfully!';
            } else {
                uploadMessage.style.display = 'none';
            }
        }
    </script>
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
    <script>

        function addInstallment() {
            const container = document.getElementById('installmentContainer');
            const newInstallment = document.createElement('div');
            newInstallment.className = 'installment-option mb-3';
            newInstallment.innerHTML = `
                <input type="number" name="installments[${installmentIndex}][years]"
                       class="form-control mb-2" placeholder="Years">
                <input type="number" name="installments[${installmentIndex}][initial_price]"
                       class="form-control mb-2" placeholder="Initial Price">
                <input type="number" name="installments[${installmentIndex}][monthly]"
                       class="form-control mb-2" placeholder="Monthly Payment">
                <button type="button" class="btn btn-danger btn-sm remove-installment">Remove</button>
            `;
            container.appendChild(newInstallment);
            installmentIndex++;
        }

        document.addEventListener('click', function(e) {
            if(e.target && e.target.classList.contains('remove-installment')) {
                e.target.closest('.installment-option').remove();
            }
        });
        </script>
</head>
<body>
<div class="container">
        <a href="{{ route('developers.properties', ['id' => $developer->id]) }}" style="text-decoration: none;">
            <div style="display: flex; align-items: center; inline-size: 197px; block-size: 50px; margin-block-end: 20px; position: relative;">
                <div style="color: rgb(5, 5, 5); font-size: 30.30px; font-family: Poppins; font-weight: 400; line-height: 45.45px; margin-inline-end: 10px;">←</div>
                <div  style="color: black; font-size: 11.69px; font-family: Poppins; font-weight: 400; line-height: 17.54px;">Back</div>
            </div>
        </a>
    <h1>Edit Property</h1>
    <form action="{{ route('properties.update', $unit->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <!-- Upload Section with Extra Fields -->
        <div class="upload-section">
            <div class="upload-area" style="position: relative; width: 100%; height: 300px; border: 1px solid #ccc; border-radius: 50px; display: flex; justify-content: center; align-items: center; overflow: hidden;">
                <input type="file" id="imageUpload" name="images[]" multiple style="display: none;" accept="image/*" onchange="previewImage(event)">

                <!-- Preview the First Image if Exists -->
                @php
                    $images = json_decode($unit->images, true);  // فك تشفير الصور
                    $firstImage = !empty($images) ? asset('storage/' . $images[0]) : '';
                @endphp

                <img id="imagePreview" src="{{ $firstImage }}"
                     alt="Click to upload image"
                     style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; cursor: pointer;"
                     onclick="document.getElementById('imageUpload').click();">

                <!-- Message if No Image Available -->
                @if(empty($firstImage))
                    <p style="position: absolute; text-align: center; color: #666;">
                        Click here to upload your files or drag.<br>
                        <span class="text-muted" style="font-size: 12px;">Supported formats: SVG, JPG, PNG (1200 x 800)</span>
                    </p>
                @endif

                @error('images.*')
                    <span class="text-red-500 text-sm" style="position: absolute; bottom: 10px;">{{ $message }}</span>
                @enderror
            </div>







            <div class="extra-fields">
                <div class="form-group">
                    <label for="fa1">Project Name</label>
                    <input type="text" id="field1" name="property_name"
                           value="{{ old('property_name', $unit->property_name) }}" placeholder="Add name">
                    @error('property_name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="field2">Type</label>
                    <select id="input1" name="type" required class="form-select">
                    <option value="">اختر النوع</option>
                    @php
                        $types = [
                            'شقة',
                            'فيلا',
                            'توأم',
                            'تاون هاوس',
                            'دوبلكس',
                            'بنتهاوس',
                            'استوديو',
                            'عيادة',
                            'مكتب',
                            'تجزئة',
                        ];
                    @endphp
                
                    @foreach($types as $type)
                        <option value="{{ $type }}" {{ old('type', $unit->type) == $type ? 'selected' : '' }}>
                            {{ $type }}
                        </option>
                    @endforeach
                </select>

                    @error('type')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group" style="grid-column: span 2;">
                    <label for="field3">Area</label>
                    <input type="number" name="size" required id="field3"
                           value="{{ old('size', $unit->size) }}" placeholder="Add size">
                    @error('size')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Unit facilities Section -->
        <div class="form-section">
            <label for="fa1">Unit facilities</label>
            <div class="section1">
                <div class="form-row">
                    <div class="form-group first-group">
                        <label for="No">No. Bedrooms</label>
                        <input type="number" name="rooms" required id="No"
                               value="{{ old('rooms', $unit->rooms) }}" placeholder="">
                        @error('rooms')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="No">No. Bathrooms</label>
                        <input type="number" name="bathrooms" id="No"
                               value="{{ old('bathrooms', $unit->bathrooms) }}" placeholder="">
                        @error('bathrooms')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="No">Roof Area</label>
                        <input type="number" name="roof_area" id="No"
                               value="{{ old('roof_area', $unit->roof_area) }}" placeholder="">
                        @error('roof_area')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="No">Garden Area</label>
                        <input type="number" name="garden_area" id="No"
                               value="{{ old('garden_area', $unit->garden_area) }}" placeholder="">
                        @error('garden_area')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Unit Details Section -->
        <div class="form-section">
            <label for="fa1" class="section-title">Unit Details</label>
            <div class="section1">
                <div class="form-row">
                   <div class="form-group">
                        <label for="location">الموقع</label>
                        @php
                            $locations = [
                                'مدينة 6 أكتوبر',
                                'القاهرة الجديدة',
                                'العاصمة الإدارية الجديدة',
                                'الشيخ زايد',
                                'الشيخ زايد الجديدة',
                                'مدينة المستقبل',
                                'العين السخنة',
                                'الجونة',
                                'هليوبوليس الجديدة',
                                'الشروق'
                            ];
                        @endphp
                    
                        <select name="location" id="location" class="form-select" required>
                            <option value="">اختر الموقع</option>
                            @foreach($locations as $loc)
                                <option value="{{ $loc }}" {{ old('location', $unit->location) == $loc ? 'selected' : '' }}>
                                    {{ $loc }}
                                </option>
                            @endforeach
                        </select>
                    
                        @error('location')
                            <span class="text-danger text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="link">Link of Location</label>
                        <input type="url" id="link" name="location_link"
                               value="{{ old('location_link', $unit->location_link) }}" placeholder="Enter link">
                        @error('location_link')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="price">lat</label>
                        <input type="number" step="any" name="lat" id="input"
                               value="{{ old('lat', $unit->lat) }}" placeholder="Enter lat">
                        @error('lat')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="price">lng</label>
                        <input type="number" step="any" name="lng" id="input"
                               value="{{ old('lng', $unit->lng) }}" placeholder="Enter lng">
                        @error('lng')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                   
                </div>
            </div>
        </div>

        <!-- Payment Details Section -->
        <div class="form-section">
            <label for="fa1">Payment Details</label>
            <div class="section1">
                <div class="form-row">
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" name="price" id="input"
                               value="{{ old('price', $unit->price) }}" placeholder="Enter price">
                        @error('price')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="downPayment">Down Payment</label>
                        <input type="number" name="down_payment" id="input"
                               value="{{ old('down_payment', $unit->down_payment) }}" placeholder="%">
                        @error('down_payment')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="pricePerMeter">Status</label>
                        <select id="input" name="status" class="form-select" required>
                            <option value="">Select status</option>
                            @foreach(['available', 'sold', 'reserved'] as $status)
                                <option value="{{ $status }}" {{ old('status', $unit->status) == $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Installment Options</label>
                        <div id="installmentContainer">
                       @php
                        $rawInstallments = $unit->installment_options;
                    
                        // نتأكد إنها مصفوفة حقيقية أو JSON
                        if (is_string($rawInstallments)) {
                            $installments = json_decode($rawInstallments, true);
                        } elseif (is_array($rawInstallments)) {
                            $installments = $rawInstallments;
                        } else {
                            $installments = [];
                        }
                    @endphp
                    
                    @foreach($installments as $index => $installment)
                        <div class="installment-option mb-3">
                            <input type="number" name="installments[{{ $index }}][years]"
                                value="{{ $installment['years'] ?? '' }}"
                                class="form-control mb-2" placeholder="Years" required>
                            <input type="number" name="installments[{{ $index }}][initial_price]"
                                value="{{ $installment['initial_price'] ?? '' }}"
                                class="form-control mb-2" placeholder="Initial Price" required>
                            <input type="number" name="installments[{{ $index }}][monthly]"
                                value="{{ $installment['monthly'] ?? '' }}"
                                class="form-control mb-2" placeholder="Monthly Payment" required>
                            @if($index > 0)
                                <button type="button" class="btn btn-danger btn-sm remove-installment">Remove</button>
                            @endif
                        </div>
                    @endforeach


    </div>
    <button type="button" onclick="addInstallment()" class="btn btn-secondary btn-sm">+ Add Installment</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Developer Details Section -->
        <div class="form-section">
            <label for="fa1" class="section-title">Developer Details</label>
            <div class="section1">
                <div class="form-row">
                    <div class="form-group" style="flex: 1 1 8%; min-width: 200px;">
                        <label for="projectName">Developer</label>
                        <select id="input" name="developer_id" required class="form-select">
                            <option value="">Select Developer</option>
                            @foreach($developers as $developer)
                                <option value="{{ $developer->id }}"
                                    {{ old('developer_id', $unit->developer_id) == $developer->id ? 'selected' : '' }}>
                                    {{ $developer->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('developer_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group" style="flex: 1 1 8%; min-width: 200px;">
                        <label for="projectType">Project</label>
                        <select id="input" name="project_id" required>
                            <option value="">Select a project</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}"
                                    {{ old('project_id', $unit->project_id) == $project->id ? 'selected' : '' }}>
                                    {{ $project->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('project_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group"style="flex: 1 1 30%; min-width: 200px;">
                        <label for="location">Sales</label>
                        <select id="input" name="sales_id" required>
                            <option value="">Select a salesperson</option>
                            @foreach($salespeople as $salesperson)
                                <option value="{{ $salesperson->id }}"
                                    {{ old('sales_id', $unit->sales_id) == $salesperson->id ? 'selected' : '' }}>
                                    {{ $salesperson->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('sales_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                     <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="description"
                                  placeholder="Enter description">{{ old('description', $unit->description) }}</textarea>
                        @error('description')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    <input type="hidden" name="redirect_to" value="developer_properties">

        <!-- Action Buttons -->
        <div class="button-group">
            <button class="publish" type="submit">Update Property</button>
            <button class="cancel" type="button" onclick="goBack()">Cancel</button>
        </div>
    </form>
</body>
<script>
let installmentIndex = {{ count($installments) }};

function addInstallment() {
    const container = document.getElementById('installmentContainer');
    const newInstallment = document.createElement('div');
    newInstallment.className = 'installment-option mb-3';
    newInstallment.innerHTML = `
        <input type="number" name="installments[${installmentIndex}][years]"
               class="form-control mb-2" placeholder="Years" required>
        <input type="number" name="installments[${installmentIndex}][initial_price]"
               class="form-control mb-2" placeholder="Initial Price" required>
        <input type="number" name="installments[${installmentIndex}][monthly]"
               class="form-control mb-2" placeholder="Monthly Payment" required>
        <button type="button" class="btn btn-danger btn-sm remove-installment">Remove</button>
    `;
    container.appendChild(newInstallment);
    installmentIndex++;
}

document.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-installment')) {
        e.target.closest('.installment-option').remove();
    }
});
</script>
</html>
