




<!DOCTYPE html>

<html lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Divine Darshan</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&amp;family=Playfair+Display:wght@400;500;600;700&amp;family=Hind+Vadodara:wght@400;500;600&amp;display=swap" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet"/>
<style>
    :root {
        --primary: #6C4AB6;
        --primary-light: #8D72E1;
        --primary-dark: #4D2D9E;
        --secondary: #FFD166;
        --accent: #B9E0FF;
        --light: #F8F6F4;
        --dark: #2D2727;
        --text-light: rgba(255,255,255,0.9);
        --text-dark: rgba(45,39,39,0.9);
        --transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
        --shadow-sm: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
        --shadow-md: 0 4px 6px rgba(0,0,0,0.1), 0 1px 3px rgba(0,0,0,0.08);
        --shadow-lg: 0 10px 25px rgba(0,0,0,0.1), 0 5px 10px rgba(0,0,0,0.05);
        --shadow-xl: 0 20px 40px rgba(0,0,0,0.15), 0 10px 20px rgba(0,0,0,0.1);
        --gold-light: #FFD700;
        --gold-dark: #D4AF37;
    }
    
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        -webkit-tap-highlight-color: transparent;
    }
    
    body {
        font-family: 'Poppins', sans-serif;
        color: var(--dark);
        overflow-x: hidden;
        background-color: var(--light);
        touch-action: pan-y;
        line-height: 1.7;
    }
    #donateFloatBtn {
    display: none !important;
}
    
    /* Custom Scrollbar */
    ::-webkit-scrollbar {
        width: 10px;
    }
    
    ::-webkit-scrollbar-track {
        background: rgba(108, 74, 182, 0.1);
    }
    
    ::-webkit-scrollbar-thumb {
        background: var(--primary);
        border-radius: 5px;
    }
    
    /* Header Styles */
    header {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        padding: 0 5%;
        height: 75px; /* Reduced from 90px */
        display: flex;
        justify-content: space-between;
        align-items: center;
        z-index: 1000;
        background-color: rgba(248, 246, 244, 0.98);
        backdrop-filter: blur(12px);
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.08);
        transform: translateY(0);
        transition: var(--transition);
        border-bottom: 1px solid rgba(108, 74, 182, 0.1);
    }

    header.hidden {
        transform: translateY(-100%);
        box-shadow: none;
    }
    
    .logo {
        display: flex;
        align-items: center;
        gap: 12px;
        z-index: 1001;
        transition: var(--transition);
        text-decoration: none;
    }

    .logo:hover {
        transform: scale(1.02);
    }

    .logo img {
        height: 50px; /* Reduced from 60px */
        width: auto;
        transition: var(--transition);
        filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
    }

    .logo-text {
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        font-size: 1.6rem; /* Reduced from 1.8rem */
        line-height: 1;
        color: var(--primary);
        transition: var(--transition);
        position: relative;
        text-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .logo-text::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 0;
        width: 0;
        height: 2px;
        background: var(--primary);
        transition: var(--transition);
    }

    .logo:hover .logo-text::after {
        width: 100%;
    }
    
    /* Navigation */
    nav ul {
        display: flex;
        list-style: none;
        gap: 30px;
    }
    
    nav ul li {
        position: relative;
    }
    
    .nav-link {
        text-decoration: none;
        color: rgb(36, 4, 83);
        font-weight: 500;
        font-size: 1rem; /* Reduced from 1.1rem */
        transition: var(--transition);
        position: relative;
        white-space: nowrap;
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 0; /* Reduced from 10px 0 */
    }

    .nav-text {
        position: relative;
    }

    .nav-underline {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 0;
        height: 2px;
        background: var(--primary);
        transition: var(--transition);
        transform-origin: left center;
    }

    .nav-link:hover .nav-underline {
        width: 100%;
    }

    .nav-link:hover {
        color: var(--primary);
    }

    .nav-link i {
        transition: var(--transition);
    }

    .nav-link:hover i {
        transform: translateY(-2px);
        color: var(--primary);
    }

    /* Menu Button and Dots */
    .nav-menu-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 45px; /* Reduced from 50px */
        height: 45px; /* Reduced from 50px */
        border-radius: 12px;
        background-color: rgba(108, 74, 182, 0.1);
        transition: var(--transition);
        cursor: pointer;
        flex-direction: column;
        gap: 5px;
        padding: 8px; /* Reduced from 10px */
    }

    .menu-dot {
        width: 20px;
        height: 4px;
        border-radius: 40%;
        background-color: rgb(36, 4, 83);
        transition: var(--transition);
    }

    .nav-menu-btn:hover {
        background-color: rgba(108, 74, 182, 0.2);
        transform: rotate(90deg);
    }

    .nav-menu-btn:hover .menu-dot {
        background-color: var(--primary);
        
    }

    /* Header Animation */
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    header {
        animation: fadeInDown 0.6s both;
    }

    nav ul li {
        animation: fadeInDown 0.6s both;
    }

    nav ul li:nth-child(1) { animation-delay: 0.1s; }
    nav ul li:nth-child(2) { animation-delay: 0.2s; }
    nav ul li:nth-child(3) { animation-delay: 0.3s; }
    nav ul li:nth-child(4) { animation-delay: 0.4s; }
    nav ul li:nth-child(5) { animation-delay: 0.5s; }
    
    /* Enhanced Dropdown Menu */
    .dropdown {
        position: relative;
    }
    
    .dropdown-content {
        position: absolute;
        top: 100%;
        right: 0;
        width: 280px;
        background-color: white;
        border-radius: 12px;
        box-shadow: var(--shadow-xl);
        padding: 15px 0;
        opacity: 0;
        visibility: hidden;
        transform: translateY(10px);
        transition: var(--transition);
        z-index: 100;
    }
    
    .dropdown:hover .dropdown-content {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }
    
    .dropdown-content a {
        display: flex;
        align-items: center;
        padding: 12px 25px;
        color: var(--dark);
        transition: var(--transition);
        font-size: 0.95rem;
        gap: 10px;
        text-decoration: none;
    }
    
    .dropdown-content a i {
        width: 20px;
        text-align: center;
        color: var(--primary);
        transition: var(--transition);
    }
    
    .dropdown-content a:hover {
        background-color: rgba(108, 74, 182, 0.08);
        color: var(--primary);
        padding-left: 28px;
    }
    
    .dropdown-content a:hover i {
        transform: scale(1.2);
    }
    
    .dropdown-login-btn {
        display: flex !important;
        justify-content: center !important;
        align-items: center !important;
        margin: 15px 20px 0 !important;
        padding: 14px 20px !important;
        background: linear-gradient(135deg, var(--primary), var(--primary-light)) !important;
        color: #fff !important;
        border-radius: 8px !important;
        text-align: center !important;
        font-weight: 600 !important;
        transition: var(--transition) !important;
        box-shadow: var(--shadow-md) !important;
        font-size: 1rem !important;
        text-decoration: none !important;
        border: none;
    }

    
    .dropdown-login-btn:hover {
        background: linear-gradient(135deg, var(--primary-light), var(--primary)) !important;
        transform: translateY(-2px) !important;
        box-shadow: var(--shadow-lg) !important;
        color: white !important;
    }

    
    /* Professional Three-Bar Menu - Redesigned */
    .dropdown-menu-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 45px; /* Reduced from 50px */
        height: 45px; /* Reduced from 50px */
        border-radius: 12px;
        background-color: rgba(108, 74, 182, 0.1);
        transition: var(--transition);
        cursor: pointer;
    }
    
    .dropdown-menu-btn:hover {
        background-color: rgba(108, 74, 182, 0.2);
        transform: rotate(90deg);
    }
    
    .dropdown-menu-btn i {
        font-size: 1.2rem;
        color: var(--primary);
    }
    
    .dropdown:last-child .dropdown-content {
        right: 0;
        width: 300px;
        padding: 15px 0;
        max-height: 70vh;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: var(--primary) rgba(108, 74, 182, 0.1);
    }
    
    .dropdown:last-child .dropdown-content::-webkit-scrollbar {
        width: 6px;
    }
    
    .dropdown:last-child .dropdown-content::-webkit-scrollbar-track {
        background: rgba(108, 74, 182, 0.1);
        border-radius: 3px;
    }
    
    .dropdown:last-child .dropdown-content::-webkit-scrollbar-thumb {
        background-color: var(--primary);
        border-radius: 3px;
    }
    
    .dropdown:last-child .dropdown-content a {
        padding: 14px 25px;
        font-size: 0.95rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .dropdown:last-child .dropdown-content a:last-child {
        border-bottom: none;
    }
    
    .dropdown:last-child .dropdown-content a:hover {
        padding-left: 28px;
    }
    
    .dropdown:last-child .dropdown-login-btn {
        margin: 20px 25px 0;
        padding: 12px 20px;
        font-size: 0.95rem;
    }
    
    /* Enhanced Hamburger Menu */
    .hamburger {
        display: none;
        cursor: pointer;
        z-index: 1001;
        width: 30px;
        height: 24px;
        position: relative;
        transition: var(--transition);
    }
    
    .hamburger div {
        position: absolute;
        width: 100%;
        height: 3px;
        background-color: var(--dark);
        border-radius: 3px;
        transition: all 0.3s cubic-bezier(0.8, 0.5, 0.2, 1.4);
        transform-origin: center;
    }
    
    .hamburger div:nth-child(1) {
        top: 0;
        left: 0;
    }
    
    .hamburger div:nth-child(2) {
        top: 50%;
        left: 0;
        transform: translateY(-50%);
        opacity: 1;
    }
    
    .hamburger div:nth-child(3) {
        bottom: 0;
        left: 0;
    }
    
    .hamburger.active div:nth-child(1) {
        transform: rotate(45deg) translate(5px, 9px);
        top: 0;
    }
    
    .hamburger.active div:nth-child(2) {
        opacity: 0;
        transform: translateX(-20px);
    }
    
    .hamburger.active div:nth-child(3) {
        transform: rotate(-45deg) translate(5px, -9px);
        bottom: 0;
    }
    
    /* Enhanced Mobile Menu - Redesigned */
    .mobile-menu {
        position: fixed;
        top: 75px; /* Adjusted to match new header height */
        left: -100%;
        width: 85%;
        max-width: 350px;
        height: calc(100vh - 75px); /* Adjusted to match new header height */
        background-color: white;
        transition: var(--transition);
        z-index: 1000;
        overflow-y: auto;
        box-shadow: 5px 0 15px rgba(0, 0, 0, 0.1);
        padding: 20px 0 100px;
        scrollbar-width: thin;
        scrollbar-color: var(--primary) rgba(108, 74, 182, 0.1);
        -webkit-overflow-scrolling: touch;
    }
    
    .mobile-menu::-webkit-scrollbar {
        width: 6px;
    }
    
    .mobile-menu::-webkit-scrollbar-track {
        background: rgba(108, 74, 182, 0.1);
        border-radius: 3px;
    }
    
    .mobile-menu::-webkit-scrollbar-thumb {
        background-color: var(--primary);
        border-radius: 3px;
    }
    
    .mobile-menu.active {
        left: 0;
    }
    
    .mobile-menu ul {
        list-style: none;
    }
    
    .mobile-menu ul li {
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .mobile-menu ul li a {
        display: flex;
        align-items: center;
        padding: 16px 25px;
        color: var(--dark);
        text-decoration: none;
        transition: var(--transition);
        font-size: 1rem;
        gap: 12px;
    }
    
    .mobile-menu ul li a i {
        width: 20px;
        text-align: center;
        color: var(--primary);
        transition: var(--transition);
    }
    
    .mobile-menu ul li a:hover {
        background-color: rgba(108, 74, 182, 0.1);
        color: var(--primary);
        padding-left: 30px;
    }
    
    .mobile-menu ul li a:hover i {
        transform: scale(1.2);
    }
    
    .mobile-submenu {
        padding-left: 20px;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.4s ease;
        background-color: rgba(108, 74, 182, 0.03);
    }
    
    .mobile-submenu.active {
        max-height: 500px;
    }
    
    .mobile-submenu a {
        padding-left: 35px !important;
        font-size: 0.9rem !important;
    }
    
    .mobile-submenu a i {
        font-size: 0.8rem;
    }
    
    .mobile-login-btn {
        display: block;
        margin: 25px;
        padding: 14px;
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        color: white;
        border-radius: 8px;
        text-align: center;
        font-weight: 600;
        text-decoration: none;
        transition: var(--transition);
        box-shadow: var(--shadow-md);
        border: none;
    }
    
    .mobile-login-btn:hover {
        background: linear-gradient(135deg, var(--primary-light), var(--primary));
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }
    
    /* Menu Overlay */
    .menu-overlay {
        position: fixed;
        top: 75px; /* Adjusted to match new header height */
        left: 0;
        width: 100%;
        height: calc(100vh - 75px); /* Adjusted to match new header height */
        background-color: rgba(0, 0, 0, 0.8);
        z-index: 999;
        opacity: 0;
        visibility: hidden;
        transition: var(--transition);
        pointer-events: auto;
    }
    
    .menu-overlay.active {
        opacity: 1;
        visibility: visible;
    }

    /* Footer */
    footer {
        background: linear-gradient(135deg, #102040, #060c18);
        color: white;
        padding: 80px 5% 40px;
        position: relative;
        overflow: hidden;
    }

    footer::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('https://i.imgur.com/mandala-pattern.png') center/cover no-repeat;
        opacity: 0.03;
        pointer-events: none;
    }
    
    .footer-content {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 40px;
        max-width: 1200px;
        margin: 0 auto;
        position: relative;
        z-index: 1;
    }
    
    .footer-column h3 {
        font-family: 'Playfair Display', serif;
        font-size: 1.5rem;
        margin-bottom: 25px;
        color: var(--secondary);
        position: relative;
        display: inline-block;
    }

    .footer-column h3::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 0;
        width: 50px;
        height: 2px;
        background: var(--primary-light);
    }
    
    .footer-column ul {
        list-style: none;
    }
    
    .footer-column ul li {
        margin-bottom: 15px;
    }
    
    .footer-column ul li a {
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .footer-column ul li a:hover {
        color: white;
        padding-left: 5px;
    }
    
    .footer-column ul li a i {
        width: 20px;
        text-align: center;
        transition: var(--transition);
    }

    /* Contacts Column */
    .footer-column.contacts-column h3 {
        color: var(--secondary);
    }
    
    .footer-column.contacts-column ul li a {
        white-space: nowrap;
    }

    /* Enhanced Social Media Icons */
    .footer-column ul li a.social-icon {
        position: relative;
        overflow: hidden;
        padding-left: 35px;
    }

    .footer-column ul li a.social-icon i {
        position: absolute;
        left: 0;
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: all 0.3s ease;
        font-size: 0.9rem;
    }

    .footer-column ul li a.social-icon:hover i {
        transform: scale(1.2) rotate(10deg);
    }

    .footer-column ul li a.facebook i {
        background-color: #3b5998;
    }

    .footer-column ul li a.instagram i {
        background: linear-gradient(45deg, #405de6, #5851db, #833ab4, #c13584, #e1306c, #fd1d1d);
    }

    .footer-column ul li a.youtube i {
        background-color: #ff0000;
    }

    .footer-column ul li a.twitter i {
        background-color: #1DA1F2;
    }

    .footer-column ul li a.whatsapp i {
        background-color: #25D366;
    }
    
    .footer-bottom {
        text-align: center;
        margin-top: 60px;
        padding-top: 30px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        color: rgba(255, 255, 255, 0.6);
        font-size: 0.9rem;
        position: relative;
        z-index: 1;
    }

    .footer-bottom p {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    /* Body class for when modal is open */
    body.modal-open {
        overflow: hidden;
        position: fixed;
        width: 100%;
    }

    /* Main content area */
    main {
        min-height: calc(100vh - 75px - 200px); /* Adjusted to match new header height */
        padding: 0;
        overflow: hidden;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 5%;
    }

    section {
        padding: 100px 0;
        position: relative;
    }

    @media (max-width: 768px) {
        .mobile-menu {
            height: 100dvh !important;
            overflow-y: auto !important;
            -webkit-overflow-scrolling: touch !important;
            overscroll-behavior-y: contain !important;
        }

        body.menu-open {
            touch-action: none;
        }
    }

    /* Responsive Styles */
    @media (max-width: 1200px) {
    }

    @media (max-width: 992px) {
        nav ul {
            gap: 15px;
        }
    }
    
    @media (max-width: 768px) {
        header {
            padding: 10px 5%;
            height: 70px; /* Adjusted to match new header height */
        }
        
        .logo img {
            height: 45px; /* Adjusted to match new header height */
        }
        
        .logo-text {
            font-size: 1.4rem; /* Adjusted to match new header height */
        }
        
        nav.desktop-nav {
            display: none;
        }
        
        .hamburger {
            display: block;
        }
        
        .mobile-menu {
            top: 70px; /* Adjusted to match new header height */
            height: calc(100vh - 70px); /* Adjusted to match new header height */
        }
        
        .menu-overlay {
            top: 70px; /* Adjusted to match new header height */
            height: calc(100vh - 70px); /* Adjusted to match new header height */
        }
    }
    
    @media (max-width: 480px) {
        .logo-text {
            font-size: 1.3rem;
        }
        
        .footer-content {
            grid-template-columns: 1fr;
        }
        
        .mobile-menu {
            width: 85%;
        }
    }
</style>
</head>
<body>
<!-- Header -->
<header id="header">
<a class="logo" href="index.html">
<img alt="ISKCON Burla logo" id="logo-img" src="https://i.imgur.com/dhcKR8L.png"/>
<span class="logo-text">ISKCON Burla</span>
</a>
<nav class="desktop-nav">
<ul>
<li>
<a class="nav-link" href="UpcomingEvents&Festivals.html">
<i class="fas fa-calendar-alt"></i>
<span class="nav-text">Events</span>
<span class="nav-underline"></span>
</a>
</li>
<li>
<a class="nav-link" href="TempleStore.html">
<i class="fas fa-store"></i>
<span class="nav-text">Temple Store</span>
<span class="nav-underline"></span>
</a>
</li>
<li>
<a class="nav-link" href="GauSeva.html">
<i class="fas fa-cow"></i>
<span class="nav-text">Gau Seva</span>
<span class="nav-underline"></span>
</a>
</li>
<li class="dropdown">
<a class="nav-link" href="javascript:void(0);">
<i class="fas fa-hands-helping"></i>
<span class="nav-text">Seva Opportunities</span>
<i class="fas fa-chevron-down dropdown-icon"></i>
<span class="nav-underline"></span>
</a>
<div class="dropdown-content">
<a href="VolunteerOpportunities.html"><i class="fas fa-kitchen-set"></i> Cooking Seva</a>
<a href="VolunteerOpportunities.html"><i class="fas fa-broom"></i> Cleaning Seva</a>
<a href="VolunteerOpportunities.html"><i class="fas fa-book"></i> Book Distribution</a>
<a href="VolunteerOpportunities.html"><i class="fas fa-music"></i> Kirtan Seva</a>
<a href="VolunteerOpportunities.html"><i class="fas fa-hand-holding-heart"></i> Volunteer</a>
<a class="dropdown-login-btn" href="NityaSevak.html">Become Nitya sevak</a> <!-- Check this link again -->
</div>
</li>
<li class="dropdown">
<a class="nav-menu-btn" href="javascript:void(0);">
<div class="menu-dot"></div>
<div class="menu-dot"></div>
<div class="menu-dot"></div>
</a>
<div class="dropdown-content">
<a href="index.html"><i class="fas fa-home"></i> Home</a>
<a href="DailyDarshan.html"><i class="fas fa-images"></i> Daily Darshan</a>
<a href="SpiritualCounseling.html"><i class="fas fa-book-open"></i> Spiritual Counceling</a>
<a href="TempleAdministration.html"><i class="fa-solid fa-people-roof"></i> Temple Administration</a>
<a href="AboutUs.html"><i class="fas fa-info-circle"></i> About Us</a>
<a href="ContactUs.html"><i class="fas fa-map-marker-alt"></i> Contact</a>
<a class="dropdown-login-btn" href="Login.html">IYF Admin Login</a>
</div>
</li>
</ul>
</nav>
<div class="hamburger">
<div></div>
<div></div>
<div></div>
</div>
</header>
<!-- Mobile Menu -->
<div class="mobile-menu">
<ul>
<li><a href="index.html"><i class="fas fa-home"></i> Home</a></li>
<li><a href="UpcomingEvents&Festivals.html"><i class="fas fa-calendar-alt"></i> Events</a></li>
<li><a href="TempleStore.html"><i class="fas fa-store"></i> Temple Store</a></li>
<li><a href="GauSeva.html"><i class="fas fa-cow"></i> Gau Seva</a></li>
<li style="background: var(--primary-light);">
  <a href="javascript:void(0);" style="color: white;">
    <i class="fas fa-video" style="color:white;"></i> Daily Darshan
  </a>
</li>
<li class="mobile-dropdown">
<a class="mobile-dropdown-toggle" href="javascript:void(0);"><i class="fas fa-hands-helping"></i> Seva Opportunities <i class="fas fa-chevron-down"></i></a>
<div class="mobile-submenu">
<a href="VolunteerOpportunities.html"><i class="fas fa-kitchen-set"></i> Cooking Seva</a>
<a href="VolunteerOpportunities.html"><i class="fas fa-broom"></i> Cleaning Seva</a>
<a href="VolunteerOpportunities.html"><i class="fas fa-book"></i> Book Distribution</a>
<a href="VolunteerOpportunities.html"><i class="fas fa-music"></i> Kirtan Seva</a>
<a href="VolunteerOpportunities.html"><i class="fas fa-hand-holding-heart"></i> Volunteer</a>
</div>
</li>
<li><a href="NityaSevak.html"><i class="fas fa-hands-praying"></i> Become Nitya Sevak</a></li>
<li><a href="TempleAdministration.html"><i class="fa-solid fa-people-roof"></i> Temple Administration</a></li>
<li><a href="AboutUs.html"><i class="fas fa-info-circle"></i> About Us</a></li>
<li><a href="ContactUs.html"><i class="fas fa-map-marker-alt"></i> Contact</a></li>
</ul>
<a class="mobile-login-btn" href="Login.html">IYF Admin Login</a> <!-- Add new link -->
</div>
<div class="menu-overlay"></div>
<!-- Main Content Area -->
<main>
<!-- Content will be added here -->

<main>
    <section class="darshan-hero">
      <div class="container">
        <div class="hero-content">
          <h1 class="animate-on-scroll">Daily Darshan</h1>
          <p class="animate-on-scroll">Experience the divine presence of Sri Sri Sita Ram Lakshman Hanuman, daily through our live darshan and gallery</p>
        </div>
      </div>
    </section>
  
    <section class="live-darshan">
      <div class="container">
        <div class="section-header animate-on-scroll">
          <h2>Live Darshan</h2>
          <p>Watch the deities live from ISKCON Burla Temple</p>
        </div>
        
        <div class="video-wrapper">
    <?php
    $dataFile = 'data/darshan-data.json';
    if (file_exists($dataFile)) {
        $data = json_decode(file_get_contents($dataFile), true);
        $youtubeUrl = $data['youtube_url'];
        // Extract video ID from URL
        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $youtubeUrl, $matches);
        $videoId = isset($matches[1]) ? $matches[1] : 'HeiO6e0BhFI';
    } else {
        $videoId = 'HeiO6e0BhFI';
    }
    ?>
    <iframe src="https://www.youtube.com/embed/<?= $videoId ?>?autoplay=1&mute=1" frameborder="0" allowfullscreen></iframe>
</div>
          <div class="video-info">
            <div class="timing">
              <i class="fas fa-clock"></i>
              <span>Live from 4:30 AM to 9:00 PM (IST)</span>
            </div>
            <div class="arati-schedule">
              <h4>Daily Arati Schedule:</h4>
              <ul>
                <li><strong>Mangala Arati:</strong> 4:30 AM</li>
                <li><strong>Darshan Arati:</strong> 7:30 AM</li>
                <li><strong>Raj Bhoga Arati:</strong> 12:30 PM</li>
                <li><strong>Evening Arati:</strong> 6:30 PM</li>
                <li><strong>Shayana Arati:</strong> 8:30 PM</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>
  
    <!-- Gallery Section -->
<div class="gallery-grid">
    <?php
    include 'admin/config.php'; // adjust path if needed

    $result = $conn->query("SELECT * FROM darshan_gallery ORDER BY uploaded_at DESC LIMIT 20");

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '
            <div class="gallery-item animate-on-scroll">
                <img src="' . $row['image_path'] . '" alt="' . htmlspecialchars($row['caption']) . '" loading="lazy">
                <div class="gallery-caption">' . htmlspecialchars($row['caption']) . '</div>
            </div>';
        }
    } else {
        // fallback images if no uploads yet
        echo '
        <div class="gallery-item animate-on-scroll">
            <img src="https://iskconburla.com/images/image-will-be-uploaded.jpg" alt="Sita Ram during morning arati" loading="lazy">
            <div class="gallery-caption">Sita Ram during morning arati</div>
        </div>
        <div class="gallery-item animate-on-scroll">
            <img src="https://iskconburla.com/images/image-will-be-uploaded.jpg" alt="Deities in summer attire" loading="lazy">
            <div class="gallery-caption">Deities in summer attire</div>
        </div>';
    }
    ?>
</div>

    <section class="darshan-info">
      <div class="container">
        <div class="info-grid animate-on-scroll">
          <div class="info-card">
            <i class="fas fa-hands-praying"></i>
            <h3>Significance of Darshan</h3>
            <p>Darshan is not mere seeing, but a sacred vision that purifies the heart and awakens divine love. It's a reciprocal exchange of love between the devotee and the Lord.</p>
          </div>
          <div class="info-card">
            <i class="fas fa-bell"></i>
            <h3>Dress Code</h3>
            <p>We recommend modest clothing when attending darshan. Traditional Indian attire is preferred but not mandatory. Please maintain silence in the temple hall.</p>
          </div>
          <div class="info-card">
            <i class="fas fa-gift"></i>
            <h3>Offerings</h3>
            <p>Devotees may offer flowers, fruits or sweets to the deities during darshan times. All offerings should be pure, fresh and sanctified before presentation.</p>
          </div>
        </div>
      </div>
    </section>
  </main>
  
  <style>
    /* Hero Section */
    .darshan-hero {
      background: linear-gradient(rgba(45, 39, 39, 0.8), rgba(45, 39, 39, 0.8)), 
                  url('https://i.imgur.com/mandala-bg.jpg') center/cover no-repeat;
      color: white;
      padding: 120px 0 80px;
      text-align: center;
      position: relative;
    }
    
    .hero-content h1 {
      font-family: 'Playfair Display', serif;
      font-size: 3.5rem;
      margin-bottom: 20px;
      color: var(--secondary);
      text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }
    
    .hero-content p {
      font-size: 1.2rem;
      max-width: 700px;
      margin: 0 auto;
      opacity: 0.9;
    }
    
    /* Live Darshan Section */
    .live-darshan {
      padding: 80px 0;
      background-color: white;
    }
    
    .section-header {
      text-align: center;
      margin-bottom: 50px;
    }
    
    .section-header h2 {
      font-family: 'Playfair Display', serif;
      font-size: 2.5rem;
      color: var(--primary);
      margin-bottom: 15px;
    }
    
    .section-header p {
      color: var(--text-dark);
      font-size: 1.1rem;
    }
    
    .video-container {
      background: white;
      border-radius: 16px;
      box-shadow: var(--shadow-lg);
      overflow: hidden;
    }
    
    .video-wrapper {
      position: relative;
      padding-bottom: 56.25%; /* 16:9 aspect ratio */
      height: 0;
      overflow: hidden;
    }
    
    .video-wrapper iframe {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      border: none;
    }
    
    .video-info {
      padding: 25px;
      background-color: var(--light);
      display: flex;
      flex-wrap: wrap;
      gap: 30px;
    }
    
    .timing {
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 1.1rem;
      color: var(--primary-dark);
      font-weight: 500;
    }
    
    .timing i {
      color: var(--secondary);
      font-size: 1.3rem;
    }
    
    .arati-schedule {
      flex: 1;
      min-width: 250px;
    }
    
    .arati-schedule h4 {
      margin-bottom: 15px;
      color: var(--primary);
      font-size: 1.2rem;
    }
    
    .arati-schedule ul {
      list-style: none;
    }
    
    .arati-schedule li {
      margin-bottom: 8px;
      display: flex;
      justify-content: space-between;
      max-width: 300px;
    }
    
    .arati-schedule li strong {
      color: var(--primary-dark);
    }
    
    /* Gallery Section */
    .darshan-gallery {
      padding: 80px 0;
      background-color: var(--light);
    }
    
    .gallery-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 20px;
    }
    
    .gallery-item {
      position: relative;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: var(--shadow-md);
      transition: var(--transition);
      aspect-ratio: 1/1;
    }
    
    .gallery-item:hover {
      transform: translateY(-5px);
      box-shadow: var(--shadow-lg);
    }
    
    .gallery-item img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: var(--transition);
    }
    
    .gallery-item:hover img {
      transform: scale(1.05);
    }
    
    .gallery-caption {
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      background: linear-gradient(transparent, rgba(0,0,0,0.7));
      color: white;
      padding: 15px;
      transform: translateY(100%);
      transition: var(--transition);
    }
    
    .gallery-item:hover .gallery-caption {
      transform: translateY(0);
    }
    
    /* Info Section */
    .darshan-info {
      padding: 80px 0;
      background-color: white;
    }
    
    .info-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 30px;
    }
    
    .info-card {
      background: var(--light);
      padding: 30px;
      border-radius: 12px;
      text-align: center;
      box-shadow: var(--shadow-sm);
      transition: var(--transition);
    }
    
    .info-card:hover {
      transform: translateY(-5px);
      box-shadow: var(--shadow-md);
    }
    
    .info-card i {
      font-size: 2.5rem;
      color: var(--primary);
      margin-bottom: 20px;
    }
    
    .info-card h3 {
      font-family: 'Playfair Display', serif;
      margin-bottom: 15px;
      color: var(--primary-dark);
    }
    
    .info-card p {
      color: var(--text-dark);
    }
    
    /* Animations */
    .animate-on-scroll {
      opacity: 0;
      transform: translateY(30px);
      transition: opacity 0.6s ease, transform 0.6s ease;
    }
    
    .animate-on-scroll.animated {
      opacity: 1;
      transform: translateY(0);
    }
    
    /* Responsive Styles */
    @media (max-width: 768px) {
      .darshan-hero {
        padding: 100px 0 60px;
      }
      
      .hero-content h1 {
        font-size: 2.5rem;
      }
      
      .section-header h2 {
        font-size: 2rem;
      }
      
      .video-info {
        flex-direction: column;
        gap: 20px;
      }
      
      .info-grid {
        grid-template-columns: 1fr;
      }
    }
    
    @media (max-width: 480px) {
      .hero-content h1 {
        font-size: 2rem;
      }
      
      .hero-content p {
        font-size: 1rem;
      }
      
      .section-header h2 {
        font-size: 1.8rem;
      }
    }
    .social-icons-footer {
  display: flex;
 
  align-items: center;
  gap: 20px;
  padding: 20px 0;
}

