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
            min-height: 190px;
        }
        .upload-area:hover {
            border-color:#1f7a5b;
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
    let index = 1;

    function addInstallment() {
        const container = document.getElementById('installmentContainer');
        const html = `
            <div class="installment-option mt-2">
                <input type="number" name="installments[${index}][years]" class="form-control mb-2" placeholder="Years">
                <input type="number" name="installments[${index}][initial_price]" class="form-control mb-2" placeholder="Initial Price">
                <input type="number" name="installments[${index}][monthly]" class="form-control mb-2" placeholder="Monthly Payment">
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
        index++;
    }
</script>
</head>
<body>
<div class="container">
        <a href="{{ route('properties.show') }}" style="text-decoration: none;">
            <div style="display: flex; align-items: center; inline-size: 197px; block-size: 50px; margin-block-end: 20px; position: relative;">
                <div style="color: rgb(5, 5, 5); font-size: 30.30px; font-family: Poppins; font-weight: 400; line-height: 45.45px; margin-inline-end: 10px;">←</div>
                <div  style="color: black; font-size: 11.69px; font-family: Poppins; font-weight: 400; line-height: 17.54px;">Back</div>
            </div>
        </a>
    <h1>Add New Property</h1>
    <form action="{{ route('properties.save') }}" method="POST" enctype="multipart/form-data">
         @csrf
        <div class="upload-section">
            <div class="upload-area">
                <label for="imageUpload" class="block text-sm font-medium text-gray-700">Upload Images</label>
                <input type="file" id="imageUpload" name="images[]" multiple style="display: none;" accept="image/*" onchange="handleFileSelect()">
                <p>Click here to upload your files or drag.</p>
                <p class="text-muted">Supported formats: SVG, JPG, PNG (1200 x 800)</p>
                <button type="button" onclick="document.getElementById('imageUpload').click();" style="inline-size: 70%; block-size: 70%; padding: 15px; background: rgba(255, 255, 255, 0.80); box-shadow: 0px 1px 61px 1px rgba(0, 0, 0, 0.25); border-radius: 120px; overflow: hidden; backdrop-filter: blur(20px); display: flex; justify-content: center; align-items: center; cursor: pointer; border: none; margin-block-start: 30px; margin-inline-start: 30px;">
                    <div style="border-radius: 30px; display: flex; justify-content: center; align-items: center;">
                        <span style="color: black; font-size: 15px; font-family: Poppins; font-weight: 400; letter-spacing: 0.15px;">Add Image</span>
                    </div>
                </button>
                <div id="uploadMessage" style="margin-block-start: 15px; color: green; font-size: 14px; display: none;">
                    Images added successfully!
                </div>
                @error('images.*')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="extra-fields">
                <div class="form-group">
                    <label for="fa1">Project Name</label>
                    <input type="text" id="field1" name="property_name" placeholder="Add name">
                    @error('property_name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                   @enderror
                </div>
                <div class="form-group">
                    <label for="field2">Type</label>
                  <select id="input1" name="type" required class="form-select">
                    <option value="">اختر النوع</option>
                    <option value="شقة">شقة</option>
                    <option value="فيلا">فيلا</option>
                    <option value="توين هاوس">توين هاوس</option>
                    <option value="تاون هاوس">تاون هاوس</option>
                    <option value="دوبلكس">دوبلكس</option>
                    <option value="بنتهاوس">بنتهاوس</option>
                    <option value="استوديو">استوديو</option>
                    <option value="عيادة">عيادة</option>
                    <option value="مكتب">مكتب</option>
                    <option value="محل تجاري">محل تجاري</option>
                </select>

                    @error('type')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group" style="grid-column: span 2;">
                    <label for="field3">Area</label>
                    <input type="number" name="size" required id="field3" placeholder=" Add size">
                    @error('size')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                   @enderror
                </div>
            </div>
        </div>
        <!-- Unit facilities Section -->
        <div class="form-section">
            <label for="fa1">Unit facilities<label>
          <div class="section1">
            <div class="form-row">
                <div class="form-group first-group">
                    <label for="No">No. Bedrooms</label>
                    <input  type="number" name="rooms" required id="No" placeholder="">
                    @error('rooms')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                   @enderror
                </div>
                <div class="form-group">
                    <label for="No">No. Bathrooms</label>
                    <input type="number" name="bathrooms" id="No" placeholder="">
                    @error('bathrooms')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="No">Roof Area</label>
                    <input type="number" name="roof_area" id="No" placeholder="">
                    @error('roof_size')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="No">Garden Area</label>
                    <input type="number" name="garden_area" id="No" placeholder="">
                    @error('garden_size')
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
                        <label for="location">Location</label>
                       <select name="location" id="input" required class="form-select">
                            <option value="">اختر الموقع</option>
                            <option value="مدينة 6 أكتوبر">مدينة 6 أكتوبر</option>
                            <option value="القاهرة الجديدة">القاهرة الجديدة</option>
                            <option value="العاصمة الإدارية الجديدة">العاصمة الإدارية الجديدة</option>
                            <option value="الشيخ زايد">الشيخ زايد</option>
                            <option value="الشيخ زايد الجديدة">الشيخ زايد الجديدة</option>
                            <option value="مدينة المستقبل">مدينة المستقبل</option>
                            <option value="العين السخنة">العين السخنة</option>
                            <option value="الجونة">الجونة</option>
                            <option value="هليوبوليس الجديدة">هليوبوليس الجديدة</option>
                            <option value="الشروق">الشروق</option>
                         </select>

                        @error('location')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                       @enderror
                    </div>

                    <div class="form-group">
                        <label for="link">Link of Location</label>
                        <input type="url" id="link" name="location_link" placeholder="Enter link">
                        @error('location_link')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                       @enderror
                    </div>
                    
                    <div class="form-group">
                    <label for="price">lat</label>
                    <input type="number" step="any" name="lat" id="input" placeholder="Enter lat">
                    @error('lat')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                   @enderror
                </div>
                <div class="form-group">
                    <label for="price">lng</label>
                    <input type="number" step="any" name="lng" id="input" placeholder="Enter lng">
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
                    <input type="number" name="price" id="input" placeholder="Enter price">
                    @error('price')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                   @enderror
                </div>
                <div class="form-group">
                    <label for="downPayment">Down Payment</label>
                    <input type="number"  name="down_payment" id="input" placeholder="%">
                    @error('down_payment')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                   @enderror
                </div>
                <div class="form-group">
                    <label for="pricePerMeter">stutes</label>
                    <select id="input" name="status" class="form-select">
                        <option value="">Select status</option>
                        <option value="available">Available</option>
                        <option value="sold">Sold</option>
                        <option value="reserved">Reserved</option>
                    </select>
                    @error('status')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Installment Options</label>
                    <div id="installmentContainer">
                        <div class="installment-option">
                            <input type="number" name="installments[0][years]" class="form-control mb-2" placeholder="Years">
                            <input type="number" name="installments[0][initial_price]" class="form-control mb-2" placeholder="Initial Price">
                            <input type="number" name="installments[0][monthly]" class="form-control mb-2" placeholder="Monthly Payment">
                        </div>
                    </div>
                    <button type="button" onclick="addInstallment()" class="btn btn-secondary btn-sm">+ Add Installment Option</button>
                </div>

            </div>
            </div>
        </div>

        <!-- developer Details Section -->

        <div class="form-section">
            <label for="fa1" class="section-title">developer Details</label>
            <div class="section1">
                <div class="form-row" style="display: flex !important; gap: 15px; flex-wrap: wrap; align-items: flex-end;">
                    <div class="form-group" style="flex: 1 1 8%; min-width: 200px;">
                        <label for="projectName">developer</label>
                        <select id="input" name="developer_id" required class="form-select">
                            <option value="">Select Developer</option>
                            @foreach($developers as $developer)
                                <option value="{{ $developer->id }}">{{ $developer->name }}</option>
                            @endforeach
                        </select>
                        @error('developer_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group" style="flex: 1 1 8%; min-width: 200px;">
                        <label for="projectType">project</label>
                        <select id="input" name="project_id" required>
                            <option value="">Select a project</option>
                            @foreach($projects as $project)
                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                            @endforeach
                        </select>
                        @error('project_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group" style="flex: 1 1 30%; min-width: 200px;">
                        <label for="location">sales</label>
                        <select id="input" name="sales_id" required>
                            <option value="">Select a salesperson</option>
                            @foreach($salespeople as $salesperson)
                                <option value="{{ $salesperson->id }}">{{ $salesperson->name }}</option>
                            @endforeach
                        </select>
                        @error('sales_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" placeholder="Enter description"></textarea>
                        @error('description')
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
