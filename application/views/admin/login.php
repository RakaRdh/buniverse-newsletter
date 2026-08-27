<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - B-Universe CMS</title>
  <link rel="shortcut icon" href="<?= base_url('assets/favicon.ico') ?>" type="image/x-icon">
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    accent: {
                        50: '#FFF6F1',
                        100: '#FDE6DB',
                        500: '#F2622C',
                        600: '#E6531F',
                    },
                    ink: {
                        50: '#F7F5F2',
                        150: '#EDE9E4',
                        300: '#D8D2CC',
                        500: '#8A817B',
                        700: '#524B47',
                        900: '#231F1D',
                    }
                },
                fontFamily: {
                    sans: ['Inter', 'sans-serif'],
                    jakarta: ['"Plus Jakarta Sans"', 'sans-serif'],
                }
            }
        }
    }
  </script>
  <style>
    body { 
      font-family: 'Inter', sans-serif;
    }
  </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 bg-ink-50 text-ink-900 font-sans">

  <!-- Centered Login Card -->
  <main class="w-full max-w-sm bg-white rounded-lg border border-ink-150 p-6 md:p-8">
    <div class="text-center mb-6">
      <div class="w-10 h-10 bg-ink-900 rounded-md flex items-center justify-center text-white font-bold text-lg mx-auto mb-2 font-jakarta">
        B
      </div>
      <h1 class="text-base font-bold font-jakarta text-ink-900 tracking-tight">Sign In to CMS</h1>
      <p class="text-xs text-ink-500 mt-0.5">Please enter your details to sign in.</p>
    </div>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="bg-rose-50 border border-rose-200 text-rose-800 px-3 py-2 rounded-md text-xs mb-4 text-center">
            <?= $this->session->flashdata('error') ?>
        </div>
    <?php endif; ?>

    <?= form_open('admin/authenticate', ['class' => 'space-y-4']) ?>
      <div>
        <label for="username" class="block text-[11px] font-bold text-ink-700 uppercase mb-1.5">Username</label>
        <input type="text" name="username" id="username" class="w-full h-9 px-3 text-xs bg-white border border-ink-300 rounded-lg text-ink-900 placeholder-ink-500 focus:outline-none focus:border-accent-500 focus:ring-1 focus:ring-accent-100 transition-all" placeholder="admin" required>
      </div>

      <div>
        <label for="password" class="block text-[11px] font-bold text-ink-700 uppercase mb-1.5">Password</label>
        <div class="relative">
          <input type="password" name="password" id="password" class="w-full h-9 px-3 pr-9 text-xs bg-white border border-ink-300 rounded-lg text-ink-900 placeholder-ink-500 focus:outline-none focus:border-accent-500 focus:ring-1 focus:ring-accent-100 transition-all" placeholder="••••••••" required>
          <button type="button" onclick="togglePassword()" class="absolute right-2.5 top-2.5 text-ink-500 hover:text-ink-900">
            <i id="eye-icon" class="fa-solid fa-eye text-xs"></i>
          </button>
        </div>
      </div>

      <button type="submit" class="w-full py-2 px-4 bg-accent-500 hover:bg-accent-600 text-white font-bold rounded-[6px] text-xs transition-all shadow-sm">
        Sign In
      </button>
    </form>

    <!-- Admin credentials hint box -->
    <div class="mt-5 p-3.5 bg-accent-50 border border-accent-100 rounded-lg text-xs text-ink-900 flex items-start gap-2.5">
        <i class="fa-solid fa-circle-info text-accent-600 mt-0.5"></i>
        <div>
            <span class="font-bold">Login Info:</span>
            <p class="mt-0.5">Use <code class="bg-white px-1 py-0.5 border border-accent-100 rounded font-mono">admin</code> / <code class="bg-white px-1 py-0.5 border border-accent-100 rounded font-mono">123</code> to access the dashboard.</p>
        </div>
    </div>
  </main>

  <script>
    function togglePassword() {
      const passwordInput = document.getElementById('password');
      const eyeIcon = document.getElementById('eye-icon');
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');
      } else {
        passwordInput.type = 'password';
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');
      }
    }
  </script>
</body>
</html>