.social-icons-footer .icon {
  position: relative;
  width: 50px;
  height: 50px;
  border-radius: 50%;
  display: flex;
  justify-content: center;
  align-items: center;
  text-decoration: none;
  transition: all 0.3s ease;
  box-shadow: 0 5px 15px rgba(0,0,0,0.2);
  overflow: hidden;
}

.social-icons-footer .icon svg {
  width: 24px;
  height: 24px;
  fill: white;
  z-index: 1;
  transition: all 0.3s ease;
}

.social-icons-footer .icon::before {
  content: "";
  position: absolute;
  width: 120%;
  height: 120%;
  background: linear-gradient(45deg, transparent, transparent);
  transform: rotate(45deg);
  transition: all 0.3s ease;
}

.social-icons-footer .icon:hover {
  transform: translateY(-5px);
  box-shadow: 0 15px 25px rgba(0,0,0,0.3);
}

.social-icons-footer .icon:hover svg {
  transform: scale(1.2);
}

/* YouTube */
.social-icons-footer .youtube {
  background: #FF0000;
}

.social-icons-footer .youtube:hover::before {
  background: linear-gradient(45deg, #FF0000, #FF5E5E);
  animation: shine 1.5s infinite;
}

/* Facebook */
.social-icons-footer .facebook {
  background: #3b5998;
}

.social-icons-footer .facebook:hover::before {
  background: linear-gradient(45deg, #3b5998, #8b9dc3);
  animation: shine 1.5s infinite;
}

/* Instagram */
.social-icons-footer .instagram {
  background: #f09433;
  background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
}

.social-icons-footer .instagram:hover::before {
  background: linear-gradient(45deg, #f09433, #bc1888);
  animation: shine 1.5s infinite;
}

/* Twitter (X) */
.social-icons-footer .twitter {
  background: #000000;
}

.social-icons-footer .twitter:hover::before {
  background: linear-gradient(45deg, #000000, #434343);
  animation: shine 1.5s infinite;
}

/* Animation */
@keyframes shine {
  0% {
    left: -100%;
  }
  20%, 100% {
    left: 100%;
  }
}

/* Responsive */
@media (max-width: 768px) {
  .social-icons-footer {
    gap: 15px;
  }
  
  .social-icons-footer .icon {
    width: 40px;
    height: 40px;
  }
  
  .social-icons-footer .icon svg {
    width: 20px;
    height: 20px;
  }
}
  </style>
  
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Gallery images data
      const galleryImages = [
        {
          url: 'https://iskconburla.com/images/image-will-be-uploaded.jpg',
          caption: 'Sita Ram during morning arati'
        },
        {
          url: 'https://iskconburla.com/images/image-will-be-uploaded.jpg',
          caption: 'Deities in summer attire'
        },
        {
          url: 'https://iskconburla.com/images/image-will-be-uploaded.jpg',
          caption: 'Jhulan Yatra special decoration'
        },
        {
          url: 'https://iskconburla.com/images/image-will-be-uploaded.jpg',
          caption: 'Gaura Purnima festival'
        },
        {
          url: 'https://iskconburla.com/images/image-will-be-uploaded.jpg',
          caption: 'Janmashtami midnight celebration'
        },
        {
          url: 'https://iskconburla.com/images/image-will-be-uploaded.jpg',
          caption: 'Winter season darshan'
        },
        {
          url: 'https://iskconburla.com/images/image-will-be-uploaded.jpg',
          caption: 'Flower decoration special'
        },
        {
          url: 'https://iskconburla.com/images/image-will-be-uploaded.jpg',
          caption: 'Evening arati darshan'
        },
        {
          url: 'https://iskconburla.com/images/image-will-be-uploaded.jpg',
          caption: 'Govardhan Puja celebration'
        },
        {
          url: 'https://iskconburla.com/images/image-will-be-uploaded.jpg',
          caption: 'Temple anniversary decoration'
        },
        {
          url: 'https://iskconburla.com/images/image-will-be-uploaded.jpg',
          caption: 'Special Sunday feast darshan'
        },
        {
          url: 'https://iskconburla.com/images/image-will-be-uploaded.jpg',
          caption: 'Radhashtami festival'
        }
      ];
      
      // Generate gallery items
      const galleryGrid = document.querySelector('.gallery-grid');
      
      galleryImages.forEach(image => {
        const galleryItem = document.createElement('div');
        galleryItem.className = 'gallery-item animate-on-scroll';
        
        galleryItem.innerHTML = `
          <img src="${image.url}" alt="${image.caption}" loading="lazy">
          <div class="gallery-caption">${image.caption}</div>
        `;
        
        galleryGrid.appendChild(galleryItem);
      });
      
      // Initialize animations on scroll
      const animateOnScroll = function() {
        const elements = document.querySelectorAll('.animate-on-scroll');
        const windowHeight = window.innerHeight;
        
        elements.forEach(element => {
          const elementPosition = element.getBoundingClientRect().top;
          const elementVisible = 150;
          
          if (elementPosition < windowHeight - elementVisible) {
            element.classList.add('animated');
          }
        });
      };
      
      window.addEventListener('scroll', animateOnScroll);
      animateOnScroll(); // Run once on load
      
      // Preload gallery images
      galleryImages.forEach(image => {
        const img = new Image();
        img.src = image.url;
      });
      
      // Handle YouTube iframe loading for better performance
      const videoWrapper = document.querySelector('.video-wrapper');
      
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            const iframe = videoWrapper.querySelector('iframe');
            if (!iframe.src.includes('autoplay=1')) {
              iframe.src += '&autoplay=1&mute=1';
            }
          }
        });
      }, { threshold: 0.5 });
      
      observer.observe(videoWrapper);
    });
  </script>
