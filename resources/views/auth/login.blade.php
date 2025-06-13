<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login | Book Haven</title><link rel="icon" href="{{ asset('book-icon.png') }}?v=2" type="image/png">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      padding: 0;
      height: 100vh;
      overflow: hidden;
      background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
    }

    #particles-js {
      position: fixed;
      width: 100%;
      height: 100%;
      z-index: -1;
    }

    .welcome-message {
      text-align: center;
      font-size: 22px;
      font-weight: bold;
      color: #ffffff;
      text-shadow: 0 0 15px rgba(0, 255, 255, 0.6);
      margin-bottom: 20px;
    }

    .form-container {
      background: rgba(255, 255, 255, 0.07);
      backdrop-filter: blur(20px);
      padding: 30px;
      border-radius: 15px;
      border: 1px solid rgba(255, 255, 255, 0.2);
      box-shadow: 0 0 30px rgba(0, 255, 255, 0.2), 0 0 80px rgba(0, 255, 255, 0.05);
      color: #fff;
      width: 350px;
      animation: floatCard 3s ease-in-out infinite;
      transform-style: preserve-3d;
      will-change: transform;
    }

    @keyframes floatCard {
      0%, 100% {
        transform: translateY(-4px) rotateX(2deg) rotateY(2deg);
      }
      50% {
        transform: translateY(8px) rotateX(4deg) rotateY(4deg);
      }
    }

    .form-container.shake {
      animation: shake 0.4s ease-in-out;
    }

    @keyframes shake {
      0%, 100% { transform: translateX(0); }
      25% { transform: translateX(-5px); }
      75% { transform: translateX(5px); }
    }

    .form-container h3 {
      text-align: center;
      color: #00f7ff;
      margin-bottom: 20px;
      text-shadow: 0 0 5px #00f7ff;
    }

    .box {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: none;
      border-radius: 8px;
      font-size: 15px;
      background: rgba(255, 255, 255, 0.2);
      color: #fff;
      backdrop-filter: blur(10px);
      box-shadow: 0 0 5px #00ffe7;
    }

    .box::placeholder { color: #ccc; }

    .input-group {
      position: relative;
    }

    .toggle-password {
      position: absolute;
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      color: #00ffe7;
    }

    .box-btn {
      background: #00ffe7;
      color: #111;
      font-weight: bold;
      padding: 12px;
      border-radius: 8px;
      border: none;
      cursor: pointer;
      margin-top: 15px;
      width: 100%;
      box-shadow: 0 0 10px #00ffe7, 0 0 40px #00ffe7;
      transition: all 0.3s ease;
    }

    .box-btn:hover {
      background: #00c2b5;
      box-shadow: 0 0 15px #00ffe7, 0 0 60px #00ffe7;
    }

    .forgot-password {
      font-size: 12px;
      color: #ffb347;
      display: block;
      margin-top: 5px;
      text-decoration: underline;
    }

    .error-message {
      color: #ff6b6b;
      font-size: 13px;
      margin-top: -8px;
      margin-bottom: 10px;
    }

    a { color: #00ffe7; }
    a:hover { text-decoration: underline; }
  </style>
</head>
<body>

  <div id="particles-js"></div>

  <div class="container d-flex justify-content-center align-items-center flex-column vh-100">
    <div class="welcome-message">

      Welcome to Book Haven – Your Gateway to the Best Reads!
    </div>

    @if (session('success'))
  <div class="toast align-items-center text-bg-success border-0 position-fixed bottom-0 end-0 m-4 show" role="alert">
    <div class="d-flex">
      <div class="toast-body">
        {{ session('success') }}
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
    </div>
  </div>
@endif

@if (session('error'))
  <div class="toast align-items-center text-bg-danger border-0 position-fixed bottom-0 end-0 m-4 show" role="alert">
    <div class="d-flex">
      <div class="toast-body">
        {{ session('error') }}
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
    </div>
  </div>
@endif

    {{-- ✅ Bootstrap Alert on Success --}}
    @if(session('status'))
      <div class="alert alert-success alert-dismissible fade show text-center mt-3 w-100" role="alert" style="z-index: 9999;">
        {{ session('status') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <script>

        audio.play();
      </script>
    @endif

    <div class="form-container {{ ($errors->any()) ? 'shake' : '' }}">
      <h3>Login</h3>
      <form method="POST" action="{{ route('login') }}">
        @csrf

        <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" class="box" required>
        @error('email')
          <div class="error-message">{{ $message }}</div>
        @enderror

        <div class="input-group">
          <input type="password" id="password" name="password" placeholder="Enter your password" class="box" required>
          <i class="fas fa-eye toggle-password" onclick="togglePassword()"></i>
        </div>
        @error('password')
          <div class="error-message">{{ $message }}</div>
        @enderror

        <a href="{{ route('password.request') }}" class="forgot-password">Forgot Password?</a>

        <button type="submit" class="box-btn">Login Now</button>
        <p class="text-center mt-2">Don't have an account? <a href="{{ route('register') }}">Register here</a></p>
      </form>
    </div>
  </div>

  <!-- Particles.js -->
<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>

<script>
    particlesJS("particles-js", {
      "particles": {
        "number": {
          "value": 80, // more particles
          "density": { "enable": true, "value_area": 800 }
        },
        "color": { "value": "#00ffe7" },
        "shape": {
          "type": "circle",
          "stroke": { "width": 0, "color": "#000000" }
        },
        "opacity": {
          "value": 0.3,
          "random": true
        },
        "size": {
          "value": 3,
          "random": true
        },
        "line_linked": {
          "enable": true,
          "distance": 150,
          "color": "#00ffe7",
          "opacity": 0.2,
          "width": 1
        },
        "move": {
          "enable": true,
          "speed": 1.6,
          "direction": "none",
          "random": false,
          "straight": false,
          "bounce": true
        }
      },
      "interactivity": {
        "detect_on": "canvas",
        "events": {
          "onhover": { "enable": true, "mode": "repulse" },
          "onclick": { "enable": true, "mode": "push" },
          "resize": true
        },
        "modes": {
          "repulse": { "distance": 100, "duration": 0.4 },
          "push": { "particles_nb": 4 }
        }
      },
      "retina_detect": true
    });
  </script>


<!-- Toggle Password Visibility -->
<script>
  function togglePassword() {
    const passwordInput = document.getElementById("password");
    const icon = document.querySelector(".toggle-password");
    if (passwordInput.type === "password") {
      passwordInput.type = "text";
      icon.classList.remove("fa-eye");
      icon.classList.add("fa-eye-slash");
    } else {
      passwordInput.type = "password";
      icon.classList.remove("fa-eye-slash");
      icon.classList.add("fa-eye");
    }
  }
</script>

<!-- Bootstrap Toast -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const toastElList = [].slice.call(document.querySelectorAll('.toast'))
    const toastList = toastElList.map(function (toastEl) {
      return new bootstrap.Toast(toastEl, { delay: 5000 });
    });
    toastList.forEach(toast => toast.show());
  });
</script>

</body>
</html>
