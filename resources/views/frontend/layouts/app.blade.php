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
</body>

</html>