</main>
<!-- Footer -->
<footer>
<div class="footer-content">
    <div class="footer-column">
    <h3>Connect With Us</h3>
<div class="social-icons-footer">
  <a href="https://youtube.com/@ISKCONBURLA" class="icon youtube" aria-label="YouTube">
    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
      <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
    </svg>
  </a>
  
  <a href="https://facebook.com/iskcon.burla.14" class="icon facebook" aria-label="Facebook">
    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
      <path d="M22.675 0H1.325C.593 0 0 .593 0 1.325v21.351C0 23.407.593 24 1.325 24H12.82v-9.294H9.692v-3.622h3.128V8.413c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12V24h6.116c.73 0 1.323-.593 1.323-1.325V1.325C24 .593 23.407 0 22.675 0z"/>
    </svg>
  </a>
  
  <a href="https://instagram.com/burlaiskcon" class="icon instagram" aria-label="Instagram">
    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
      <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
    </svg>
  </a>
  
  <a href="https://twitter.com/padasevaprabhu" class="icon twitter" aria-label="Twitter">
    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
      <path d="M20.37 3H16.7l-3.99 5.15L8.7 3H3.63l6.52 8.37L2.8 21h3.67l4.39-5.68L15.3 21h5.08l-6.58-8.47L20.37 3z"/>

    </svg>
  </a>
