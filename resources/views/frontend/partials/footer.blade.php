<footer class="site-footer">
  <div class="container">
    <div class="grid">

      <div>
        <a href="{{ url('/') }}">
          <img src="{{ asset('assets/logo.png') }}" class="footer-logo"
            alt="{{ $company->company_name ?? config('app.name') }}">
        </a>
        <p class="footer-about">
          {{ config('app.name') }} is a leading company dedicated to producing premium quality fabrics and garments.
        </p>

        <div class="social-links">
          <a href="#" class="social-icon"><svg
              xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
              <path
                d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" />
            </svg></a>
          <a href="#" class="social-icon"><svg
              xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
              <path
                d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
            </svg></a>
          <a href="#" class="social-icon"><svg
              xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
              <path
                d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
            </svg></a>
          <a href="#" class="social-icon"><svg
              xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
              <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
              <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
            </svg></a>
        </div>
      </div>

      <div>
        <h3>Company</h3>
        <ul>
          <li><a href="{{ route('frontend.about') }}">About Us</a></li>
          <li><a href="{{ route('frontend.contact') }}">Contact Us</a></li>
        </ul>
      </div>

      <div>
        <h3>Services</h3>
        <ul>
          @if(isset($services) && $services->count() > 0)
            @foreach($services->take(5) as $s)
              <li><a href="{{ route('frontend.services.detail', $s->slug) }}">{{ $s->service_name }}</a></li>
            @endforeach
          @else
            <li><a href="{{ route('frontend.services') }}">IT Solutions</a></li>
            <li><a href="{{ route('frontend.services') }}">Real Estate Services</a></li>
            <li><a href="{{ route('frontend.services') }}">HR Outsourcing</a></li>
            <li><a href="{{ route('frontend.services') }}">Consultancy</a></li>
          @endif
        </ul>
      </div>

      <div>
        <h3>Contact</h3>
        <p class="footer-contact-info">
          <span><b>Address:</b> {{ $company->address ?? 'Karachi, Pakistan' }}</span>
          <span><b>Email:</b> {{ $company->email ?? 'info@example.com' }}</span>
          <span><b>Phone:</b> {{ $company->phone ?? '+92 300 1234567' }}</span>
        </p>
      </div>

    </div>

    <div class="copyright">
      © {{ now()->year }} {{ $company->company_name ?? config('app.name') }} — All rights reserved | <a href="#">Privacy
        Policy</a> | <a href="#">Terms of Use</a> | Powered by <a href="https://nexertechsolutions.com" target="_blank"
        style="color: var(--accent-1); font-weight: 600;">Nexer Tech Solutions</a>
    </div>
  </div>
</footer>