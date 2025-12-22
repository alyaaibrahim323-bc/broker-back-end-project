<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title >Add New developer</title>
        <link rel="icon" type="image/png" sizes="50x50" href="{{ asset('images/logo.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: sans-serif;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .container {
        max-inline-size: 1600px;
        background-color: #fff;
        padding: 30px;
        border-radius: 28px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        position: relative;
        min-block-size: 1000px;
    }
       .upload-area {
    max-inline-size: 600px;
    border: 2px solid transparent; /* إزالة البوردر الافتراضي */
    border-radius: 40px;
    padding: 60px;
    text-align: center;
    margin-block-end: 30px;
    background-color: #F7F7FC;
    cursor: pointer;
    margin-block-start: 60px;
    margin-inline-start: 70px;
    transition: border-color 0.3s ease,*/
}

/* عند الوقوف Hover */
.upload-area:hover,
{
    border-color: #2684FF; /* أزرق */
   
}

        .upload-area p {
            color: #666;
        }
        .form-section {
            display: flex;
            gap: 20px;
            justify-content: space-between;


        }

        .form-section .left {
            inline-size: 48%;
        }

        .form-section .right {
            position: absolute;
            inset-block-start: 5cm;
            inset-inline-end:6cm;
            inline-size: 350px;
            margin: 20px;

        }

        .btn-custom {

            padding: 15px 23px;
            background: #E9E9E9;
            border-radius: 10.85px;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            font-family: sans-serif;
            font-weight: 500;
            font-size: 16px;
            color: #4C4C4C;
            line-height: 1.2;
            border: none;
            cursor: pointer;
        }

        .btn-publish {
            position: absolute;
            inset-block-start: 24cm;
            inset-inline-end:3.4cm;
            background-color:#0a9e6d;
        }

        .btn-cancel {
            position: absolute;
            inset-block-start: 24cm;
            inset-inline-end:1cm;
            background-color: #dc3545;
            color: #fff; /* لتكون النصوص بيضاء على الزر الأحمر */
        }

        .form-control, .form-select {
            border-radius: 4px;
        }
        .form-label {
            inline-size: 80%;
            color: black;
            font-size: 34.43px;
            font-family: sans-serif;
            font-weight: 500;
            line-height: 51.65px;
            word-wrap: break-word;
        }
        .form-control {
           inline-size: 70%;
           block-size: 100%;
            background: #F7F7FC;
            border-radius: 37.34px;
            padding: 17px 15px; /* لضبط المسافة داخل الحقل */
            border: 1px solid #ccc; /* يمكنك تغيير اللون إذا لزم الأمر */
            box-sizing: border-box; /* التأكد من أن padding لا يؤثر على الأبعاد */
        }

        .from-font1 {
           inline-size: 100%;
            color: #080808;
            font-size: 20.04px;
            font-family: sans-serif;
            font-weight: 500;
            line-height: 40.56px;
            word-wrap: break-word;
        }
        .form-select {
           inline-size: 100%;
           block-size: 100%;
            background: #F7F7FC;
            border-radius: 37.34px;
            padding: 10px;
            border: 1px solid #E0E0E0; /* يمكنك تعديل اللون حسب الحاجة */
            font-family: Urbanist, sans-serif;
            font-size: 16px;
        }




.form-section .right {
    inline-size: 30%; /* تقليل العرض قليلاً */

}





    </style>
       <script>
        function goBack() {
            window.history.back();
        }
    </script>
    <script>

    function toggleInput(id) {
        var element = document.getElementById(id);
        element.style.display = (element.style.display === "none") ? "block" : "none";
    }
        function handleFileSelect() {
        const input = document.getElementById('imageUpload');
        const message = document.getElementById('uploadMessage');

        if (input.files.length > 0) {
            message.style.display = 'block';
            message.textContent = `${input.files.length} image(s) added successfully!`;
        } else {
            message.style.display = 'none';
        }
    }
    </script>
    <script>
        // دالة لعرض رسالة النجاح بدون إخفاء تلقائي
        function showUploadSuccess() {
            const uploadMessage = document.getElementById('uploadMessage');
            const fileInput = document.getElementById('imageUpload');

            if (fileInput.files.length > 0) {
                uploadMessage.style.display = 'none'; // إخفاء الرسالة الحالية
                uploadMessage.style.display = 'block'; // إظهار الرسالة بشكل دائم
            }
        }
        </script>