</div>
</div>
<div class="footer-column">
<h3>Temple Services</h3>
<ul>
<li><a href="DailyDarshan.html"><i class="fas fa-bell"></i> Daily Darshan</a></li>
<li><a href="SundayLoveFeast.html"><i class="fas fa-utensils"></i> Sunday Love Feast</a></li>
<li><a href="GauSeva.html"><i class="fas fa-cow"></i> Gau Seva</a></li>
<li><a href="VolunteerOpportunities"><i class="fas fa-hands-helping"></i> Volunteer</a></li>
</ul>
</div>
<div class="footer-column">
<h3>Resources and info</h3>
<ul>
<li><a href="UpcomingPage"><i class="fas fa-book-open"></i> Bhagavad-gita</a></li>
<li><a href="UpcomingPage"><i class="fas fa-book"></i>Srila Prabhupad Books</a></li>
<li><a href="BooksDistribution.html"><i class="fa-solid fa-y"></i>Youth Programs</a></li>
<li><a href="TempleActivities.html"><i class="fa-solid fa-users"></i> Temple Activities</a></li>
</ul>
</div>


<div class="footer-column contacts-column">
    <h3>Contacts</h3>
    <ul>
    <li><a href="tel:+919437129998"><i class="fas fa-phone"></i> +91 94371 29998</a></li>
    <li><a href="mailto:info@iskconburla.com"><i class="fas fa-envelope"></i> info@iskconburla.com</a></li>
    <li><a href="javascript:void(0);"><i class="fas fa-clock"></i> Open Every day</a></li>
    <li><a href="javascript:void(0);" style="display: inline-block; white-space: normal; word-break: break-word;">
        <i class="fas fa-map-marker-alt"></i> ISKCON Burla, near Siphon, PC Bridge, Burla, Sambalpur, Odisha, India, 768019
      </a></li>

    </ul>
    </div>
