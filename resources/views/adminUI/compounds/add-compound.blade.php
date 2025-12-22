<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New compound</title>
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
            min-height: 190px;
        }
        .upload-area:hover {
            border-color:  #0a9e6d;
        }
        .upload-area p {
            color:  #0a9e6d;
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
            background-color:  #0a9e6d;
            color: #ffffff;
        }
        .button-group .publish:hover {
            background-color: #4f47cc;
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
            color:#1f7a5b;
            display: block;
            margin-bottom: 2px;
            margin-top: 3px; /* تحريك التسمية لأسفل قليلاً */
        }
        #input1{
            width: 250px;
            height: 55px;
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
            width: 204.18px;
            height: 50px;
            border-radius: 10px;
            border: 1px solid #ccc;
            background-color: #F7F7FC;
            padding: 8px;
            font-family: 'Urbanist', sans-serif;
            font-size: 14px;
            color: #333;
            outline: none;
            resize: vertical;
            box-sizing: border-box;
            margin-left: 5px;
        }
    </style>
    <script>
        function handleFileSelect() {
            const message = document.getElementById('uploadMessage');
            message.style.display = 'block';
            message.innerText = 'Images added successfully!';
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
// دالة لعرض الرسالة عند اختيار صورة
function showUploadSuccess() {
    const uploadMessage = document.getElementById('uploadMessage');
    const fileInput = document.getElementById('imageUpload');
    
    if (fileInput.files.length > 0) {
        uploadMessage.style.display = 'block'; // إظهار الرسالة بشكل دائم
    }
}
</script>
</head>
<body>
<div class="container">
        <a href="{{ route('compounds.show') }}" style="text-decoration: none;">
            <div style="display: flex; align-items: center; inline-size: 197px; block-size: 50px; margin-block-end: 20px; position: relative;">
                <div style="color: rgb(5, 5, 5); font-size: 30.30px; font-family: Poppins; font-weight: 400; line-height: 45.45px; margin-inline-end: 10px;">←</div>
                <div  style="color: black; font-size: 11.69px; font-family: Poppins; font-weight: 400; line-height: 17.54px;">Back</div>
            </div>
        </a>
    <h1>Add New Project</h1>
    <form action="{{ route('compounds.save') }}" method="POST" enctype="multipart/form-data">
         @csrf
        <div class="upload-section">
            <div class="upload-area">
    <label for="imageUpload" class="block text-sm font-medium text-gray-700">Upload Images</label>
    
    <!-- حقل الرفع مع حدث onchange -->
    <input 
        type="file" 
        id="imageUpload" 
        name="image" 
        style="display: none;" 
        accept="image/*"
        onchange="showUploadSuccess()"
    >
    
    <p>Click here to upload your files or drag.</p>
    <p class="text-muted">Supported formats: SVG, JPG, PNG (1200 x 800)</p>

    <button 
        type="button" 
        onclick="document.getElementById('imageUpload').click();" 
        style="inline-size: 70%; block-size: 70%; padding: 15px; background: rgba(255, 255, 255, 0.80); box-shadow: 0px 1px 61px 1px rgba(0, 0, 0, 0.25); border-radius: 120px; overflow: hidden; backdrop-filter: blur(20px); display: flex; justify-content: center; align-items: center; cursor: pointer; border: none; margin-block-start: 30px; margin-inline-start: 30px;"
    >
        <div style="border-radius: 30px; display: flex; justify-content: center; align-items: center;">
            <span style="color: black; font-size: 15px; font-family: Poppins; font-weight: 400; letter-spacing: 0.15px;">Add Image</span>
        </div>
    </button>

    <!-- رسالة النجاح -->
    <div id="uploadMessage" style="margin-block-start: 15px; color: green; font-size: 23px; display: none;">
        تم إضافة الصورة بنجاح!
    </div>

    @error('image')
        <span class="text-red-500 text-sm">{{ $message }}</span>
    @enderror
</div>
            <div class="extra-fields">
                <div class="form-group">
                    <label for="fa1">Add compound Name</label>
                    <input type="text" id="field1" name="name" class="form-control" placeholder="Add compound Name">
                    @error('name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                        <label class="form-label" for="input1">Developer</label>
                        <select id="input1" name="developer_id" required class="form-select">
                            <option value="">Select Developer</option>
                            @foreach($developers as $dev)
                                <option value="{{ $dev->id }}" {{ request('developer_id') == $dev->id ? 'selected' : '' }}>
                                    {{ $dev->name }}
                                </option>
                            @endforeach
                        </select>



                        @error('developer_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror

                </div>
                <div class="form-group" style="grid-column: span 2;">
                    <label for="field3">compound Location</label>
                    <select type="text"  name="location" required id="field3" class="form-select" placeholder="Enter location">
                        <option value="">اختر الموقع</option>
                        <option value="مدينة 6 أكتوبر">مدينة 6 أكتوبر</option>
                        <option value="New Cairo">القاهرة الجديدة</option>
                        <option value="New Capital City">العاصمة الإدارية الجديدة</option>
                        <option value="El Sheikh Zayed">الشيخ زايد</option>
                        <option value="Hurghada">الشيخ زايد الجديده</option>
                        <option value="Mostakbal City">مدينة المستقبل</option>
                        <option value="Ain Sokhna">العين السخنة</option>
                        <option value="El Gouna">الجونة</option>
                        <option value="New Heliopolis">هليوبوليس الجديدة</option>
                        <option value="El Shorouk">الشروق</option>
                    </select>                    @error('location')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                   @enderror
                </div>
            </div>
        </div>
        <!-- Payment Details Section -->
        <div class="form-section">
            <label for="fa1">Payment Details<label>
          <div class="section1">
            <div class="form-row">
                <div class="form-group first-group">
                    <label for="No">Starting Price (EGP)</label>
                    <input  type="number" name="starting_price" required id="No" placeholder="Start Price">
                    @error('starting_price')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                   @enderror
                </div>
                <div class="form-group">
                    <label for="No">Down Payment (%) </label>
                    <input type="number" id="No" name="down_payment" required>
                        @error('down_payment')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                </div>
                <div class="form-group">
                    <label for="No">Installment Options(year)</label>
                    <input type="number" name="installment_options" id="No" placeholder="Installment Options">
                    @error('installment_options')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                   @enderror
                </div>
                <div class="form-group">
                    <label for="No">maintenance percentage(%)</label>
                    <input type="number" name="maintenance_deposit_percentage" id="No" placeholder="maintenancedepositpercentage">
                    @error('maintenance_deposit_percentage')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

         </div>
        </div>

        <!-- compound average Details Section -->
        <div class="form-section">
            <label for="fa1" class="section-title">compound average Details</label>

            <div class="section1">
                <div class="form-row">
                    <div class="form-group">
                        <label for="No">unit area</label>
                    <input type="number" name="min_size" id="No" placeholder="FROM">
                    @error('min_size')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                    </div>

                    <div class="form-group">
                        <label for="No">unit area</label>
                        <input type="number"  name="unit_area_to" id="input" placeholder="TO">
                        @error('unit_area_to')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                       @enderror
                    </div>

                    <div class="form-group">
                        <label for="No">average meter price </label>
                    <input type="number" name="average_meter_price_from" id="No" placeholder="from">
                    @error('average_meter_price_from')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                    </div>

                    <div class="form-group">
                        <label for="No">average meter price</label>
                    <input type="number" name="average_meter_price_to" id="No" placeholder="To">
                    @error('average_meter_price_to')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- compound Details Section -->

        <div class="form-section">
            <label for="fa1">compound Details</label>
            <div class="section1">

            <div class="form-row">
                <div class="form-group">
                    <label for="status" class="from-font1">Status</label>
                    <select id="input" name="status" class="form-select">
                        <option value="under_construction">Under Construction</option>
                        <option value="completed">Completed</option>
                    </select>
                    @error('status')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="price">Unit Types</label>
                    <textarea id="unit_types" name="unit_types" class="form-control" placeholder="Enter unit types"></textarea>
                    @error('unit_types')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" placeholder="Enter a description for the unit"></textarea>
                    @error('description')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="description">about</label>
                    <textarea id="description" name="about" placeholder=" about compound"></textarea>
                    @error('about')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            </div>
        </div>

        <!-- developer Details Section -->

        <div class="form-section">
            <div class="section1">
                <div class="form-row">
                    <div class="form-group">
                    <label for="description">facilities</label>
                    <textarea id="description" name="facilities" placeholder=" facilities"></textarea>
                    @error('facilities')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                    </div>
                    <div class="form-group">
                    <label for="description">services</label>
                    <textarea id="description"  name="services"placeholder=" services"></textarea>
                    @error('services')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                    </div>

                </div>
            </div>
        </div>



        <!-- Action Buttons -->
        <div class="button-group">
            <button class="publish" type="submit">Publish Now</button>
            <button class="cancel" type="button" onclick="goBack()">Cancel</button>
        </div>
</form>
</body>
</html>
