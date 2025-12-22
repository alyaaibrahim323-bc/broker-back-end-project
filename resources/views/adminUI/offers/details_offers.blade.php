<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New offer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="icon" type="image/png" sizes="50x50" href="{{ asset('images/logo.png') }}">

    <style>
       /* الكود الأساسي كما هو */
body {
    font-family: Arial, sans-serif;
    padding: 20px;
    background-color: #f8f9fa;
}

.container {
    max-inline-size: 1500px;
    background-color: #fff;
    padding: 30px;
    border-radius: 26px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    position: relative;
    min-block-size: 1100px;
}

.upload-area {
    max-inline-size: 500px;
    border: 2px solid #ccc;
    border-radius: 10px;
    padding: 60px;
    text-align: center;
    margin-block-end: 30px;
    background-color: #F7F7FC;
    cursor: pointer;
    border-radius: 40px;
    margin-block-start: 60px;
    margin-inline-start: 70px;
}

.upload-area:hover {
    border-color: #1f7a5b;
}

.upload-area p {
    color: #1f7a5b;
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
    inset-block-start: 4cm;
    inset-inline-end: 6cm;
    inline-size: 450px;
    margin: 20px;
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
    position: absolute;
    inset-block-start: 27cm;
    inset-inline-end: 3.4cm;
    background-color:#0a9e6d;
}

.btn-cancel {
    position: absolute;
    inset-block-start: 27cm;
    inset-inline-end: 1cm;
    background-color: #dc3545;
    color: #fff;
}

.form-control, .form-select {
    border-radius: 4px;
}

.form-label {
    inline-size: 70%;
    color: black;
    font-size: 34.43px;
    font-family: Urbanist, sans-serif;
    font-weight: 500;
    line-height: 51.65px;
    word-wrap: break-word;
}

.form-control {
    inline-size: 70%;
    block-size: 100%;
    background: #F7F7FC;
    border-radius: 37.34px;
    padding: 10px 15px;
    border: 1px solid #ccc;
    box-sizing: border-box;
}

.form-font1 {
    inline-size: 100%;
    color: #080808;
    font-size: 30.04px;
    font-family: Urbanist;
    font-weight: 500;
    line-height: 40.56px;
    word-wrap: break-word;
}

.form-select {
    inline-size: 70%;
    block-size: 100%;
    background: #F7F7FC;
    border-radius: 37.34px;
    padding: 10px;
    border: 1px solid #E0E0E0;
    font-family: Urbanist, sans-serif;
    font-size: 16px;
}

.form-control1 {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: #F7F7FC;
    border: 2px solid #ccc;
    text-align: center;
    font-size: 14px;
    outline: none;
    display: inline-block;
}

.form-control1:focus {
    border-color: #007bff;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
}
/* تحسين وسائل الاستعلام للشاشات الصغيرة */
@media (max-width: 768px) {
    .form-section {
        display: flex; /* استخدام flexbox لتوزيع العناصر بشكل صحيح */
        flex-direction: column;
        gap: 15px;
        align-items: center; /* محاذاة العناصر للوسط */
        width: 100%;
    }

    .form-section .left,
    .form-section .right {
        width: 100%; /* تأكد من أن الحقول تمتد لعرض الشاشة */
        margin-inline-start: 0; /* إزالة أي انحراف للشمال */
        position: relative;
    }

    .upload-area {
        margin-inline-start: 0;
        margin-block-start: 20px;
        padding: 30px;
        width: 100%; /* اجعلها تمتد لعرض الشاشة */
        box-sizing: border-box; /* التأكد من أن الحشو لا يؤثر على العرض */
    }

    .form-control,
    .form-select {
        width: 100%; /* تأكد من أن الحقول تمتد لعرض الشاشة */
        padding: 12px;
        margin: 10px 0; /* مسافة بين الحقول */
        font-size: 16px; /* حجم الخط مناسب */
        box-sizing: border-box; /* لضمان أن الحقول تتناسب مع عرضها */
        display: block; /* التأكد من أن الحقول تأخذ سطر كامل */
    }

    .form-label {
        font-size: 20px;
        text-align: center; /* محاذاة النص للوسط */
    }

    .btn-publish,
    .btn-cancel {
        width: 100%; /* اجعل الأزرار تمتد لعرض الشاشة */
        padding: 12px;
        font-size: 16px; /* تحسين حجم الأزرار */
        margin-block-start: 20px;
    }
}

/* تحسين الشاشات الصغيرة جدًا */
@media (max-width: 480px) {
    .container {
        padding: 15px;
        overflow: hidden; /* التأكد من منع الانزلاق الجانبي */
    }

    .upload-area {
        padding: 20px;
        width: 100%; /* تأكد من أن المنطقة لا تتجاوز العرض */
        margin-inline: 0; /* إزالة أي انحراف */
        box-sizing: border-box;
    }

    .form-label {
        font-size: 18px;
        text-align: center;
    }

    .form-control,
    .form-select {
        width: 100%; /* تأكد من أن الحقول تمتد لعرض الشاشة */
        font-size: 14px;
        padding: 10px;
        margin-inline: 0; /* إزالة الانحراف */
        box-sizing: border-box;
    }

    .btn-custom {
        padding: 10px 15px;
        font-size: 14px;
    }

    .form-control1 {
        width: 50px;
        height: 50px;
        font-size: 12px;
    }
}





    </style>


    <script>