</div>
<div class="footer-bottom">
<p><i class="far fa-copyright"></i> 2025 ISKCON Burla. All Rights Reserved. AI assistance is used. </p>
<p> This website is a humble offering of Seva by IYF team under the leadership of HG Asit Krishna Prabhu & HG Amayi Prabu (Temple President). </p>
</div>
</footer>
<script>
    // Mobile Menu Toggle
    const hamburger = document.querySelector('.hamburger');
    const mobileMenu = document.querySelector('.mobile-menu');
    const menuOverlay = document.querySelector('.menu-overlay');
    const mobileDropdownToggles = document.querySelectorAll('.mobile-dropdown-toggle');
    
    hamburger.addEventListener('click', () => {
        hamburger.classList.toggle('active');
        mobileMenu.classList.toggle('active');
        menuOverlay.classList.toggle('active');
        document.body.classList.toggle('menu-open');
    });
    menuOverlay.addEventListener('click', () => {
        hamburger.classList.remove('active');
        mobileMenu.classList.remove('active');
        menuOverlay.classList.remove('active');
        document.body.classList.remove('menu-open');
    });
    
    // Mobile Dropdown Toggle
    mobileDropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', () => {
            const parent = toggle.parentElement;
            const submenu = parent.querySelector('.mobile-submenu');
            const icon = toggle.querySelector('.fa-chevron-down');
            
            parent.classList.toggle('active');
            submenu.classList.toggle('active');
            icon.classList.toggle('fa-rotate-180');
        });
    });
    
    // Header Scroll Behavior
    const header = document.getElementById('header');
    let lastScroll = 0;
    
    window.addEventListener('scroll', () => {
        const currentScroll = window.pageYOffset;
        
        if (currentScroll <= 0) {
            header.classList.remove('hidden');
            return;
        }
        
        if (currentScroll > lastScroll && !header.classList.contains('hidden')) {
            // Scroll down
            header.classList.add('hidden');
        } else if (currentScroll < lastScroll && header.classList.contains('hidden')) {
            // Scroll up
            header.classList.remove('hidden');
        }
        
        lastScroll = currentScroll;
    });
    
    // Responsive Adjustments
    function handleResize() {
        // Close mobile menu if open when resizing to desktop
        if (window.innerWidth > 768             && mobileMenu.classList.contains('active')) {
            hamburger.classList.remove('active');
            mobileMenu.classList.remove('active');
            menuOverlay.classList.remove('active');
            document.body.classList.remove('menu-open');
        }
    }

    window.addEventListener('resize', handleResize);

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });

    // Animation on scroll initialization
    function initAOS() {
        const elements = document.querySelectorAll('.animate-on-scroll');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animated');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        elements.forEach(element => {
            observer.observe(element);
        });
    }

    // Initialize when DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
        initAOS();
        
        // Preload images
        const images = [
            'https://i.imgur.com/dhcKR8L.png',
            // Add other important images to preload here
        ];
        
        images.forEach(img => {
            new Image().src = img;
        });
    });
</script>
</body>
</html>