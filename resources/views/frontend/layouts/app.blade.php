<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>{{ $company->company_name ?? config('app.name') }}</title>
  <link rel="icon" type="image/png" href="{{ asset('assets/logo.png') }}">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
    rel="stylesheet">

  <!-- Tailwind CDN -->
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" crossorigin="anonymous" referrerpolicy="no-referrer">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">
  
  <!-- Frontend Consolidated Styles -->
  <link rel="stylesheet" href="{{ asset('assets/css/frontend-style.css') }}">
  
  @stack('styles')

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body>

  @include('frontend.partials.navbar')

  <!-- Toast Notification Container -->
  <div id="toast-container" class="fixed top-24 right-6 z-[9999] flex flex-col gap-3 pointer-events-none"></div>

  <main>
    @yield('content')
  </main>

  @include('frontend.partials.footer')

  <!-- SLIDER SCRIPT -->
  <script>
    (function () {
      const slides = document.getElementById('slides');
      if (!slides) return;

      const dots = document.querySelectorAll('.dot');
      const prev = document.getElementById('prev');
      const next = document.getElementById('next');

      let index = 0;
      const total = slides.children.length;
      let interval;

      function goTo(i) {
        index = (i + total) % total;
        slides.style.transform = "translateX(" + (-index * 100) + "%)";
        dots.forEach(d => d.classList.remove("active"));
        if (dots[index]) dots[index].classList.add("active");
      }

      const nextSlide = () => goTo(index + 1);
      const prevSlide = () => goTo(index - 1);

      if (next) next.onclick = () => { nextSlide(); reset(); }
      if (prev) prev.onclick = () => { prevSlide(); reset(); }

      dots.forEach(dot => {
        dot.onclick = () => { goTo(+dot.dataset.index); reset(); }
      });

      function start() { interval = setInterval(nextSlide, 5000); }
      function reset() { clearInterval(interval); start(); }

      start();
    })();
  </script>

  @stack('scripts')

  <!-- Global Notify Script -->
  <script>
    function showToast(message, type = 'success') {
      const container = document.getElementById('toast-container');
      if (!container) return;

      const toast = document.createElement('div');
      toast.className = `toast-message pointer-events-auto bg-white rounded-2xl shadow-2xl p-4 min-w-[300px] border-l-4 ${type === 'success' ? 'border-green-500' : 'border-red-500'} transform translate-x-full transition-all duration-500 flex items-center gap-4`;
      
      const icon = type === 'success' ? 'fa-check-circle text-green-500' : 'fa-exclamation-circle text-red-500';
      
      toast.innerHTML = `
        <div class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center shrink-0">
          <i class="fas ${icon} text-xl"></i>
        </div>
        <div class="flex-1">
          <p class="text-sm font-black text-gray-900">${message}</p>
        </div>
        <button onclick="this.parentElement.remove()" class="text-gray-400 hover:text-gray-600">
          <i class="fas fa-times"></i>
        </button>
      `;

      container.appendChild(toast);

      // Animate in
      setTimeout(() => {
        toast.classList.remove('translate-x-full');
      }, 100);

      // Auto remove
      setTimeout(() => {
        toast.classList.add('opacity-0', 'translate-x-4');
        setTimeout(() => toast.remove(), 500);
      }, 5000);
    }

    @if(session('success') || session('status'))
      document.addEventListener('DOMContentLoaded', () => {
        showToast("{{ session('success') ?? session('status') }}", "success");
      });
    @endif

    @if(session('error'))
      document.addEventListener('DOMContentLoaded', () => {
        showToast("{{ session('error') }}", "error");
      });
    @endif
  </script>
</body>

</html>