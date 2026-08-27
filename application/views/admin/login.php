<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - B-Universe CMS</title>
  <link rel="shortcut icon" href="<?= base_url('assets/favicon.ico') ?>" type="image/x-icon">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  
  <style>
    body { 
      font-family: 'Inter', sans-serif;
      background-color: #FAFAFC;
    }

    /* Asymmetric & Amorphous Keyframe Animations */
    @keyframes fluidRed {
      0%, 100% {
        border-radius: 38% 62% 63% 37% / 41% 44% 56% 59%;
        transform: translate(0px, 0px) rotate(0deg) scale(1);
      }
      25% {
        border-radius: 68% 32% 27% 73% / 55% 23% 77% 45%;
        transform: translate(80px, 40px) rotate(90deg) scale(1.15);
      }
      50% {
        border-radius: 23% 77% 52% 48% / 30% 65% 35% 70%;
        transform: translate(120px, -60px) rotate(180deg) scale(0.9);
      }
      75% {
        border-radius: 75% 25% 69% 31% / 39% 70% 30% 61%;
        transform: translate(-40px, 50px) rotate(270deg) scale(1.05);
      }
    }

    @keyframes fluidNavy {
      0%, 100% {
        border-radius: 63% 37% 30% 70% / 50% 70% 30% 50%;
        transform: translate(0px, 0px) rotate(0deg) scale(1);
      }
      33% {
        border-radius: 30% 70% 70% 30% / 22% 58% 42% 78%;
        transform: translate(-100px, -70px) rotate(-120deg) scale(1.2);
      }
      66% {
        border-radius: 78% 22% 45% 55% / 68% 35% 65% 32%;
        transform: translate(50px, -110px) rotate(-240deg) scale(0.85);
      }
    }

    /* Top-Left Red Family Morph */
    .morph-red-topleft {
      animation: fluidRed 18s ease-in-out infinite;
      background: radial-gradient(circle at 30% 30%, #FF5258 0%, #EC1C24 50%, #990B10 100%);
    }

    /* Bottom-Right Navy Family Morph */
    .morph-navy-bottomright {
      animation: fluidNavy 22s ease-in-out infinite;
      background: radial-gradient(circle at 70% 70%, #3B4480 0%, #20254D 50%, #0D1026 100%);
    }
  </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 relative overflow-hidden bg-slate-50">

  <!-- TWO DYNAMIC FLUID MORPH ELEMENTS -->
  <div class="absolute inset-0 overflow-hidden pointer-events-none flex items-center justify-center">
    <div class="morph-red-topleft absolute -top-28 -left-28 w-[650px] h-[650px] opacity-75 blur-2xl mix-blend-multiply"></div>
    <div class="morph-navy-bottomright absolute -bottom-28 -right-28 w-[700px] h-[700px] opacity-75 blur-2xl mix-blend-multiply"></div>
  </div>

  <!-- Centered Login Card -->
  <main class="w-full max-w-md bg-white/85 backdrop-blur-xl rounded-2xl shadow-2xl p-8 md:p-10 relative z-10 border border-white/60">
    <div class="text-center mb-8">
      <!-- Brand Icon: Dark Navy containing Accent Red logo letter -->
      <div class="w-12 h-12 bg-[#20254D] rounded-xl flex items-center justify-center text-[#EC1C24] font-bold text-2xl mx-auto mb-3 shadow-lg shadow-[#20254D]/20">
        B
      </div>
      <h1 class="text-2xl font-bold text-[#20254D] tracking-tight">Welcome Back!</h1>
      <p class="text-sm text-slate-500 mt-1">Please enter your details to sign in.</p>
    </div>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg text-sm mb-5 text-center">
            <?= $this->session->flashdata('error') ?>
        </div>
    <?php endif; ?>

    <?= form_open('admin/authenticate', ['class' => 'space-y-5']) ?>
      <div>
        <label for="username" class="block text-sm font-semibold text-slate-700 mb-1.5">Username</label>
        <input type="text" name="username" id="username" class="w-full px-4 py-2.5 text-sm bg-slate-50/80 border border-slate-200 rounded-lg text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#20254D]/20 focus:border-[#20254D] transition-all" placeholder="admin_user" required>
      </div>

      <div>
        <label for="password" class="block text-sm font-semibold text-slate-700 mb-1.5">Password</label>
        <div class="relative">
          <input type="password" name="password" id="password" class="w-full px-4 py-2.5 pr-10 text-sm bg-slate-50/80 border border-slate-200 rounded-lg text-slate-800 placeholder-slate-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#20254D]/20 focus:border-[#20254D] transition-all" placeholder="••••••••" required>
          <button type="button" onclick="togglePassword()" class="absolute right-3 top-3 text-slate-400 hover:text-slate-600">
            <svg id="eye-icon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
          </button>
        </div>
      </div>

      <div class="flex items-center justify-between text-xs sm:text-sm">
        <label class="flex items-center text-slate-600 cursor-pointer">
          <input type="checkbox" class="w-4 h-4 rounded border-slate-300 text-[#20254D] focus:ring-[#20254D]/20">
          <span class="ml-2 font-medium">Remember me</span>
        </label>
        <a href="#" class="font-semibold text-[#EC1C24] hover:underline">Forgot password?</a>
      </div>

      <button type="submit" class="w-full py-3 px-4 bg-[#20254D] hover:bg-[#161a38] text-white font-semibold rounded-xl shadow-xl shadow-[#20254D]/20 active:scale-[0.99] transition-all duration-150">
        Sign In
      </button>

      <div class="mt-4 p-3 bg-slate-50 border border-slate-200 rounded-xl text-center text-xs text-slate-500">
        <p class="font-medium text-slate-600">Default Credentials:</p>
        <p class="mt-1">Username: <span class="font-semibold text-slate-800">admin</span> | Password: <span class="font-semibold text-slate-800">123</span></p>
      </div>
    </form>
  </main>

  <script>
    function togglePassword() {
      const passwordInput = document.getElementById('password');
      passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
    }
  </script>
</body>
</html>