function previewImage(event) {
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = function() {
            const imagePreview = document.getElementById('imagePreview');
            imagePreview.src = reader.result;
        };

        if (file) {
            reader.readAsDataURL(file);
        }
    }
    </script>
</head>
<body>
    <div class="container">
        <a href="{{ route('offers.show') }}" style="text-decoration: none;">
            <div style="display: flex; align-items: center; inline-size: 197px; block-size: 50px; margin-block-end: 20px; position: relative;">
                <div style="color: rgb(5, 5, 5); font-size: 30.30px; font-family: Poppins; font-weight: 400; line-height: 45.45px; margin-inline-end: 10px;">←</div>
                <div  style="color: black; font-size: 11.69px; font-family: Poppins; font-weight: 400; line-height: 17.54px;">Back</div>
            </div>
        </a>
        <h2 style="margin-block-start: 30px; margin-inline-start: 40px;font-size: 40.48px; font-family: Urbanist; font-weight: 600; line-height: 60.72px; word-wrap: break-word">offers detalis</h2>
        <form action="{{ route('offers.update', $offer->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="upload-area" style="position: relative; width: 100%; height: 300px; border: 1px solid #ccc; border-radius: 50px; display: flex; justify-content: center; align-items: center; overflow: hidden;">
                <!-- Input file مخفي -->
                <input type="file" id="imageUpload" name="image" style="display: none;" accept="image/*" onchange="previewImage(event)">

                <!-- صورة العرض -->
                <img id="imagePreview" src="{{ asset('storage/' . $offer->image ?? '') }}" alt="Click to upload image" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; cursor: pointer;" onclick="document.getElementById('imageUpload').click();">

                <!-- رسالة عند عدم وجود صورة -->
                @if(empty($offer->image))
                    <p style="position: absolute; text-align: center; color: #666;">Click here to upload your files or drag.<br><span class="text-muted" style="font-size: 12px;">Supported formats: SVG, JPG, PNG (1200 x 800)</span></p>
                @endif

                <!-- رسالة خطأ -->
                @error('image')
                    <span class="text-red-500 text-sm" style="position: absolute; bottom: 10px;">{{ $message }}</span>
                @enderror
            </div>





            <div class="form-section">
                <div class="right">
                    <div class="mb-3">
                        <label for="title" class="form-label">Offer Title</label>
                        <input type="text" id="title" name="title" class="form-control" value="{{ $offer->title }}" placeholder="Add Offer Title">
                        @error('title')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-font1" style="...">Add Description</label>
                        <textarea id="description" name="description" class="form-control" rows="6" placeholder="Click to edit...">{{ $offer->description }}</textarea>
                        @error('description')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="developer_id" class="form-font1">Select Developer</label>
                        <select id="developer_id" name="developer_id" required class="form-select">
                            <option value="">Select Developer</option>
                            @foreach($developers as $developer)
                                <option value="{{ $developer->id }}" {{ $developer->id == $offer->developer_id ? 'selected' : '' }}>{{ $developer->name }}</option>
                            @endforeach
                        </select>
                        @error('developer_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone_number" class="form-font1">Phone Number</label>
                        <input type="text" id="phone_number" name="phone_number" class="form-control" value="{{ $offer->phone_number }}" placeholder="Enter phone number">
                        @error('phone_number')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3" style="display: flex; flex-direction: column; align-items: flex-start; gap: 5px;">
                        <label for="downpayment" class="form-font1" style="margin-bottom: 5px;">Downpayment</label>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <input type="text" id="downpayment" name="downpayment" class="form-control1" value="{{ $offer->downpayment }}" placeholder="0">
                            <div style="width: 40px; height: 40px; display: flex; justify-content: center; align-items: center; border-radius: 50%; border: 2px solid #ccc; font-size: 14px; font-weight: bold; color: #666;">
                                %
                            </div>
                        </div>
                    </div>

                    <div class="mb-3" style="display: flex; flex-direction: column; align-items: flex-start; gap: 5px;">
                        <label for="installment_years" class="form-font1" style="margin-bottom: 5px;">Installment Years</label>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <input type="text" id="installment_years" name="installment_years" class="form-control1" value="{{ $offer->installment_years }}" placeholder="0">
                            <div style="width: 50px; height: 40px; display: flex; justify-content: center; align-items: center; border-radius: 50%; border: 2px solid #ccc; font-size: 14px; font-weight: bold; color: #666;">
                                year
                            </div>
                        </div>
                    </div>


                </div>
            </div>
            <div class="justify-content-end mt-1">
                <button type="submit" class="btn btn-publish me-2 btn-custom">Update Offer</button>
                <a href="{{ route('offers.show') }}" class="btn btn-cancel btn-custom">Cancel</a>
            </div>
        </form>
    </div>

</body>
</html>
