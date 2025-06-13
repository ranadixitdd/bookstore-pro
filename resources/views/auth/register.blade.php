<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register | Book Haven</title>
  <link rel="icon" href="{{ asset('book-icon.png') }}?v=2" type="image/png">
  <!-- Font Awesome & Bootstrap -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Success Sound-->


  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      padding: 0;
      overflow: hidden;
      background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
      height: 100vh;
      position: relative;
    }

    #particles-js {
      position: fixed;
      width: 100%;
      height: 100%;
      z-index: 0;
    }

    .form-container {
      position: relative;
      z-index: 2;
      background: rgba(255, 255, 255, 0.07);
      backdrop-filter: blur(20px);
      padding: 30px;
      border-radius: 15px;
      border: 1px solid rgba(255, 255, 255, 0.2);
      box-shadow: 0 0 30px rgba(0, 255, 255, 0.1);
      width: 370px;
      color: #fff;
      margin: auto;
      top: 50%;
      transform: translateY(-50%);
      animation: floatCard 6s ease-in-out infinite;
    }

    @keyframes floatCard {
      0%, 100% { transform: translateY(-50%) translateX(0); }
      50% { transform: translateY(-55%) translateX(0); }
    }

    .form-container h3 {
      font-size: 26px;
      color: #00f7ff;
      text-shadow: 0 0 5px #00f7ff;
      text-align: center;
      margin-bottom: 20px;
    }

    .box {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: none;
      border-radius: 8px;
      background: rgba(255, 255, 255, 0.2);
      color: #fff;
      box-shadow: 0 0 5px #00ffe7;
    }

    .box::placeholder { color: #ccc; }

    .input-group .toggle-password {
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      color: #00ffe7;
      cursor: pointer;
    }

    .box-btn {
      background: #00ffe7;
      color: #111;
      font-weight: bold;
      padding: 12px;
      border-radius: 8px;
      border: none;
      margin-top: 15px;
      width: 100%;
      transition: 0.3s ease;
      box-shadow: 0 0 10px #00ffe7, 0 0 40px #00ffe7;
    }

    .box-btn:hover {
      background: #00c2b5;
      box-shadow: 0 0 15px #00ffe7, 0 0 60px #00ffe7;
    }

    .shake {
      animation: shake 0.4s ease-in-out;
    }

    @keyframes shake {
      0%, 100% { transform: translateX(0px); }
      25%, 75% { transform: translateX(-5px); }
      50% { transform: translateX(5px); }
    }

    .error-message {
      color: #ff6b6b;
      font-size: 13px;
    }

    a { color: #00ffe7; text-decoration: none; }
    a:hover { text-decoration: underline; }

    .toast-container {
      position: fixed;
      bottom: 20px;
      right: 20px;
      z-index: 9999;
    }
  </style>
</head>
<body>

<!-- ✨ Particles Background -->
<div id="particles-js"></div>

<div class="form-container {{ $errors->any() ? 'shake' : '' }}">
  <h3>Register</h3>
  <form action="{{ route('register') }}" method="POST">
    @csrf

    <input type="text" name="name" placeholder="Enter your name" value="{{ old('name') }}" class="box" required>
    @error('name') <div class="error-message">{{ $message }}</div> @enderror

    <input type="email" name="email" placeholder="Enter your email" value="{{ old('email') }}" class="box" required>
    @error('email') <div class="error-message">{{ $message }}</div> @enderror

    <div class="input-group position-relative">
      <input type="password" name="password" id="password" placeholder="Enter password" class="box" required>
      <i class="fas fa-eye toggle-password" onclick="togglePassword()"></i>
    </div>
    @error('password') <div class="error-message">{{ $message }}</div> @enderror

    <input type="password" name="password_confirmation" placeholder="Confirm password" class="box" required>

    <button type="submit" class="box-btn" onclick="playSound()">Register Now</button>
    <p class="text-center mt-2">Already have an account? <a href="{{ route('login') }}">Login here</a></p>
  </form>
</div>

<!-- 🎉 Toast -->
@if(session('status'))
<div class="toast-container">
  <div class="toast show text-white bg-success">
    <div class="toast-body">{{ session('status') }}</div>
  </div>
</div>
@endif

<!-- 🧠 Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/particles.js"></script>

<script>
  function togglePassword() {
    const passwordField = document.getElementById("password");
    const icon = document.querySelector(".toggle-password");
    passwordField.type = passwordField.type === "password" ? "text" : "password";
    icon.classList.toggle("fa-eye");
    icon.classList.toggle("fa-eye-slash");
  }

  function playSound() {
    const sound = document.getElementById("successSound");
    sound && sound.play();
  }

  // 💫 Fun particles config
  particlesJS("particles-js", {
    "particles": {
      "number": { "value": 80, "density": { "enable": true, "value_area": 800 } },
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

</body>
</html>
