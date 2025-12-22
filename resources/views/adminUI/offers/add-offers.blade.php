<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New offer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="icon" type="image/png" sizes="50x50" href="{{ asset('images/logo.png') }}">

    <style>
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
            margin-inline: 30;
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
            background-color: #0a9e6d;
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
            inline-size: 80%;
            color: black;
            font-size: 44.43px;
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
            inline-size: 60px;
            block-size: 60px;
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

        @media (max-inline-size: 768px ) {
            .form-section {
                flex-direction: column;
                gap: 10px;
            }

            .form-section .left,
            .form-section .right {
                inline-size: 100%;
                position: relative;
                inset: auto;
                margin: 0;
            }

            .upload-area {
                margin-inline-start: 0;
                padding: 20px;
                inline-size: 100%;
            }

                .btn-publish {
                    inline-size: 100%;/* عرض الزر يكون كامل الصفحة */
                    position: static; /* إلغاء تحديد الموقع المطلق */
                    margin-block-start: 10px; /* إضافة مسافة علوية للزر */
                    margin-inline: 0; /* إزالة الهوامش الجانبية */
        }

                .container {
                    padding: 15px;
                    min-block-size: auto;
                }
            }
    </style>

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
</head>
<body>
<div class="container">
    <a href="{{ route('offers.show') }}" style="text-decoration: none;">
        <div style="display: flex; align-items: center; inline-size: 197px; block-size: 50px; margin-block-end: 20px; position: relative;">
            <div style="color: rgb(5, 5, 5); font-size: 30.30px; font-family: Poppins; font-weight: 400; line-height: 45.45px; margin-inline-end: 10px;">←</div>
            <div  style="color: black; font-size: 11.69px; font-family: Poppins; font-weight: 400; line-height: 17.54px;">Back</div>
        </div>
    </a>
    <h2 style="margin-block-start: 30px; margin-inline-start: 40px;font-size: 40px; font-family: Urbanist; font-weight: 600; line-height: 60.72px; word-wrap: break-word">Add New offer</h2>
    <form action="{{ route('offers.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="upload-area">
            <label for="imageUpload" class="block text-sm font-medium text-gray-700">Upload Images</label>
            <input type="file" id="imageUpload" name="image" style="display: none;" accept="image/*">
            <p>Click here to upload your files or drag.</p>
            <p class="text-muted">Supported formats: SVG, JPG, PNG (1200 x 800)</p>
            <button type="button" onclick="document.getElementById('imageUpload').click();" style="...">
                <span style="...">Add Image</span>
            </button>
            <div id="uploadMessage" style="margin-block-start: 15px; color: green; font-size: 14px; display: none;">
                Images added successfully!
            </div>
            @error('image')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-section">
            <div class="right">
                <div class="mb-3">
                    <label for="title" class="form-label">offer Title</label>
                    <input type="text" id="title" name="title" class="form-control" placeholder="Add offer Title">
                    @error('title')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-font1" style="...">Add Description</label>
                    <textarea id="description" name="description" class="form-control" rows="6" placeholder="Click to edit..."></textarea>
                    @error('description')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="developer_id" class="form-font1">Select Developer</label>
                    <select id="developer_id" name="developer_id" required class="form-select">
                        <option value="">Select Developer</option>
                        @foreach($developers as $developer)
                            <option value="{{ $developer->id }}">{{ $developer->name }}</option>
                        @endforeach
                    </select>
                    @error('developer_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="phone_number" class="form-font1">Phone Number</label>
                    <input type="text" id="phone_number" name="phone_number" class="form-control" placeholder="Enter phone number">
                    @error('phone_number')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3" style="display: flex; flex-direction: column; align-items: flex-start; gap: 5px;">
                    <!-- التسمية فوق الإدخال -->
                    <label for="downpayment" class="form-font1" style="margin-block-end: 5px;">downpayment</label>

                    <!-- حقل الإدخال -->
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <input
                            type="text"
                            id="downpayment"
                            name="downpayment"
                            class="form-control1"
                            placeholder="0"
                        >

                        <!-- دائرة العلامة % -->
                        <div style="inline-size: 40px;  block-size: 40px;  display: flex; justify-content: center; align-items: center; border-radius: 50%; border: 2px solid #ccc; font-size: 14px; font-weight: bold; color: #666;">
                            %
                        </div>
                    </div>
                </div>

                <!-- Installment Years -->
                <div class="mb-3" style="display: flex; flex-direction: column; align-items: flex-start; gap: 5px;">
                    <!-- التسمية فوق الإدخال -->
                    <label for="installment_years" class="form-font1" style=" margin-block-end: 5px;">Installment Years</label>

                    <!-- حقل الإدخال -->
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <input
                            type="text"
                            id="installment_years"
                            name="installment_years"
                            class="form-control1"
                            placeholder="0"
                        >

                        <!-- دائرة الكلمة "year" -->
                        <div style=" inline-size: 50px; block-size: 40px;display: flex; justify-content: center; align-items: center; border-radius: 50%; border: 2px solid #ccc; font-size: 14px; font-weight: bold; color: #666;">
                            year
                        </div>
                    </div>
                </div>





            </div>
        </div>

        <div class="justify-content-end mt-4">
            <button type="submit" class="btn btn-publish me-2 btn-custom">Publish</button>
            <a href="{{ route('offers.show') }}" class="btn btn-cancel btn-custom">Cancel</a>

        </div>
    </form>

</div>
</body>
</html>