</head>
<body>
<div class="container">
    <a href="{{ route('developers.show') }}" style="text-decoration: none;">
        <div style="display: flex; align-items: center; inline-size: 197px; block-size: 50px; margin-block-end: 20px; position: relative;">
            <div style="color: rgb(5, 5, 5); font-size: 30.30px; font-family: Poppins; font-weight: 400; line-height: 45.45px; margin-inline-end: 10px;">←</div>
            <div  style="color: black; font-size: 17.69px; font-family: Poppins; font-weight: 450; line-height: 17.54px;">Back</div>
        </div>
    </a>
<h2 style="margin-block-start: 30px; margin-inline-start: 40px; font-size: 40.48px; font-family: sans-serif; font-weight: semibold; line-height: 150%; word-wrap: break-word">
    Add New Developer
</h2>
    <form action="{{ route('developers.save') }}" method="POST" enctype="multipart/form-data">
                @csrf
    <div class="upload-area">
    <label for="imageUpload" class="block text-sm font-medium text-gray-700">Upload Images</label>

    <!-- حقل الإدخال مع حدث onchange -->
    <input 
        type="file" 
        id="imageUpload" 
        name="image" 
        style="display: none;" 
        accept="image/*"
        onchange="showUploadSuccess()"
    >

    <!-- الرسالة الإرشادية -->
    <p>Click here to upload your files or drag.</p>
    <p class="text-muted">Supported formats: SVG, JPG, PNG (1200 x 800)</p>

    <!-- زر إضافة الصور -->
    <button 
        type="button" 
        onclick="document.getElementById('imageUpload').click();" 
        style="inline-size: 70%; block-size: 70%; padding: 15px; background: rgba(255, 255, 255, 0.80); box-shadow: 0px 1px 61px 1px rgba(0, 0, 0, 0.25); border-radius: 120px; overflow: hidden; backdrop-filter: blur(20px); display: flex; justify-content: center; align-items: center; cursor: pointer; border: none; margin-block-start: 30px; margin-inline-start: 30px;"
    >
        <div style="border-radius: 30px; display: flex; justify-content: center; align-items: center;">
            <span style="color: black; font-size: 15px; font-family: Poppins; font-weight: 400; letter-spacing: 0.15px;">Add Image</span>
        </div>
    </button>

    <!-- رسالة النجاح (ستظهر عند اختيار صورة وتبقى ثابتة) -->
    <div 
        id="uploadMessage" 
        style="margin-block-start: 15px; color: green; font-size: 25px; display: none;"
    >
        تم اضاقه الصوره بنجاح!
    </div>

    <!-- عرض الأخطاء -->
    @error('image')
        <span class="text-red-500 text-sm">{{ $message }}</span>
    @enderror
</div>
        <div class="form-section">
            <!-- Left Section -->
            <div class="left">
                <div class="mb-3">
                    <label for="description"  style=" margin-block-start: 60px; margin-inline-start: 70px;inline-size: 100%;color: #080808; font-size: 37.47px; font-family: sans-serif; font-weight: 540; line-height: 56.20px; word-wrap: break-word;">Add Description</label>
                    <textarea style="margin-block-start: 0px; margin-inline-start: 70px;  inline-size: 450px;" id="description" name="description" class="form-control" rows="9ش" placeholder="Click to edit..."></textarea>
                    @error('description')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <!-- Right Section -->
            <div class="right">
                <div class="mb-3 mt-2">
                    <label for="name_project" class="form-label">Add developer Name</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Add developer Name">
                    @error('name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                   @enderror
                </div>

                <div class="mb-3 mt-5">
                    <label for="contact_info" class="form-label">Phone Number</label>
                    <input type="text" id="contact_info" name="contact_info" class="form-control" placeholder=" contact_us">
                    @error('contact_info')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                   @enderror
                </div>

                <div class="mb-3 mt-5">
                    <label for="location" class="form-label">Add office Location</label>
                   <select type="text" id="location" name="location" class="form-control" placeholder="Enter location">
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
        <!-- Buttons -->
        <div class=" justify-content-end mt-4">
            <button type="submit" class="btn btn-publish me-2 btn-custom">Publish</button>
            <button class="btn-cancel btn-custom" type="button" onclick="goBack()">Cancel</button>

        </div>
    </form>
</div>
</body>
</html>
