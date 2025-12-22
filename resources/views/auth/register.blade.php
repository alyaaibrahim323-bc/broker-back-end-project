<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Register - Noya Dashboard</title>
  <style>
    /* نفس الستايل الأساسي للصفحة */
    * {
      box-sizing: border-box;
      margin: 0; padding: 0;
    }
    body, html {
      height: 100vh;
      width: 100vw;
      overflow: hidden;
      font-family: 'Figtree', sans-serif;
      background: black;
      position: relative;
      color: white;
    }

    .background-blur {
      position: fixed;
      top: 0; left: 0; right: 0; bottom: 0;
      z-index: 1;
      filter: blur(8px);
      overflow: hidden;
    }

    .white-overlay {
      position: fixed;
      inset: 0;
      background-color: rgba(255, 255, 255, 0.6);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      z-index: 2;
    }

    .register-popup {
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 1000px;
      max-width: 95vw;
      height: 600px;
      background: white;
      border-radius: 40px;
      display: flex;
      overflow: hidden;
      z-index: 3;
      color: black;
      box-shadow: 0 15px 40px rgba(0,0,0,0.3);
    }

    .left-side {
      position: relative;
      width: 65%;
      background-color: #000;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
      border-top-left-radius: 40px;
      border-bottom-left-radius: 40px;
    }

    .left-side img.logo {
      width: 500px;
      bottom: 10px;
      user-select: none;
      z-index: 2;
    }

    .left-side img.circle-image {
      position: absolute;
      bottom: 20px;
      left: -25px;
      width: 350px;
      transform: rotate(15deg);
      opacity: 0.8;
      user-select: none;
      z-index: 1;
      pointer-events: none;
    }

    .right-side {
      width: 35%;
      padding: 3rem 2.5rem;
      display: flex;
      flex-direction: column;
      justify-content: center;
      background: white;
      color: black;
    }

    .right-side h2 {
      font-size: 2rem;
      font-weight: 700;
      margin-bottom: 0.25rem;
    }

    .right-side p {
      font-size: 1rem;
      color: #666;
      margin-bottom: 1.5rem;
    }

    .right-side input {
      margin-bottom: 1.25rem;
      padding: 0.85rem 1rem;
      border-radius: 9999px;
      border: 1px solid #ccc;
      font-size: 1rem;
      outline: none;
      transition: border-color 0.3s;
      width: 100%;
    }

    .right-side input:focus {
      border-color: #92d000;
    }

    .right-side button {
      background-color: #92d000;
      color: white;
      font-weight: 600;
      padding: 0.85rem 1rem;
      border-radius: 9999px;
      cursor: pointer;
      border: none;
      font-size: 1.1rem;
      transition: background-color 0.3s;
      width: 100%;
      margin-top: 1rem;
    }

    .right-side button:hover {
      background-color: #7aba00;
    }

    .right-side a {
      margin-top: 1.25rem;
      font-size: 0.9rem;
      color: #666;
      text-decoration: none;
      text-align: center;
    }

    .right-side a:hover {
      color: #92d000;
    }

    .error-message {
      color: #ef4444;
      font-size: 0.875rem;
      margin-top: 0.25rem;
      margin-bottom: 1rem;
    }

    @media(max-width: 900px) {
      .register-popup {
        flex-direction: column;
        height: auto;
        width: 95vw;
        border-radius: 20px;
      }
      .left-side, .right-side {
        width: 100%;
      }
      .left-side {
        padding: 2rem 0;
        border-radius: 20px 20px 0 0;
      }
      .left-side img.logo {
        width: 150px;
      }
      .left-side img.circle-image {
        width: 100px;
        opacity: 0.2;
        transform: none;
        margin-bottom: 1rem;
      }
      .right-side {
        padding: 2rem 1rem 2rem;
        border-radius: 0 0 20px 20px;
      }
    }
  </style>
</head>
<body>
  <div class="background-blur">
    <img src="{{ asset('images/noya icon logo .png') }}" alt="logo" class="logo" />
  </div>
  <div class="white-overlay"></div>

  <div class="register-popup" role="dialog" aria-modal="true">
    <div class="left-side" aria-hidden="true">
      <img src="{{ asset('images/circle.png') }}" alt="circles" class="circle-image" />
      <img src="{{ asset('images/noya icon logo .png') }}" alt="Noya Logo" class="logo" />
    </div>

    <div class="right-side">
      <h2>Create Account</h2>
      <p>Start your journey with us</p>

      <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
          <input id="name" type="text" name="name" placeholder="Full Name"
                 value="{{ old('name') }}" required autofocus autocomplete="name" />
          @error('name')
            <div class="error-message">{{ $message }}</div>
          @enderror
        </div>

        <!-- Email -->
        <div>
          <input id="email" type="email" name="email"
                 placeholder="Email Address"
                 value="{{ old('email') }}" required autocomplete="email" />
          @error('email')
            <div class="error-message">{{ $message }}</div>
          @enderror
        </div>

        <!-- Password -->
        <div>
          <input id="password" type="password" name="password"
                 placeholder="Password" required autocomplete="new-password" />
          @error('password')
            <div class="error-message">{{ $message }}</div>
          @enderror
        </div>

        <!-- Confirm Password -->
        <div>
          <input id="password_confirmation" type="password"
                 name="password_confirmation"
                 placeholder="Confirm Password" required />
        </div>

        <button type="submit">Register</button>

        <a href="{{ route('login') }}">
          Already registered? Login here
        </a>
      </form>
    </div>
  </div>
</body>
</html>
