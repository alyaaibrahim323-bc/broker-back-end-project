<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="icon" type="image/png" sizes="50x50" href="{{ asset('images/logo.png') }}">

  <title>Design Form</title>
  <style>
    * {
      box-sizing: border-box;
      font-family: 'Arial', sans-serif;
    }

    body {
      background-color: #f0f4fc;
      display: flex;
      justify-content: center;
      align-items: center;
      /* block-size: 100vh; */
      margin: 6;
    }

    .container {
      inline-size: 1100px;
      background-color: #ffffff;
      border-radius: 15px;
      padding: 40px;
      display: flex;
      flex-direction: column;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .section {
        margin-block-end: 10px;

      flex: 1;
    }

    .section h2 {
      font-size: 16px;
      color: #1f7a5b;
      margin-block-end: 20px;
      font-weight: normal;
    }

    .upload-name-container {
      display: flex;
      align-items: center;
      gap: 20px; /* مسافة بين الصورة وإدخال الاسم */
      margin-block-end: 20px;
    }

    .upload-box {
      inline-size: 258px;
      block-size: 325px;
      display: flex;
      justify-content: center;
      align-items: center;
      border-radius: 30px;
      background-color: #F7F7FC;
      box-shadow: 0px 5px 25px rgba(47, 128, 237, 0.2);
      color: #a0aec0;
      font-size: 14px;
      text-align: center;
      flex-direction: column;
    }

    .upload-box button {
      margin-block-start: 10px;
      padding: 8px 16px;
      background-color: #0a9e6d;
      color: #fffff;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 14px;
    }

    .input-group {
      margin-block-end: 15px;
      display: flex;
      flex-direction: column;
    }

    .input-group label {
      font-size: 15px;
      color: #1d1b1b;
      display: block;
      margin-block-end: 5px;
    }

    .input-group input {
      inline-size: 100%; /* لجعل المدخلات تتكيف مع العرض */
      max-inline-size: 300px;
      padding: 10px;
      font-size: 14px;
      border: 1px solid #e2e8f0;
      border-radius: 10px;
      background-color: #ffffff;
      color: #2d3748;
    }

    .details-container {
      display: flex;
      gap: 80px; /* مسافة بين القسمين */
    }

    .buttons-container {
      display: flex;
      justify-content: flex-end; /* نقل الزر إلى الجهة اليمنى */
    }

    .btn {
      padding: 15px 35px;
      font-size: 16px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .btn.add {
      background-color: #0a9e6d;
      color: white;
    }

    .btn.add:hover {
      background-color: #0a9e6d;
    }

    .role-container {
    display: flex;
    flex-direction: column;
    gap: 10px; /* مسافة بين العناصر */
    margin-bottom: 20px;
}

.role-container label {
    font-size: 14px;
    color: #1f7a5b;
    font-weight: bold;
}

.role-container select {
    width: 100%;
    max-width: 140px; /* حد أقصى للعرض */
    padding: 10px;
    font-size: 14px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    background-color: #ffffff;
    color: #2d3748;
    transition: border 0.3s, box-shadow 0.3s;
}

.role-container select:focus {
    border-color: #3d9cff;
    box-shadow: 0 0 8px rgba(61, 156, 255, 0.3);
    outline: none;
}

.role-container .text-danger {
    font-size: 12px;
    color: #e53e3e;
    margin-top: 5px;
}


  </style>
</head>
<body>
<div class="container">
    <a href="{{ route('users.show') }}" style="text-decoration: none;">
        <div style="display: flex; align-items: center; inline-size: 197px; block-size: 50px; margin-block-end: 20px; position: relative;">
            <div style="color: rgb(5, 5, 5); font-size: 30.30px; font-family: Poppins; font-weight: 400; line-height: 45.45px; margin-inline-end: 10px;">←</div>
            <div  style="color: black; font-size: 11.69px; font-family: Poppins; font-weight: 400; line-height: 17.54px;">Back</div>
        </div>
    </a>
    <form method="POST" action="{{  route('users.UPdate', $user->id)  }}" enctype="multipart/form-data">
        @csrf
        @if(isset($user))
            @method('PUT') <!-- طريقة HTTP للتعديل -->
        @endif

        <!-- Personal Details Section -->
        <div class="section">
            <h2 style="margin-block-end: 30px; font-size: 24px; color: #1f7a5b;">Personal Details</h2>
            <div class="upload-name-container">
                <!-- Upload Box -->
                <div class="upload-box">
                    <div>Upload personal photo or drag and drop here</div>
                    <input type="file" name="image" accept="image/*" id="photoInput" style="display: none;">
                    <button type="button" onclick="document.getElementById('photoInput').click()">Add Image</button>
                </div>
                <!-- Name Input -->
                <div class="input-group">
                    <label>Name</label>
                    <input type="text" name="name" placeholder="add name" value="{{ old('name', $user->name ?? '') }}" required>
                </div>
            </div>
        </div>

        <!-- Address and Contact Details Section Side by Side -->
        <div class="details-container">
            <!-- Address Section -->
            <div class="section">
                <h2>Address</h2>
                <div class="input-group">
                    <label>City</label>
                    <input type="text" name="city" placeholder="choose city" value="{{ old('city', $user->city ?? '') }}">
                </div>
            </div>

            <!-- Contact Details Section -->
            <div class="section">
                <h2>Contact Details</h2>
                <div class="input-group">
                    <label>Phone Number</label>
                    <input type="text" name="phone_number" placeholder="add phone number" value="{{ old('phone_number', $user->phone_number ?? '') }}">
                </div>
                <div class="input-group">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="add email" value="{{ old('email', $user->email ?? '') }}" required>
                </div>
            </div>
        </div>

        <div class="input-group">
            <label for="password">كلمة المرور</label>
            <input type="password" name="password" id="password" placeholder="أدخل كلمة المرور" {{ isset($user) ? '' : 'required' }}>
        </div>

        <div class="input-group">
            <label for="password_confirmation">تأكيد كلمة المرور</label>
            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="أعد إدخال كلمة المرور" {{ isset($user) ? '' : 'required' }}>
        </div>

        <!-- Roles Field -->
        <div class="row mb-3">
            <div class="role-container">
                <label for="roles">Roles</label>
                <select name="roles[]" class="form-control" multiple>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}" {{ isset($user) && in_array($role->name, $user->roles->pluck('name')->toArray()) ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
                @error('roles')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Buttons Section -->
        <div class="buttons-container">
            <button type="submit" class="btn add">{{ isset($user) ? 'Update' : 'Add' }}</button>
        </div>
    </form>

</div>
</body>
</html>
