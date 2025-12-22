<!DOCTYPE html>
<html dir="rtl">
<head>
    <title>استيراد وحدات</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">استيراد وحدات من ملف CSV</h3>
            </div>

            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                @if(session('import_errors'))
                    <div class="alert alert-danger">
                        <h5>الأخطاء:</h5>
                        <ul>
                            @foreach(session('import_errors') as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('units.import') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="csv_file" class="form-label">اختر ملف CSV:</label>
                        <input
                            type="file"
                            class="form-control"
                            name="csv_file"
                            accept=".csv,.txt"
                            required
                        >
                        <small class="form-text text-muted">
                            يجب أن يحتوي الملف على الأعمدة التالية بالترتيب:<br>
                            property_name, project_id, type, size, price, location, location_link, description, list_of_description, images, down_payment, installment_options, bathrooms, rooms, has_garden, garden_size, has_roof, roof_size, status, developer_id
                        </small>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-upload me-2"></i> بدء الاستيراد
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
