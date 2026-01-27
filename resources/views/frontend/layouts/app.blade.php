<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>{{ $company->company_name ?? 'AOHT Group' }}</title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
    rel="stylesheet">

  <!-- Tailwind CDN -->
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    :root {
      --accent-1: #7c3aed;
      --accent-2: #06b6d4;
      --bg: #f8fafc;
      --footer-bg: #111827;
      --footer-text: #d1d5db;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    html {
      height: 100%;
    }

    body {
      font-family: 'Inter', system-ui, -apple-system, sans-serif;
      margin: 0;
      background: linear-gradient(180deg, var(--bg), #fff);
      color: #111827;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    /* NAVBAR STYLES */
    .topnav {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 50;
      background: white;
      color: black;
      height: 80px;
      display: flex;
      align-items: center;
      box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
      transition: all 0.3s;
    }


    .container {
      max-width: 1400px;
      margin: 0 auto;
      padding: 0;
      width: 100%;
    }

    .navbar-wrapper {
      display: flex;
      align-items: center;
      width: 100%;
      gap: 2rem;
      padding: 0 24px 0 0;
      justify-content: space-between;
    }

    .navbar-left {
      display: flex;
      align-items: center;
      margin-left: 0;
      padding-left: 0;
      flex-shrink: 0;
    }

    .navbar-links {
      display: flex;
      align-items: center;
      flex-shrink: 0;
      flex: 1;
    }

    .navbar-right {
      display: flex;
      gap: 1rem;
      flex-shrink: 0;
      align-items: center;
    }

    .logo-img {
      max-width: 250px;
      width: 100%;
      height: auto;
      object-fit: contain;
    }

    .nav-link {
      padding: 0.5rem 1rem;
      border-radius: 8px;
      color: #000000;
      text-decoration: none;
      transition: all 0.25s;
      font-weight: 700;
    }

    .nav-link:hover {
      background: #22c55e;
      color: white;
    }

    .nav-link.active {
      background: #fef08a;
      color: #000000;
      font-weight: 700;
    }

    .search-input {
      border: 1px solid #e5e7eb;
      padding: 0.5rem 0.75rem;
      border-radius: 8px;
    }

    .nav-item-dropdown {
      position: relative;
    }

    .dropdown-content {
      visibility: hidden;
      opacity: 0;
      position: absolute;
      top: 100%;
      left: 0;
      background-color: white;
      min-width: 240px;
      box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
      z-index: 100;
      border-radius: 8px;
      padding: 0.5rem 0;
      margin-top: 15px;
      /* Gap for hover */
      transition: all 0.2s ease;
      border: 1px solid #f3f4f6;
    }


    .dropdown-content a {
      color: #374151;
      padding: 12px 20px;
      text-decoration: none;
      display: block;
      font-size: 0.9375rem;
      font-weight: 500;
      transition: all 0.2s;
      line-height: 1.2;
    }

    .dropdown-content a:hover {
      background-color: #f9fafb;
      color: #7c3aed;
      padding-left: 25px;
    }

    .nav-item-dropdown:hover .dropdown-content {
      visibility: visible;
      opacity: 1;
    }

    /* Nested Submenu Styles */
    .dropdown-submenu {
      position: relative;
    }

    .dropdown-submenu .submenu-content {
      visibility: hidden;
      opacity: 0;
      position: absolute;
      top: -5px;
      left: 100%;
      background-color: white;
      min-width: 240px;
      box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
      z-index: 101;
      border-radius: 8px;
      padding: 0.5rem 0;
      transition: all 0.2s ease;
      border: 1px solid #f3f4f6;
    }

    .dropdown-submenu:hover>.submenu-content {
      visibility: visible;
      opacity: 1;
    }

    .dropdown-content a.has-submenu {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .dropdown-content a.has-submenu::after {
      content: '\f105';
      font-family: 'Font Awesome 6 Free';
      font-weight: 900;
      font-size: 0.8rem;
      margin-left: 10px;
    }



    .avatar {

      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--accent-1), var(--accent-2));
      color: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      font-weight: 600;
      cursor: pointer;
    }

    .icon-link {
      padding: 0.5rem;
      border-radius: 8px;
      color: #000000;
      text-decoration: none;
      transition: all 0.25s;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .icon-link:hover {
      background: #f3f4f6;
      color: var(--accent-1);
    }

    .icon-link-text {
      padding: 0.5rem 1rem;
      border-radius: 8px;
      color: #000000;
      text-decoration: none;
      transition: all 0.25s;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      font-weight: 500;
    }

    .icon-link-text:hover {
      background: #f3f4f6;
      color: var(--accent-1);
    }

    .icon-link-text svg {
      flex-shrink: 0;
    }

    /* SLIDER STYLES */
    .hero-slider {
      position: relative;
      overflow: hidden;
      /* margin-top: 80px; Removed because main has padding-top now */
      width: 100%;
      height: 400px;
    }

    .slides {
      display: flex;
      height: 100%;
      transition: transform 0.6s ease-in-out;
    }

    .slide {
      min-width: 100%;
      height: 100%;
      display: flex;
      justify-content: center;
      align-items: center;
      position: relative;
      text-align: center;
      color: white;
    }

    .slide .overlay {
      position: absolute;
      inset: 0;
      background: linear-gradient(180deg, rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.5));
    }

    .slide-content {
      position: relative;
      z-index: 2;
      max-width: 1000px;
      padding: 40px 20px;
    }

    .title {
      font-size: 3rem;
      font-weight: 800;
      margin-bottom: 1rem;
      line-height: 1.2;
    }

    .subtitle {
      font-size: 1.25rem;
      max-width: 700px;
      margin: 0 auto;
      color: #f3f4f6;
      line-height: 1.6;
    }

    .btn {
      padding: 0.75rem 1.5rem;
      border-radius: 8px;
      font-weight: 600;
      text-decoration: none;
      display: inline-block;
      transition: all 0.3s;
      margin-top: 1.5rem;
    }

    .btn-light {
      background: #fff;
      color: var(--accent-1);
    }

    .btn-light:hover {
      background: #f9fafb;
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .slider-arrow {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      background: rgba(255, 255, 255, 0.95);
      padding: 12px 16px;
      border-radius: 50%;
      cursor: pointer;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
      transition: all 0.3s;
      z-index: 10;
      font-size: 1.2rem;
      opacity: 0;
    }

    .hero-slider:hover .slider-arrow {
      opacity: 1;
    }

    .slider-arrow:hover {
      background: white;
      transform: translateY(-50%) scale(1.1);
    }

    .arrow-left {
      left: 20px;
    }

    .arrow-right {
      right: 20px;
    }

    .dots {
      position: absolute;
      left: 50%;
      transform: translateX(-50%);
      bottom: 24px;
      display: flex;
      gap: 10px;
      z-index: 10;
    }

    .dot {
      width: 12px;
      height: 12px;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.5);
      cursor: pointer;
      transition: all 0.3s;
    }

    .dot.active {
      background: white;
      width: 32px;
      border-radius: 6px;
    }

    /* MAIN CONTENT STYLES */
    main {
      flex: 1;
      width: 100%;
      padding-top: 80px;
      /* Push content down below fixed navbar */
    }

    .container-custom {
      max-width: 1400px;
      margin: 0 auto;
      padding: 0 24px;
    }

    .section-header {
      text-align: center;
      margin-bottom: 3rem;
    }

    .section-title {
      font-size: 2.5rem;
      font-weight: 800;
      color: #111827;
      margin-bottom: 0.75rem;
    }

    .section-subtitle {
      font-size: 1.125rem;
      color: #6b7280;
      max-width: 600px;
      margin: 0 auto;
    }

    /* FOOTER STYLES */
    .site-footer {
      background: var(--footer-bg);
      color: var(--footer-text);
      margin-top: auto;
    }

    .site-footer .container {
      max-width: 1400px;
      margin: 0 auto;
      padding: 0.25rem 24px;
      /* Ultra-reduced padding */
    }

    .site-footer .grid {
      display: grid;
      grid-template-columns: repeat(1, 1fr);
      gap: 0.5rem;
      /* Ultra-reduced gap */
    }

    @media(min-width: 768px) {
      .site-footer .grid {
        grid-template-columns: repeat(4, 1fr);
      }
    }

    .site-footer h3 {
      color: white;
      margin-bottom: 0.2rem;
      /* Ultra-reduced margin */
      font-weight: 700;
      font-size: 0.9rem;
      /* Smaller font */
    }

    .site-footer ul {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .site-footer ul li {
      margin-bottom: 0.05rem;
      /* Ultra-reduced margin */
      font-size: 0.85rem;
      /* Smaller font */
    }

    .site-footer a {
      color: #cbd5e1;
      text-decoration: none;
      transition: all 0.3s;
    }

    .site-footer a:hover {
      color: white;
    }

    .subscribe {
      display: flex;
      gap: 0.5rem;
    }

    .subscribe input {
      padding: 0.4rem 0.75rem;
      border: none;
      border-radius: 6px;
      background: #1e293b;
      flex: 1;
      color: #fff;
      font-size: 0.9rem;
    }

    .subscribe button {
      padding: 0.4rem 0.8rem;
      background: var(--accent-1);
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-weight: 600;
      transition: all 0.3s;
      font-size: 0.9rem;
    }

    .subscribe button:hover {
      background: var(--accent-2);
    }

    .copyright {
      border-top: 1px solid rgba(255, 255, 255, 0.1);
      margin-top: 0.4rem;
      /* Ultra-reduced margin */
      padding-top: 0.4rem;
      /* Ultra-reduced padding */
      text-align: center;
      font-size: 0.75rem;
      /* Smaller font */
    }

    /* CATEGORIES SECTION */
    .categories-section {
      padding: 4rem 0;
      background: white;
    }

    .categories-grid {
      display: flex;
      justify-content: center;
      align-items: stretch;
      /* Stretch columns to match height */
      gap: 1.5rem;
      /* flex-wrap: wrap; - Disable wrapping for detailed alignment on desktop */
      overflow-x: auto;
      /* Allow scroll if too narrow, or manage with media queries */
      padding-bottom: 2rem;
      /* Space for shadow/hover */
    }

    /* Column Wrapper */
    .category-column {
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      gap: 1.5rem;
    }

    /* Align outer columns to center or bottom if needed */
    .category-column:first-child,
    .category-column:last-child {
      justify-content: center;
      /* Center the single item vertically */
    }

    .category-card {
      position: relative;
      border-radius: 16px;
      overflow: hidden;
      background: #f1f8f0;
      transition: all 0.4s ease;
      cursor: pointer;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
      display: flex;
      flex-direction: column;
    }

    .category-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .category-image {
      flex: 1;
      display: flex;
      align-items: flex-start;
      justify-content: center;
      padding: 0;
      width: 100%;
      height: 100%;
    }

    .category-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      object-position: top center;
      transition: transform 0.6s ease;
      /* mix-blend-mode: multiply; removed request to keep original image clear */
    }

    .category-card:hover .category-image img {
      transform: scale(1.08);
    }

    .category-label {
      background: rgba(255, 255, 255, 0.95);
      padding: 10px 16px;
      text-align: center;
      font-weight: 700;
      font-size: 0.8rem;
      text-transform: uppercase;
      color: #1f2937;
      position: absolute;
      bottom: 20px;
      left: 50%;
      transform: translateX(-50%);
      border-radius: 6px;
      width: 85%;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      z-index: 2;
      transition: opacity 0.3s ease;
      /* Smooth transition */
    }

    .category-card:hover .category-label {
      opacity: 0;
      /* Hide text on hover */
    }

    /* Card Sizes for Column Layout */
    .category-full {
      width: 280px;
      height: 500px;
      /* Center Large Card */
    }

    .category-half {
      width: 220px;
      height: 240px;
      /* Stacked Cards (240+240+20ish gap = ~500) */
    }

    .category-auto {
      width: 180px;
      height: 380px;
      /* Outer Single Cards */
    }


    /* Responsive Breakpoints */
    @media (max-width: 1400px) {
      .category-full {
        width: 240px;
      }

      .category-half {
        width: 190px;
      }

      .category-auto {
        width: 160px;
      }
    }

    @media (max-width: 1100px) {

      /* Switch to wrapping flex layout for tablets */
      .categories-grid {
        flex-wrap: wrap;
        align-items: flex-start;
      }

      .category-column {
        width: 45%;
        align-items: center;
      }

      .category-column:nth-child(3) {
        width: 100%;
        /* Center large card takes full width row */
        order: -1;
        /* Move to top or center? Keep order */
      }

      .category-full,
      .category-half,
      .category-auto {
        width: 100%;
        height: 300px;
        /* Standardize height on wrap */
      }
    }

    @media (max-width: 600px) {
      .category-column {
        width: 100%;
      }
    }

    /* SERVICES SECTION */
    .services-section {
      padding: 4rem 0;
      background: white;
    }

    .services-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 2rem;
    }

    .service-card {
      background: linear-gradient(135deg, #f9fafb 0%, #ffffff 100%);
      border-radius: 16px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
      transition: all 0.3s;
      border: 1px solid #f3f4f6;
      display: flex;
      flex-direction: column;
      height: 100%;
    }

    .service-card .p-8 {
      display: flex;
      flex-direction: column;
      flex: 1;
    }

    .service-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 12px 24px rgba(124, 58, 237, 0.15);
      border-color: var(--accent-1);
    }

    .service-icon {
      width: 64px;
      height: 64px;
      border-radius: 12px;
      background: linear-gradient(135deg, var(--accent-1), var(--accent-2));
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 1.5rem;
      flex-shrink: 0;
    }

    .service-icon img {
      width: 36px;
      height: 36px;
    }

    .icon-placeholder {
      color: white;
      font-size: 1.5rem;
      font-weight: 700;
    }

    .service-title {
      font-size: 1.5rem;
      font-weight: 700;
      margin-bottom: 1rem;
      color: #111827;
    }

    .service-description {
      color: #6b7280;
      line-height: 1.6;
      margin-bottom: 1.5rem;
    }

    .service-link {
      color: var(--accent-1);
      font-weight: 600;
      text-decoration: none;
      transition: all 0.3s;
      margin-top: auto;
      display: inline-block;
    }


    .service-link:hover {
      color: var(--accent-2);
    }

    /* PROJECTS SECTION */
    .projects-section {
      padding: 4rem 0;
      background: #f9fafb;
    }

    .projects-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 2rem;
    }

    .project-card {
      background: white;
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
      transition: all 0.3s;
    }

    .project-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 12px 28px rgba(0, 0, 0, 0.12);
    }

    .project-image {
      width: 100%;
      height: 450px;
      background: #fdfdfd;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
      border-bottom: 1px solid #f3f4f6;
    }

    .project-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      object-position: top;
      transition: transform 0.4s ease;
    }

    .project-card:hover .project-image img {
      transform: scale(1.1);
    }

    .image-placeholder {
      width: 100%;
      height: 100%;
      background: linear-gradient(135deg, #e5e7eb, #d1d5db);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 3rem;
    }

    .project-content {
      padding: 1.5rem;
    }

    .project-title {
      font-size: 1.25rem;
      font-weight: 700;
      margin-bottom: 0.75rem;
      color: #111827;
    }

    .project-description {
      color: #6b7280;
      line-height: 1.6;
      margin-bottom: 1rem;
    }

    .project-link {
      color: var(--accent-1);
      font-weight: 600;
      text-decoration: none;
      transition: all 0.3s;
    }

    .project-link:hover {
      color: var(--accent-2);
    }

    /* STATISTICS SECTION */
    .stats-section {
      padding: 4rem 0;
      background: linear-gradient(135deg, var(--accent-1), var(--accent-2));
    }

    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 2rem;
    }

    .stat-card {
      text-align: center;
      padding: 2rem;
      color: white;
    }

    .stat-number {
      font-size: 3rem;
      font-weight: 800;
      margin-bottom: 0.5rem;
    }

    .stat-label {
      font-size: 1.125rem;
      opacity: 0.95;
    }

    /* BLOGS SECTION */
    .blogs-section {
      padding: 4rem 0;
      background: white;
    }

    .blogs-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
      gap: 2rem;
    }

    .blog-card {
      background: white;
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
      transition: all 0.3s;
      border: 1px solid #f3f4f6;
    }

    .blog-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 12px 28px rgba(0, 0, 0, 0.12);
      border-color: var(--accent-1);
    }

    .blog-image {
      width: 100%;
      height: 200px;
      overflow: hidden;
    }

    .blog-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.4s;
    }

    .blog-card:hover .blog-image img {
      transform: scale(1.08);
    }

    .blog-content {
      padding: 1.5rem;
    }

    .blog-date {
      color: var(--accent-1);
      font-size: 0.875rem;
      font-weight: 600;
      margin-bottom: 0.5rem;
    }

    .blog-title {
      font-size: 1.25rem;
      font-weight: 700;
      margin-bottom: 0.75rem;
      color: #111827;
      line-height: 1.4;
    }

    .blog-excerpt {
      color: #6b7280;
      line-height: 1.6;
      margin-bottom: 1rem;
    }

    .blog-link {
      color: var(--accent-1);
      font-weight: 600;
      text-decoration: none;
      transition: all 0.3s;
    }

    .blog-link:hover {
      color: var(--accent-2);
    }

    /* TEAM SECTION */
    .team-section {
      padding: 4rem 0;
      background: white;
    }

    .team-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 2rem;
    }

    .team-card {
      background: white;
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
      transition: all 0.3s;
      border: 1px solid #f3f4f6;
      text-align: center;
    }

    .team-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 12px 28px rgba(0, 0, 0, 0.12);
      border-color: var(--accent-1);
    }

    .team-image {
      width: 100%;
      height: 430px;
      overflow: hidden;
      background: #f3f4f6;
    }

    .team-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      object-position: center top;
      transition: transform 0.4s;
    }

    .team-card:hover .team-image img {
      transform: scale(1.05);
    }

    .team-placeholder {
      width: 100%;
      height: 100%;
      background: linear-gradient(135deg, var(--accent-1), var(--accent-2));
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 4rem;
      font-weight: 800;
      color: white;
    }

    .team-content {
      padding: 1.5rem;
    }

    .team-name {
      font-size: 1.25rem;
      font-weight: 700;
      margin-bottom: 0.5rem;
      color: #111827;
    }

    .team-position {
      color: var(--accent-1);
      font-weight: 600;
      margin-bottom: 1rem;
    }

    .team-bio {
      color: #6b7280;
      line-height: 1.6;
      font-size: 0.875rem;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }

    .team-bio b, .team-bio strong,
    .team-card-about-bio b, .team-card-about-bio strong {
      font-weight: bold !important;
    }

    /* CTA SECTION */
    .cta-section {
      padding: 3rem 0;
      background: linear-gradient(135deg, #1e293b, #0f172a);
    }

    .cta-section .container-custom {
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 2rem;
    }

    .cta-content {
      flex: 1;
      color: white;
    }

    .cta-title {
      font-size: 2rem;
      font-weight: 800;
      margin-bottom: 0.75rem;
    }

    .cta-text {
      font-size: 1.125rem;
      opacity: 0.9;
      max-width: 600px;
    }

    .cta-contact {
      text-align: right;
      color: white;
    }

    .cta-label {
      font-size: 1.125rem;
      font-weight: 600;
      margin-bottom: 0.5rem;
    }

    .cta-details {
      margin-bottom: 1rem;
      opacity: 0.9;
    }

    .cta-details span {
      display: block;
      margin: 0.25rem 0;
    }

    /* FOOTER STYLES */
    .site-footer {
      background: var(--footer-bg);
      color: var(--footer-text);
      margin-top: auto;
    }

    .site-footer .container {
      max-width: 1400px;
      margin: 0 auto;
      padding: 3rem 24px;
    }

    .site-footer .grid {
      display: grid;
      grid-template-columns: repeat(1, 1fr);
      gap: 2rem;
    }

    @media(min-width: 768px) {
      .site-footer .grid {
        grid-template-columns: repeat(4, 1fr);
      }
    }

    .site-footer h3 {
      color: white;
      margin-bottom: 1rem;
      font-weight: 700;
    }

    .site-footer ul {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .site-footer ul li {
      margin-bottom: 0.5rem;
    }

    .site-footer a {
      color: #cbd5e1;
      text-decoration: none;
      transition: all 0.3s;
    }

    .site-footer a:hover {
      color: white;
    }

    .subscribe {
      display: flex;
      gap: 0.5rem;
    }

    .subscribe input {
      padding: 0.5rem 0.75rem;
      border: none;
      border-radius: 8px;
      background: #1e293b;
      flex: 1;
      color: #fff;
    }

    .subscribe button {
      padding: 0.5rem 1rem;
      background: var(--accent-1);
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 600;
      transition: all 0.3s;
    }

    .subscribe button:hover {
      background: var(--accent-2);
    }

    .copyright {
      border-top: 1px solid rgba(255, 255, 255, 0.1);
      margin-top: 2rem;
      padding-top: 1.5 rem;
      text-align: center;
      font-size: 0.875rem;
    }

    /* MAIN CONTENT STYLES */
    main {
      flex: 1;
      width: 100%;
      padding-top: 80px;
      display: flex;
      flex-direction: column;
    }

    /* ... */

    /* AUTH PAGES STYLES */
    .auth-section {
      padding: 1rem 0;
      background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .auth-container {
      max-width: 480px;
      width: 100%;
      padding: 0 24px;
    }

    .auth-card {
      background: white;
      border-radius: 16px;
      padding: 1.5rem 2rem;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
    }

    .auth-header {
      text-align: center;
      margin-bottom: 1rem;
    }

    .auth-title {
      font-size: 2rem;
      font-weight: 800;
      color: #111827;
      margin-bottom: 0.5rem;
    }

    .auth-subtitle {
      color: #6b7280;
      font-size: 1rem;
    }

    .auth-form {
      margin-top: 1rem;
    }

    .form-group {
      margin-bottom: 1rem;
    }

    .form-label {
      display: block;
      font-weight: 600;
      color: #374151;
      margin-bottom: 0.5rem;
    }

    .form-input {
      width: 100%;
      padding: 0.75rem 1rem;
      border: 2px solid #e5e7eb;
      border-radius: 8px;
      font-size: 1rem;
      transition: all 0.3s;
    }

    .form-input:focus {
      outline: none;
      border-color: var(--accent-1);
      box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
    }

    .form-input.is-invalid {
      border-color: #ef4444;
    }

    .error-message {
      display: block;
      color: #ef4444;
      font-size: 0.875rem;
      margin-top: 0.5rem;
    }

    .form-group-checkbox {
      margin-bottom: 1.5rem;
    }

    .checkbox-label {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      cursor: pointer;
      user-select: none;
    }

    .checkbox-label input[type="checkbox"] {
      width: 18px;
      height: 18px;
      cursor: pointer;
    }

    .btn-auth {
      width: 100%;
      padding: 0.875rem 1.5rem;
      border: none;
      border-radius: 8px;
      font-size: 1rem;
      font-weight: 700;
      cursor: pointer;
      transition: all 0.3s;
    }

    .btn-primary-auth {
      background: linear-gradient(135deg, var(--accent-1), var(--accent-2));
      color: white;
    }

    .btn-primary-auth:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 25px rgba(124, 58, 237, 0.3);
    }

    .auth-links {
      text-align: center;
      margin-top: 1.5rem;
      color: #6b7280;
    }

    .auth-link {
      color: var(--accent-1);
      text-decoration: none;
      font-weight: 600;
      transition: color 0.3s;
    }

    .auth-link:hover {
      color: var(--accent-2);
    }

    .auth-separator {
      margin: 0 0.5rem;
      color: #d1d5db;
    }

    /* MOBILE MENU TOGGLE */
    .mobile-menu-btn {
      display: none;
      background: transparent;
      border: none;
      cursor: pointer;
      color: black;
      font-size: 1.5rem;
      padding: 0.5rem;
    }

    /* RESPONSIVE */
    @media (max-width: 1200px) {
      .navbar-wrapper {
        gap: 1rem;
      }

      .logo-img {
        max-width: 180px;
      }
    }

    @media (max-width: 1024px) {
      .mobile-menu-btn {
        display: block;
      }

      .navbar-links {
        position: fixed;
        top: 80px;
        left: 0;
        right: 0;
        bottom: 0;
        background: white;
        flex-direction: column;
        align-items: flex-start;
        padding: 2rem;
        transform: translateX(-100%);
        transition: transform 0.3s ease-in-out;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        z-index: 49;
        flex: none;
        width: 100%;
        overflow-y: auto;
      }

      .navbar-links.active {
        transform: translateX(0);
      }

      .navbar-links nav {
        flex-direction: column;
        width: 100%;
        align-items: stretch;
      }

      .nav-link {
        padding: 1rem;
        width: 100%;
        border-bottom: 1px solid #f3f4f6;
      }

      .dropdown-content {
        position: static;
        visibility: visible;
        opacity: 1;
        box-shadow: none;
        border: none;
        padding-left: 1.5rem;
        display: none;
        margin-top: 0;
      }

      .nav-item-dropdown.active .dropdown-content {
        display: block;
      }

      .navbar-right {
        margin-left: auto;
      }
    }

    @media (max-width: 768px) {
      .title {
        font-size: 2rem;
      }

      .subtitle {
        font-size: 1rem;
      }

      .section-title {
        font-size: 1.875rem;
      }

      .hero-slider {
        height: 300px;
      }

      .cta-section .container-custom {
        text-align: center;
      }

      .cta-contact {
        text-align: center;
      }
    }
  </style>
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