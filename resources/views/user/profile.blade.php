@extends('layouts.app')

@section('content')

<div class="profile-page">
  <!-- COVER PHOTO SECTION WITH EDIT OPTION -->
  <div class="profile-cover">
    <img id="coverPreview" src="{{ asset(auth()->user()->cover_image ?? 'images/heading-bg.webp') }}" alt="Cover Photo">
    <div class="cover-overlay"></div>
    <label for="cover_image" class="edit-cover">Edit Cover</label>
    <input type="file" id="cover_image" name="cover_image" accept="image/*" onchange="previewCover(event)">
  </div>

  <div class="profile-container">
    <div class="profile-card neon-glass">
      <div class="profile-header">
        <div class="profile-image">
          <img src="{{ asset(auth()->user()->profile_image ?? 'images/images.png') }}" alt="Profile Image">
          <div class="badge">Member</div>
        </div>
        <div class="profile-info-header">
          <h1>{{ auth()->user()->name }}</h1>
          <p class="email">{{ auth()->user()->email }}</p>
        </div>
      </div>

      <div class="profile-details">
        <div class="detail-item">
          <i class="fas fa-phone"></i>
          <span>{{ auth()->user()->phone ?? 'Not provided' }}</span>
        </div>
        <div class="detail-item">
          <i class="fas fa-map-marker-alt"></i>
          <span>{{ auth()->user()->address ?? 'Not provided' }}</span>
        </div>
        <div class="detail-item">
          <i class="fas fa-calendar-alt"></i>
          <span>Member Since: {{ auth()->user()->created_at ? auth()->user()->created_at->format('M d, Y') : 'N/A' }}</span>
        </div>
      </div>

      <div class="profile-links">
        <a href="{{ route('profile.edit') }}" class="link-item edit">✏️ Edit Profile</a>
        <a href="{{ route('wishlist.index') }}" class="link-item wishlist">📌 My Wishlist</a>
        <a href="{{ route('order') }}" class="link-item orders">📦 My Orders</a>
        <a href="{{ route('logout') }}" class="link-item logout"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">🚪 Logout</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
      </div>
    </div>
  </div>
</div>

<!-- NEON GLASSMORPHISM STYLES -->
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;700&display=swap');

body {
  font-family: 'Inter', sans-serif;
  background: radial-gradient(circle at top left, #0f0c29, #302b63, #24243e);
  color: #e0e0e0;
  margin: 0;
  padding: 0;
}

.profile-cover {
  position: relative;
  height: 250px;
  overflow: hidden;
}

.profile-cover img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  filter: brightness(60%);
}

.cover-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  backdrop-filter: blur(4px);
  background: rgba(0, 0, 0, 0.4);
}

.edit-cover {
  position: absolute;
  top: 15px;
  right: 15px;
  background: #00f7ff;
  color: #000;
  padding: 8px 12px;
  border-radius: 6px;
  font-weight: bold;
  cursor: pointer;
  box-shadow: 0 0 8px #00f7ff88;
  transition: all 0.3s ease;
}
.edit-cover:hover {
  background: #00d9ff;
}

#cover_image {
  display: none;
}

.profile-container {
  max-width: 900px;
  margin: -100px auto 50px auto;
  padding: 20px;
}

.profile-card {
  border-radius: 16px;
  padding: 30px;
  backdrop-filter: blur(12px);
  background: rgba(255, 255, 255, 0.05);
  border: 1px solid rgba(255, 255, 255, 0.1);
  box-shadow: 0 0 20px rgba(0, 247, 255, 0.1);
  transition: 0.4s;
}

.profile-card:hover {
  box-shadow: 0 0 25px rgba(0, 247, 255, 0.3);
}

.profile-header {
  display: flex;
  align-items: center;
  gap: 20px;
  border-bottom: 1px solid rgba(255,255,255,0.1);
  padding-bottom: 20px;
  margin-bottom: 20px;
}

.profile-image img {
  width: 140px;
  height: 140px;
  border-radius: 50%;
  border: 4px solid #00f7ff;
  object-fit: cover;
  transition: 0.3s;
}
.profile-image img:hover {
  transform: scale(1.05);
}

.badge {
  position: absolute;
  bottom: 5px;
  right: 5px;
  background: #28a745;
  color: white;
  font-size: 0.75rem;
  padding: 5px 10px;
  border-radius: 20px;
}

.profile-info-header h1 {
  font-size: 28px;
  color: #ffffff;
}

.email {
  color: #bbbbbb;
  font-size: 16px;
}

.profile-details {
  display: flex;
  flex-direction: column;
  gap: 15px;
  padding-left: 10px;
}

.detail-item {
  font-size: 16px;
  color: #d0d0d0;
  display: flex;
  align-items: center;
  gap: 10px;
}
.detail-item i {
  color: #00f7ff;
}

.profile-links {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 15px;
  margin-top: 20px;
}

.profile-links .link-item {
  flex: 1 1 200px;
  padding: 15px 20px;
  text-align: center;
  font-weight: bold;
  text-decoration: none;
  border-radius: 10px;
  color: white;
  transition: 0.3s;
  border: 2px solid transparent;
  box-shadow: 0 0 8px rgba(0, 247, 255, 0.3);
}

.link-item.edit { background: #007bff; }
.link-item.wishlist { background: #28a745; }
.link-item.orders { background: #ffc107; color: #000; }
.link-item.logout { background: #dc3545; }

.link-item:hover {
  transform: translateY(-3px);
  border-color: #00f7ff;
  box-shadow: 0 0 12px #00f7ff;
}

/* Responsive */
@media (max-width: 600px) {
  .profile-header {
    flex-direction: column;
    text-align: center;
  }

  .profile-image img {
    width: 110px;
    height: 110px;
  }

  .profile-info-header h1 {
    font-size: 22px;
  }

  .profile-links .link-item {
    font-size: 15px;
    padding: 12px;
  }
}
</style>

<script>
function previewCover(event) {
  const input = event.target;
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = function(e) {
      document.getElementById('coverPreview').src = e.target.result;
    }
    reader.readAsDataURL(input.files[0]);
  }
}
</script>

@endsection
