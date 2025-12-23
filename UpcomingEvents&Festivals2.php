<?php
include 'admin/config.php';

$sql = "SELECT * FROM events ORDER BY created_at DESC";
$result = $conn->query($sql);
?>



<!DOCTYPE html>

<html lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Upcoming Events & Festivals</title>
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
<li style="background: var(--primary-light);">
  <a href="javascript:void(0);" style="color: white;">
    <i class="fas fa-calendar-alt" style="color:white;"></i> Events
  </a>
</li>
<li><a href="TempleStore.html"><i class="fas fa-store"></i> Temple Store</a></li>
<li><a href="GauSeva.html"><i class="fas fa-cow"></i> Gau Seva</a></li>
<li><a href="DailyDarshan.html"><i class="fas fa-video"></i> Daily Darshan</a></li>
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
<!-- Main Content -->
<main>
    <section class="events-hero">
      <div class="container">
        <div class="hero-content">
          <h1 class="animate-on-scroll">Upcoming Events & Festivals</h1>
          <p class="animate-on-scroll">Join us in celebrating divine occasions and spiritual gatherings at ISKCON Burla</p>
          <div class="hero-buttons animate-on-scroll">
            <a href="#featured-events" class="btn-primary">View Events</a>
            <a href="#calendar-ekadashi" class="btn-primary">Calendar & Ekadashi</a>
            <a href="#weekly-programs" class="btn-outline">Weekly Programs</a>
          </div>
        </div>
      </div>
    </section>
  
<section id="featured-events" class="featured-events">
      <div class="container">
        <div class="section-header animate-on-scroll"> 
          <h2>Featured Events</h2>
          <p>Don't miss these upcoming spiritual gatherings</p>
        </div>
        
        <div class="events-grid">


          <div id="dynamic-events">
  <p>Loading events...</p>
</div>

<div class="event-cards-wrapper" style="display: flex; flex-wrap: wrap; gap: 20px; justify-content: center;">
<?php while ($row = $result->fetch_assoc()): ?> 
    <div class="event-card animate-on-scroll" style="width: 320px; border: 1px solid #ddd; border-radius: 10px; overflow: hidden;">
        <div class="event-image" style="position: relative;">
            <img src="<?= $row['image_url'] ?>" alt="<?= htmlspecialchars($row['title']) ?>" style="width: 100%; height: auto;">
            <div class="event-date" style="position: absolute; top: 10px; right: 10px; background: white; padding: 4px 8px; border-radius: 5px;">
                <span class="date-day"><?= $row['date_day'] ?></span>
                <span class="date-month"><?= $row['date_month'] ?></span>
            </div>
        </div>
        <div class="event-details" style="padding: 15px;">
            <h3><?= htmlspecialchars($row['title']) ?></h3>
            <div class="event-meta" style="font-size: 14px; color: #555;">
                <span><i class="fas fa-clock"></i> <?= $row['event_time'] ?></span><br>
                <span><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($row['location']) ?></span>
            </div>
            <?php
$desc = str_replace(["\\r\\n", "\\n", "\\r", "\\n"], "\n", $row['short_description']);
?>
<p><?= nl2br(htmlspecialchars($desc)) ?></p>


            <div class="event-actions" style="margin-top: 10px;">
                <?php if (!empty($row['register_link'])): ?>
                    <a href="<?= $row['register_link'] ?>" class="btn-small">Register</a>
                <?php endif; ?>
                <?php if (!empty($row['donate_link'])): ?>
                    <a href="<?= $row['donate_link'] ?>" class="btn-small">Donate</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endwhile; ?>
</div>










        </div>  
      </div>
    </section>
    <!-- Calendar Section -->
     <!-- Optimized Calendar Page Body Content -->
<section id="calendar-ekadashi" class="calendar-section">
  <div class="container">
    <div class="section-header">
      <h1 class="section-title">Temple Calendar</h1>
      <p class="section-subtitle">Important events and festivals at ISKCON Burla</p>
    </div>

    <div class="calendar-container">
      <div class="calendar-header">
        <button class="nav-btn prev-month" aria-label="Previous month">
          <i class="fas fa-chevron-left"></i>
        </button>
        <h2 class="month-year-display">June 2025</h2>
        <button class="nav-btn next-month" aria-label="Next month">
          <i class="fas fa-chevron-right"></i>
        </button>
      </div>

      <div class="calendar-grid">
        <div class="day-names">
          <div>Sun</div>
          <div>Mon</div>
          <div>Tue</div>
          <div>Wed</div>
          <div>Thu</div>
          <div>Fri</div>
          <div>Sat</div>
        </div>
        
        <div class="days-container">
          <!-- Days will be populated by JavaScript -->
        </div>
      </div>
    </div>

    <div class="events-list">
      <h3 class="events-title">Upcoming Events</h3>
      <div class="events-container">
        <!-- Events will be populated by JavaScript -->
      </div>
    </div>
  </div>
</section>

<script>
  fetch("admin/load_events.php")
    .then(res => res.text())
    .then(data => {
      document.getElementById("dynamic-events").innerHTML = data;
    })
    .catch(err => {
      document.getElementById("dynamic-events").innerHTML = "Error loading events.";
    });
</script>
    <!-- Calendar Section -->
     <!-- Optimized Calendar Page Body Content -->
<section id="calendar-ekadashi" class="calendar-section">
  <div class="container">
    <div class="section-header">
      <h1 class="section-title">Temple Calendar</h1>
      <p class="section-subtitle">Important events and festivals at ISKCON Burla</p>
    </div>

    <div class="calendar-container">
      <div class="calendar-header">
        <button class="nav-btn prev-month" aria-label="Previous month">
          <i class="fas fa-chevron-left"></i>
        </button>
        <h2 class="month-year-display">June 2025</h2>
        <button class="nav-btn next-month" aria-label="Next month">
          <i class="fas fa-chevron-right"></i>
        </button>
      </div>

      <div class="calendar-grid">
        <div class="day-names">
          <div>Sun</div>
          <div>Mon</div>
          <div>Tue</div>
          <div>Wed</div>
          <div>Thu</div>
          <div>Fri</div>
          <div>Sat</div>
        </div>
        
        <div class="days-container">
          <!-- Days will be populated by JavaScript -->
        </div>
      </div>
    </div>

    <div class="events-list">
      <h3 class="events-title">Upcoming Events</h3>
      <div class="events-container">
        <!-- Events will be populated by JavaScript -->
      </div>
    </div>
  </div>
</section>

<style>
  /* Optimized Calendar Styles */
  .calendar-section {
    padding: 60px 0;
    background-color: var(--light);
    will-change: transform;
  }

  .section-header {
    text-align: center;
    margin-bottom: 40px;
  }

  .section-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(1.8rem, 4vw, 2.5rem);
    color: var(--primary-dark);
    margin-bottom: 10px;
  }

  .section-subtitle {
    color: var(--text-dark);
    font-size: clamp(0.9rem, 2vw, 1.1rem);
    max-width: 700px;
    margin: 0 auto;
  }

  .calendar-container {
    background-color: white;
    border-radius: 16px;
    box-shadow: var(--shadow-lg);
    overflow: hidden;
    margin-bottom: 40px;
    will-change: transform;
  }

  .calendar-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 20px;
    background: linear-gradient(135deg, var(--primary), var(--primary-light));
    color: white;
    position: relative;
    z-index: 2;
  }

  .month-year-display {
    font-family: 'Playfair Display', serif;
    font-size: clamp(1.2rem, 3vw, 1.5rem);
    font-weight: 600;
    margin: 0;
    text-align: center;
    flex-grow: 1;
    will-change: contents;
  }

  .nav-btn {
    background: rgba(255, 255, 255, 0.2);
    border: none;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    color: white;
    cursor: pointer;
    transition: transform 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    will-change: transform;
  }

  .nav-btn:active {
    transform: scale(0.95);
  }

  .calendar-grid {
    display: flex;
    flex-direction: column;
    width: 100%;
    will-change: transform;
  }

  .day-names {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    text-align: center;
    padding: 12px 0;
    background-color: rgba(108, 74, 182, 0.05);
    font-weight: 600;
    color: var(--primary-dark);
    font-size: clamp(0.7rem, 2vw, 0.9rem);
  }

  .days-container {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    min-height: 0;
    transition: height 0.3s ease;
  }

  .calendar-day {
    padding: 8px 4px;
    border: 1px solid rgba(0, 0, 0, 0.05);
    min-height: 0;
    aspect-ratio: 1/1;
    display: flex;
    flex-direction: column;
    position: relative;
    background-color: white;
    will-change: transform, background-color;
  }

  .day-number {
    align-self: flex-end;
    font-weight: 500;
    margin-bottom: 2px;
    font-size: clamp(0.7rem, 2vw, 0.9rem);
    will-change: transform;
  }

  .today .day-number {
    background-color: var(--primary);
    color: white;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .event-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background-color: var(--secondary);
    position: absolute;
    top: 6px;
    right: 6px;
    will-change: transform;
  }

  .events-list {
    background-color: white;
    border-radius: 16px;
    box-shadow: var(--shadow-lg);
    padding: 25px;
  }

  .events-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(1.4rem, 3vw, 1.8rem);
    color: var(--primary-dark);
    margin-bottom: 20px;
  }

  .events-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 15px;
    will-change: contents;
  }

  .event-card {
    background-color: rgba(108, 74, 182, 0.03);
    border-radius: 10px;
    padding: 18px;
    border-left: 4px solid var(--primary);
    transition: transform 0.2s ease;
    will-change: transform;
  }

  .event-card:active {
    transform: scale(0.98);
  }

  .event-date {
    font-weight: 600;
    color: var(--primary);
    margin-bottom: 6px;
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: clamp(0.8rem, 2vw, 0.9rem);
  }

  .event-title {
    font-size: clamp(1rem, 2vw, 1.2rem);
    font-weight: 600;
    margin-bottom: 6px;
    color: var(--dark);
  }

  .event-description {
    color: var(--text-dark);
    font-size: clamp(0.8rem, 2vw, 0.95rem);
    margin-bottom: 10px;
    line-height: 1.5;
  }

  .event-time {
    display: flex;
    align-items: center;
    gap: 6px;
    color: var(--primary-dark);
    font-size: clamp(0.75rem, 2vw, 0.9rem);
  }

  /* Special event styling */
  .special-day {
    background-color: rgba(255, 209, 102, 0.1);
    position: relative;
  }

  .special-day::after {
    content: '★';
    position: absolute;
    top: 2px;
    right: 2px;
    color: var(--gold-light);
    font-size: 12px;
  }

  .special-event {
    border-left-color: var(--gold-light);
  }

  /* Loading state */
  .calendar-loading .days-container {
    min-height: 300px;
    position: relative;
  }

  .calendar-loading .days-container::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 30px;
    height: 30px;
    border: 3px solid rgba(108, 74, 182, 0.2);
    border-top-color: var(--primary);
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
  }

  @keyframes spin {
    to { transform: translate(-50%, -50%) rotate(360deg); }
  }

  /* Mobile optimizations */
  @media (max-width: 768px) {
    .calendar-section {
      padding: 40px 0;
    }

    .calendar-header {
      padding: 12px 15px;
    }

    .nav-btn {
      width: 32px;
      height: 32px;
    }

    .days-container {
      min-height: 0;
    }

    .calendar-day {
      padding: 4px 2px;
    }

    .today .day-number {
      width: 20px;
      height: 20px;
    }

    .event-dot {
      width: 5px;
      height: 5px;
      top: 4px;
      right: 4px;
    }

    .events-list {
      padding: 20px 15px;
    }

    .events-container {
      grid-template-columns: 1fr;
    }
  }
</style>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Performance optimizations
    const requestAnimationFrame = window.requestAnimationFrame || 
                                window.mozRequestAnimationFrame || 
                                window.webkitRequestAnimationFrame || 
                                window.msRequestAnimationFrame;

    // DOM elements cache
    const elements = {
      monthYearDisplay: document.querySelector('.month-year-display'),
      daysContainer: document.querySelector('.days-container'),
      prevMonthBtn: document.querySelector('.prev-month'),
      nextMonthBtn: document.querySelector('.next-month'),
      eventsContainer: document.querySelector('.events-container'),
      calendarContainer: document.querySelector('.calendar-container')
    };

    // Calendar data with events (optimized structure)
    const calendarData = {
      "2025": {
        "5": { // June (months are 0-indexed in JS but we'll display as 1-indexed)
          
          "15": {
            "title": "Sunday Feast",
            "desc": "Weekly spiritual gathering with kirtan, lecture and prasadam",
            "time": "8:00 AM - 11:30 AM",
            "special": false
          },
          "22": {
            "title": "Sunday Feast",
            "desc": "Weekly spiritual gathering with kirtan, lecture and prasadam",
            "time": "8:00 AM - 11:30 AM",
            "special": false
          },
          "29": {
            "title": "Sunday Feast",
            "desc": "Weekly spiritual gathering with kirtan, lecture and prasadam",
            "time": "8:00 AM - 11:30 AM",
            "special": false
          },
          
          "27": {
            "title": "Rath Yatra",
            "desc": "Rath Yatra festival of Lord Jagannath",
            "time": "Full day celebration",
            "special": true
          },
          "21": {
            "title": "Ekadasi Fasting",
            "desc": "Monthly fasting day for spiritual advancement",
            "time": "Sunrise to next day sunrise",
            "special": true
          }
        },
        "6": { // July
           "6": {
            "title": "Sunday Feast",
            "desc": "Weekly spiritual gathering with kirtan, lecture and prasadam",
            "time": "8:00 AM - 11:30 AM",
            "special": false
          },
          "4": {
            "title": "Guru Purnima",
            "desc": "Appearance day of Srila Vyasadeva",
            "time": "Full day celebration",
            "special": true
          }
        }
      }
    };

    // Current date state
    const state = {
      currentDate: new Date(),
      currentMonth: new Date().getMonth(),
      currentYear: new Date().getFullYear(),
      touchStartX: 0,
      isAnimating: false
    };

    // Initialize calendar with debounced render
    initCalendar();

    // Event listeners with debouncing
    elements.prevMonthBtn.addEventListener('click', throttle(showPreviousMonth, 300));
    elements.nextMonthBtn.addEventListener('click', throttle(showNextMonth, 300));

    // Touch events for swipe
    elements.daysContainer.addEventListener('touchstart', handleTouchStart, { passive: true });
    elements.daysContainer.addEventListener('touchend', handleTouchEnd, { passive: true });

    // Initialize calendar
    function initCalendar() {
      renderCalendar(state.currentMonth, state.currentYear);
      elements.calendarContainer.classList.remove('calendar-loading');
    }

    // Throttle function for performance
    function throttle(fn, wait) {
      let lastCall = 0;
      return function() {
        const now = Date.now();
        if (now - lastCall >= wait) {
          lastCall = now;
          fn.apply(this, arguments);
        }
      };
    }

    // Month navigation
    function showPreviousMonth() {
      if (state.isAnimating) return;
      
      state.currentMonth--;
      if (state.currentMonth < 0) {
        state.currentMonth = 11;
        state.currentYear--;
      }
      animateTransition('left');
    }

    function showNextMonth() {
      if (state.isAnimating) return;
      
      state.currentMonth++;
      if (state.currentMonth > 11) {
        state.currentMonth = 0;
        state.currentYear++;
      }
      animateTransition('right');
    }

    // Animation for month transition
    function animateTransition(direction) {
      state.isAnimating = true;
      elements.calendarContainer.classList.add('calendar-loading');
      
      requestAnimationFrame(() => {
        elements.daysContainer.style.opacity = '0';
        elements.daysContainer.style.transform = direction === 'left' ? 'translateX(20px)' : 'translateX(-20px)';
        
        requestAnimationFrame(() => {
          renderCalendar(state.currentMonth, state.currentYear);
          elements.daysContainer.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
          elements.daysContainer.style.opacity = '1';
          elements.daysContainer.style.transform = 'translateX(0)';
          
          setTimeout(() => {
            elements.daysContainer.style.transition = '';
            elements.calendarContainer.classList.remove('calendar-loading');
            state.isAnimating = false;
          }, 300);
        });
      });
    }

    // Touch handlers
    function handleTouchStart(e) {
      state.touchStartX = e.changedTouches[0].screenX;
    }

    function handleTouchEnd(e) {
      const touchEndX = e.changedTouches[0].screenX;
      const diffX = touchEndX - state.touchStartX;
      
      if (Math.abs(diffX) > 50) { // Minimum swipe distance
        if (diffX > 0) {
          showPreviousMonth();
        } else {
          showNextMonth();
        }
      }
    }

    // Render calendar function (optimized)
    function renderCalendar(month, year) {
      const monthNames = ["January", "February", "March", "April", "May", "June", 
                         "July", "August", "September", "October", "November", "December"];
      
      // Update month/year display
      elements.monthYearDisplay.textContent = `${monthNames[month]} ${year}`;
      
      // Clear previous days efficiently
      elements.daysContainer.innerHTML = '';
      
      // Get calendar data
      const firstDay = new Date(year, month, 1).getDay();
      const daysInMonth = new Date(year, month + 1, 0).getDate();
      const today = new Date();
      
      // Create document fragment for batch DOM updates
      const fragment = document.createDocumentFragment();
      
      // Add empty cells for days before first day of month
      for (let i = 0; i < firstDay; i++) {
        fragment.appendChild(createDayElement(null));
      }
      
      // Add days of month
      for (let day = 1; day <= daysInMonth; day++) {
        const dayElement = createDayElement(day);
        
        // Highlight today
        if (day === today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
          dayElement.classList.add('today');
        }
        
        // Check for events
        const eventData = calendarData[year]?.[month]?.[day];
        if (eventData) {
          dayElement.classList.add('special-day');
          dayElement.appendChild(createEventDot());
          
          // Add click handler
          dayElement.addEventListener('click', () => {
            showEventsForDay(monthNames[month], day, eventData);
          }, { passive: true });
        }
        
        fragment.appendChild(dayElement);
      }
      
      // Append all days at once
      elements.daysContainer.appendChild(fragment);
      
      // Show events for current month
      showEventsForMonth(month, year);
    }
    
    // Create day element
    function createDayElement(dayNumber) {
      const dayElement = document.createElement('div');
      dayElement.className = 'calendar-day';
      
      if (dayNumber !== null) {
        const numberElement = document.createElement('div');
        numberElement.className = 'day-number';
        numberElement.textContent = dayNumber;
        dayElement.appendChild(numberElement);
      }
      
      return dayElement;
    }
    
    // Create event dot
    function createEventDot() {
      const dot = document.createElement('div');
      dot.className = 'event-dot';
      return dot;
    }
    
    // Show events for selected month
    function showEventsForMonth(month, year) {
      const monthEvents = calendarData[year]?.[month];
      if (!monthEvents) {
        elements.eventsContainer.innerHTML = '<p>No events scheduled for this month.</p>';
        return;
      }
      
      const fragment = document.createDocumentFragment();
      const monthNames = ["January", "February", "March", "April", "May", "June", 
                         "July", "August", "September", "October", "November", "December"];
      
      Object.keys(monthEvents).sort((a, b) => a - b).forEach(day => {
        const event = monthEvents[day];
        fragment.appendChild(createEventCard(event, `${monthNames[month]} ${day}`));
      });
      
      elements.eventsContainer.innerHTML = '';
      elements.eventsContainer.appendChild(fragment);
    }
    
    // Show events for specific day
    function showEventsForDay(monthName, day, eventData) {
      elements.eventsContainer.innerHTML = '';
      elements.eventsContainer.appendChild(createEventCard(eventData, `${monthName} ${day}`));
    }
    
    // Create event card
    function createEventCard(event, date) {
      const eventCard = document.createElement('div');
      eventCard.className = 'event-card';
      if (event.special) {
        eventCard.classList.add('special-event');
      }
      
      eventCard.innerHTML = `
        <div class="event-date">
          <i class="far fa-calendar-alt"></i>
          ${date}
        </div>
        <h4 class="event-title">${event.title}</h4>
        <p class="event-description">${event.desc}</p>
        <div class="event-time">
          <i class="far fa-clock"></i>
          ${event.time}
        </div>
      `;
      
      return eventCard;
    }
  });
</script>


<!-- Ekadashi Page Content -->
<section id="ekadashi-calendar" class="ekadashi-section">
    <div class="container">
        <div class="section-header animate-on-scroll">
            <h1>Ekadashi Days 2025</h1>
            <p>Observe these sacred fasting days for spiritual purification</p>
        </div>
        
        <div class="ekadashi-grid">
            <!-- January -->
            <div class="month-section animate-on-scroll">
                <h2>January 2025</h2>
                <div class="ekadashi-card" data-date="January 6, 2025" data-details="Putrada Ekadashi - Fasting on this day is believed to bless devotees with virtuous children.">
                    <div class="date">10 Jan</div>
                    <div class="name">Putrada Ekadashi</div>
                    <div class="icon"><i class="fas fa-feather-alt"></i></div>
                </div>
                <div class="ekadashi-card" data-date="January 21, 2025" data-details="Shattila Ekadashi - This Ekadashi is observed for prosperity and removal of poverty.">
                    <div class="date">25 Jan</div>
                    <div class="name">Shattila Ekadashi</div>
                    <div class="icon"><i class="fas fa-heart"></i></div>
                </div>
            </div>
            
            <!-- February -->
            <div class="month-section animate-on-scroll">
                <h2>February 2025</h2>
                <div class="ekadashi-card" data-date="February 5, 2025" data-details="Jaya Ekadashi - Observance removes sins and leads to liberation.">
                    <div class="date">8 Feb</div>
                    <div class="name">Jaya Ekadashi</div>
                    <div class="icon"><i class="fas fa-spa"></i></div>
                </div>
                <div class="ekadashi-card" data-date="February 20, 2025" data-details="Vijaya Ekadashi - This Ekadashi brings victory over all obstacles.">
                    <div class="date">24 Feb</div>
                    <div class="name">Vijaya Ekadashi</div>
                    <div class="icon"><i class="fas fa-trophy"></i></div>
                </div>
            </div>
            
            <!-- March -->
            <div class="month-section animate-on-scroll">
                <h2>March 2025</h2>
                <div class="ekadashi-card" data-date="March 6, 2025" data-details="Amalaki Ekadashi - Dedicated to Lord Vishnu's Amalaki form, removes sins of many births.">
                    <div class="date">10 Mar</div>
                    <div class="name">Amalaki Ekadashi</div>
                    <div class="icon"><i class="fas fa-leaf"></i></div>
                </div>
                <div class="ekadashi-card" data-date="March 21, 2025" data-details="Papamochani Ekadashi - Frees from sinful reactions and grants liberation.">
                    <div class="date">25 Mar</div>
                    <div class="name">Papamochani Ekadashi</div>
                    <div class="icon"><i class="fas fa-dove"></i></div>
                </div>
            </div>
            
            <!-- April -->
            <div class="month-section animate-on-scroll">
                <h2>April 2025</h2>
                <div class="ekadashi-card" data-date="April 5, 2025" data-details="Kamada Ekadashi - Fulfills all desires and removes effects of bad karma.">
                    <div class="date">8 Apr</div>
                    <div class="name">Kamada Ekadashi</div>
                    <div class="icon"><i class="fas fa-heart"></i></div>
                </div>
                <div class="ekadashi-card" data-date="April 20, 2025" data-details="Varuthini Ekadashi - Bestows good fortune and removes obstacles in spiritual progress.">
                    <div class="date">24 Apr</div>
                    <div class="name">Varuthini Ekadashi</div>
                    <div class="icon"><i class="fas fa-shield-alt"></i></div>
                </div>
            </div>
            
            <!-- May -->
            <div class="month-section animate-on-scroll">
                <h2>May 2025</h2>
                <div class="ekadashi-card" data-date="May 4, 2025" data-details="Mohini Ekadashi - Destroys sins and leads to Vishnu's abode.">
                    <div class="date">8 May</div>
                    <div class="name">Mohini Ekadashi</div>
                    <div class="icon"><i class="fas fa-spa"></i></div>
                </div>
                <div class="ekadashi-card" data-date="May 19, 2025" data-details="Apara Ekadashi - Washes away sins and grants fame and prosperity.">
                    <div class="date">23 May</div>
                    <div class="name">Apara Ekadashi</div>
                    <div class="icon"><i class="fas fa-sun"></i></div>
                </div>
            </div>
            
            <!-- June -->
            <div class="month-section animate-on-scroll">
                <h2>June 2025</h2>
                <div class="ekadashi-card" data-date="June 3, 2025" data-details="Pandava Nirjala Ekadashi - The most austere Ekadashi where even water is not consumed.">
                    <div class="date">6 Jun</div>
                    <div class="name">Nirjala Ekadashi</div>
                    <div class="icon"><i class="fas fas fa-feather-alt"></i></div>
                </div>
                <div id="yogini-ekadashi" class="ekadashi-card" data-date="June 18, 2025" data-details="Yogini Ekadashi - Nullifies sins and grants health and longevity.">
                    <div class="date">21 Jun</div>
                    <div class="name">Yogini Ekadashi</div>
                    <div class="icon"><i class="fas fa-spa"></i></div>
                </div>
            </div>
            
            <!-- July -->
            <div class="month-section animate-on-scroll">
                <h2>July 2025</h2>
                <div class="ekadashi-card" data-date="July 2, 2025" data-details="Devshayani Ekadashi - Marks beginning of Chaturmas, Vishnu's cosmic sleep.">
                    <div class="date">6 Jul</div>
                    <div class="name">Devshayani Ekadashi</div>
                    <div class="icon"><i class="fas fa-heart"></i></div>
                </div>
                <div class="ekadashi-card" data-date="July 17, 2025" data-details="Kamika Ekadashi - Observance grants the merit of bathing in Ganges and all pilgrimages.">
                    <div class="date">21 Jul</div>
                    <div class="name">Kamika Ekadashi</div>
                    <div class="icon"><i class="fas fa-om"></i></div>
                </div>
            </div>
            
            <!-- August -->
            <div class="month-section animate-on-scroll">
                <h2>August 2025</h2>
                <div class="ekadashi-card" data-date="August 1, 2025" data-details="Shravana Putrada Ekadashi - Bestows children to childless and fulfills desires.">
                    <div class="date">5 Aug</div>
                    <div class="name">Shravana Putrada Ekadashi</div>
                    <div class="icon"><i class="fas fa-spa"></i></div>
                </div>
                <div class="ekadashi-card" data-date="August 16, 2025" data-details="Aja Ekadashi - Removes sins of killing a Brahmin and grants liberation.">
                    <div class="date">19 Aug</div>
                    <div class="name">Aja Ekadashi</div>
                    <div class="icon"><i class="fas fa-feather-alt"></i></div>
                </div>
                
            </div>
            
            <!-- September -->
            <div class="month-section animate-on-scroll">
                <h2>September 2025</h2>
                <div class="ekadashi-card" data-date="August 31, 2025" data-details="Parsva Ekadashi -  Observing this Ekādaśī pleases Lord Vishnu, particularly in his Vāmana (dwarf Brahmin) form.">
                    <div class="date">3 Sep</div>
                    <div class="name">Parsva Ekadashi</div>
                    <div class="icon"><i class="fas fa-hands-praying"></i></div>
                </div>
                <div class="ekadashi-card" data-date="September 15, 2025" data-details="Indira Ekadashi - Liberates ancestors from hellish planets and grants salvation.">
                    <div class="date">17 Sep</div>
                    <div class="name">Indira Ekadashi</div>
                    <div class="icon"><i class="fas fa-cloud"></i></div>
                </div>
                
            </div>
            
            <!-- October -->
            <div class="month-section animate-on-scroll">
                <h2>October 2025</h2>
                <div class="ekadashi-card" data-date="October 14, 2025" data-details="Papankusha Ekadashi - Grants freedom from sins and leads to Lord Vishnu's abode.">
                    <div class="date">3 Oct</div>
                    <div class="name">Papankusha Ekadashi</div>
                    <div class="icon"><i class="fas fa-heart"></i></div>
                </div>
                <div class="ekadashi-card" data-date="October 29, 2025" data-details="Rama Ekadashi - Removes sins and grants wealth, prosperity and liberation.">
                    <div class="date">17 Oct</div>
                    <div class="name">Rama Ekadashi</div>
                    <div class="icon"><i class="fas fa-bell"></i></div>
                </div>
            </div>
            
            <!-- November -->
            <div class="month-section animate-on-scroll">
                <h2>November 2025</h2>
                <div class="ekadashi-card" data-date="November 13, 2025" data-details="Devutthana Ekadashi - Marks the awakening of Lord Vishnu from his cosmic sleep. It cleanses sins and the start off auspicious events like marriages.">
                    <div class="date">1 Nov</div>
                    <div class="name">Devutthana Ekadashi</div>
                    <div class="icon"><i class="fas fa-crown"></i></div>
                </div>
                <div class="ekadashi-card" data-date="December 13, 2025" data-details="Utpanna Ekadashi - Grants freedom from sins and fulfills all desires.">
                    <div class="date">15 Nov</div>
                    <div class="name">Utpanna Ekadashi</div>
                    <div class="icon"><i class="fas fa-seedling"></i></div>
                </div>
                
            </div>
            
            <!-- December -->
            <div class="month-section animate-on-scroll">
                <h2>December 2025</h2>
                <div class="ekadashi-card" data-date="September 30, 2025" data-details="Mokshada Ekadashi - Grants liberation to ancestors and fulfills all desires of devotees.">
                    <div class="date">1 Dec</div>
                    <div class="name">Mokshada Ekadashi</div>
                    <div class="icon"><i class="fas fa-spa"></i></div>
                </div>
                <div class="ekadashi-card" data-date="December 13, 2025" data-details="Saphala Ekadashhi - The name 'Saphala' itself means 'fruitful'. It is observed to please Lord Vishnu and it grant success in all endeavors and spiritual fulfillment.">
                    <div class="date">15 Dec</div>
                    <div class="name">Saphala Ekadashi</div>
                    <div class="icon"><i class="fas fa-seedling"></i></div>
                </div>
                <div class="ekadashi-card" data-date="December 28, 2025" data-details="Pausha Putrada Ekadashi - One who observe this fast with full devotion and worship the Lord are blessed with progeny, and their children enjoy a long and healthy life">
                    <div class="date">30 Dec</div>
                    <div class="name">Pausha Putrada Ekadashi</div>
                    <div class="icon"><i class="fas fa-praying-hands"></i></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Ekadashi Details Modal -->
<div class="ekadashi-modal">
    <div class="ekadashi-modal-content">
        <button class="close-modal"><i class="fas fa-times"></i></button>
        <div class="modal-header">
            <h2 class="modal-title">Ekadashi Title</h2>
            <p class="modal-date">Date: January 1, 2025</p>
        </div>
        <div class="modal-body">
            <p class="modal-details">Details about the Ekadashi will appear here...</p>
            <div class="modal-benefits">
                <h3>Benefits of Observing:</h3>
                <ul class="benefits-list">
                    <li><i class="fas fa-check-circle"></i> Spiritual purification</li>
                    <li><i class="fas fa-check-circle"></i> Removal of sins</li>
                    <li><i class="fas fa-check-circle"></i> Blessings of Lord Vishnu</li>
                    <li><i class="fas fa-check-circle"></i> Fulfillment of desires</li>
                </ul>
            </div>
            <div class="modal-actions">
                <button class="reminder-btn"><i class="fas fa-bell"></i> Set Reminder</button>
                <button class="share-btn"><i class="fas fa-share-alt"></i> Share</button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Ekadashi Section Styles */
    .ekadashi-section {
        padding: 80px 0;
        background-color: var(--light);
        position: relative;
    }
    
    .section-header {
        text-align: center;
        margin-bottom: 50px;
    }
    
    .section-header h1 {
        font-family: 'Playfair Display', serif;
        font-size: 2.8rem;
        color: var(--primary-dark);
        margin-bottom: 15px;
        position: relative;
        display: inline-block;
    }
    
    .section-header h1::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 3px;
        background: var(--secondary);
    }
    
    .section-header p {
        font-size: 1.1rem;
        color: var(--text-dark);
        max-width: 700px;
        margin: 0 auto;
    }
    
    /* Ekadashi Grid Layout */
    .ekadashi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 30px;
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .month-section {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: var(--shadow-md);
        transition: var(--transition);
    }
    
    .month-section:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }
    
    .month-section h2 {
        font-family: 'Playfair Display', serif;
        color: var(--primary);
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 1px solid rgba(108, 74, 182, 0.1);
    }
    
    /* Ekadashi Card Styles */
    .ekadashi-card {
        display: flex;
        align-items: center;
        padding: 15px;
        margin-bottom: 15px;
        background: rgba(248, 246, 244, 0.7);
        border-radius: 8px;
        cursor: pointer;
        transition: var(--transition);
        position: relative;
        overflow: hidden;
    }
    
    .ekadashi-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: var(--primary-light);
        transition: var(--transition);
    }
    
    .ekadashi-card:hover {
        background: rgba(108, 74, 182, 0.05);
        transform: translateX(5px);
    }
    
    .ekadashi-card:hover::before {
        width: 6px;
        background: var(--primary);
    }
    
    .ekadashi-card .date {
        font-weight: 600;
        color: var(--primary-dark);
        min-width: 60px;
        font-size: 1rem;
    }
    
    .ekadashi-card .name {
        flex-grow: 1;
        font-weight: 500;
        color: var(--dark);
        font-size: 1rem;
    }
    
    .ekadashi-card .icon {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(108, 74, 182, 0.1);
        border-radius: 50%;
        color: var(--primary);
        font-size: 1rem;
        transition: var(--transition);
    }
    
    .ekadashi-card:hover .icon {
        background: var(--primary);
        color: white;
        transform: rotate(15deg) scale(1.1);
    }
    
    /* Ekadashi Modal Styles */
    .ekadashi-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(45, 39, 39, 0.9);
        backdrop-filter: blur(8px);
        z-index: 2000;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        visibility: hidden;
        transition: var(--transition);
        padding: 20px;
    }
    
    .ekadashi-modal.active {
        opacity: 1;
        visibility: visible;
    }
    
    .ekadashi-modal-content {
        background: white;
        border-radius: 12px;
        width: 100%;
        max-width: 600px;
        max-height: 90vh;
        overflow-y: auto;
        position: relative;
        box-shadow: var(--shadow-xl);
        transform: translateY(20px);
        transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
    }
    
    .ekadashi-modal.active .ekadashi-modal-content {
        transform: translateY(0);
    }
    
    .close-modal {
        position: absolute;
        top: 15px;
        right: 15px;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(0, 0, 0, 0.1);
        border: none;
        color: white;
        font-size: 1.2rem;
        cursor: pointer;
        z-index: 10;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .close-modal:hover {
        background: var(--primary);
        color: white;
        transform: rotate(90deg);
    }
    
    .modal-header {
        padding: 30px 30px 20px;
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        color: white;
        border-radius: 12px 12px 0 0;
        position: relative;
        overflow: hidden;
    }
    
    .modal-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('https://i.imgur.com/mandala-pattern-light.png') center/cover no-repeat;
        opacity: 0.1;
    }
    
    .modal-title {
        font-family: 'Playfair Display', serif;
        font-size: 2rem;
        margin-bottom: 5px;
        position: relative;
    }
    
    .modal-date {
        font-size: 1rem;
        opacity: 0.9;
    }
    
    .modal-body {
        padding: 25px 30px;
    }
    
    .modal-details {
        font-size: 1.1rem;
        line-height: 1.8;
        color: var(--text-dark);
        margin-bottom: 25px;
    }
    
    .modal-benefits h3 {
        font-family: 'Playfair Display', serif;
        color: var(--primary);
        margin-bottom: 15px;
        font-size: 1.3rem;
    }
    
    .benefits-list {
        list-style: none;
        margin-bottom: 30px;
    }
    
    .benefits-list li {
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 1rem;
    }
    
    .benefits-list i {
        color: var(--primary);
        font-size: 1.1rem;
    }
    
    .modal-actions {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }
    
    .reminder-btn, .share-btn {
        flex: 1;
        min-width: 150px;
        padding: 12px 20px;
        border-radius: 8px;
        border: none;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        font-size: 0.95rem;
        text-decoration: none;
    }
    
    .reminder-btn {
        background: var(--secondary);
        color: var(--dark);
    }
    
    .reminder-btn:hover {
        background: var(--gold-light);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }
    
    .share-btn {
        background: rgba(108, 74, 182, 0.1);
        color: var(--primary);
    }
    
    .share-btn:hover {
        background: rgba(108, 74, 182, 0.2);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }
    
    /* Responsive Styles */
    @media (max-width: 768px) {
        .section-header h1 {
            font-size: 2.2rem;
        }
        
        .ekadashi-grid {
            grid-template-columns: 1fr;
        }
        
        .modal-header {
            padding: 25px 20px 15px;
        }
        
        .modal-title {
            font-size: 1.8rem;
        }
        
        .modal-body {
            padding: 20px;
        }
        
        .modal-actions {
            flex-direction: column;
            gap: 10px;
        }
        
        .reminder-btn, .share-btn {
            width: 100%;
        }
    }
    
    @media (max-width: 480px) {
        .section-header h1 {
            font-size: 1.8rem;
        }
        
        .ekadashi-card .name {
            font-size: 0.95rem;
        }
        
        .ekadashi-card .date {
            min-width: 50px;
            font-size: 0.9rem;
        }
    }
</style>

<script>
    // Ekadashi Modal Functionality
    document.addEventListener('DOMContentLoaded', function() {
        const ekadashiCards = document.querySelectorAll('.ekadashi-card');
        const ekadashiModal = document.querySelector('.ekadashi-modal');
        const modalTitle = document.querySelector('.modal-title');
        const modalDate = document.querySelector('.modal-date');
        const modalDetails = document.querySelector('.modal-details');
        const closeModalBtn = document.querySelector('.close-modal');
        
        // Open modal when ekadashi card is clicked
        ekadashiCards.forEach(card => {
            card.addEventListener('click', function() {
                const date = this.getAttribute('data-date');
                const name = this.querySelector('.name').textContent;
                const details = this.getAttribute('data-details');
                
                modalTitle.textContent = name;
                modalDate.textContent = `Date: ${date}`;
                modalDetails.textContent = details;
                
                ekadashiModal.classList.add('active');
                document.body.classList.add('modal-open');
            });
        });
        
        // Close modal
        closeModalBtn.addEventListener('click', function() {
            ekadashiModal.classList.remove('active');
            document.body.classList.remove('modal-open');
        });
        
        // Close modal when clicking outside content
        ekadashiModal.addEventListener('click', function(e) {
            if (e.target === ekadashiModal) {
                ekadashiModal.classList.remove('active');
                document.body.classList.remove('modal-open');
            }
        });
        
        // Set reminder button functionality
        const reminderBtn = document.querySelector('.reminder-btn');
        reminderBtn.addEventListener('click', function() {
            const title = modalTitle.textContent;
            const date = modalDate.textContent.replace('Date: ', '');
            
            // In a real implementation, this would use the Web Notifications API
            // or integrate with a calendar service
            alert(`Reminder set for ${title} on ${date}`);
        });
        
        // Share button functionality
        const shareBtn = document.querySelector('.share-btn');
        shareBtn.addEventListener('click', function() {
            const title = modalTitle.textContent;
            const date = modalDate.textContent.replace('Date: ', '');
            const text = `Observe ${title} on ${date} - ${modalDetails.textContent.substring(0, 50)}...`;
            
            if (navigator.share) {
                navigator.share({
                    title: title,
                    text: text,
                    url: window.location.href
                }).catch(err => {
                    console.log('Error sharing:', err);
                });
            } else {
                // Fallback for browsers that don't support Web Share API
                alert('Share this Ekadashi with others:\n\n' + text);
            }
        });
        
        // Animation on scroll for month sections
        const animateOnScroll = function() {
            const elements = document.querySelectorAll('.animate-on-scroll');
            const windowHeight = window.innerHeight;
            
            elements.forEach(element => {
                const elementPosition = element.getBoundingClientRect().top;
                const elementVisible = 100;
                
                if (elementPosition < windowHeight - elementVisible) {
                    element.classList.add('animated');
                }
            });
        };
        
        window.addEventListener('scroll', animateOnScroll);
        animateOnScroll(); // Initialize
    });
</script>

  
    <section id="weekly-programs" class="weekly-programs">
      <div class="container">
        <div class="section-header animate-on-scroll">
          <h2>Weekly Programs</h2>
          <p>Regular spiritual activities at ISKCON Burla</p>
        </div>
        
        <div class="programs-grid animate-on-scroll">
          <div class="program-card ">
            <div class="program-icon">
              <i class="fas fa-sun"></i>
            </div>
            <h3>Morning Aarti</h3>
            <p class="program-time">4:30 AM - 7:30 AM (Daily)</p>
            <p>Daily Mangala Arati ceremony to wake the Deities with traditional offerings and prayers.</p>
            <a href="#" class="btn-small more-details-btn" data-event="morning-aarti">More Details</a>
          </div>
          
          <div class="program-card">
            <div class="program-icon">
              <i class="fas fa-utensils"></i>
            </div>
            <h3>Sunday Love Feast</h3>
            <p class="program-time">8:00 AM - 12:00 PM (Sunday)</p>
            <p>Weekly spiritual discourse followed by prasadam feast with 15+ delicious preparations.</p>
            <a href="#" class="btn-small more-details-btn" data-event="sunday-feast">More Details</a>
          </div>
          
          <div class="program-card">
            <div class="program-icon">
              <i class="fas fa-book"></i>
            </div>
            <h3>Bhagavatam Class</h3>
            <p class="program-time">8:00 AM (Sun) & 8:00 PM (Thur, online)</p>
            <p>Bhavatam classes with practical applications for modern life.</p>
            <a href="#" class="btn-small more-details-btn" data-event="gita-class">More Details</a>
          </div>
          
       <!--   <div class="program-card">
            <div class="program-icon">
              <i class="fas fa-utensils"></i>
            </div>
            <h3>Sunday Love feast</h3>
            <p class="program-time">8:00 AM - 12:00 PM (every Sundays)</p>
            <p>Weekly Sunday love feast along with Bhagavatam calss and ecstatic kirtan and chanting of the Holy Names with instruments and dancing.</p>
            <a href="#" class="btn-small more-details-btn" data-event="kirtan-mela">More Details</a>
          </div> -->
          
        <!--  <div class="program-card">
            <div class="program-icon">
              <i class="fas fa-hands-praying"></i>
            </div>
            <h3>Guru Puja</h3>
            <p class="program-time">7:30 AM - 8:30 AM (Thursday)</p>
            <p>Special worship ceremony for spiritual masters with arati, prayers, and offerings.</p>
            <a href="#" class="btn-small more-details-btn" data-event="guru-puja">More Details</a>
          </div> -->
          
          <div class="program-card">
            <div class="program-icon">
              <i class="fas fa-cow"></i>
            </div>
            <h3>Gau Seva for general public</h3>
            <p class="program-time">10:30 AM -11:30 AM (Sundays)</p>
            <p>Service to cows including feeding, cleaning, and learning about cow protection.</p>
            <a href="#" class="btn-small more-details-btn" data-event="gau-seva">More Details</a>
          </div>
        </div>
      </div>
    </section>
  
    <!-- Event Details Modal -->
    <div class="event-modal" id="event-modal">
      <div class="modal-close-btn"><i class="fas fa-times"></i></div>
      <div class="modal-content">
        <div class="modal-image">
          <img id="modal-event-image" src="" alt="Event Image">
        </div>
        <div class="modal-details">
          <h2 id="modal-event-title"></h2>
          <div class="modal-meta">
            <p><i class="fas fa-calendar-day"></i> <span id="modal-event-date"></span></p>
            <p><i class="fas fa-clock"></i> <span id="modal-event-time"></span></p>
            <p><i class="fas fa-map-marker-alt"></i> <span id="modal-event-location"></span></p>
          </div>
          <div class="modal-description" id="modal-event-description"></div>
          <div class="modal-schedule">
            <h4>Program Schedule</h4>
            <ul id="modal-event-schedule"></ul>
          </div>
          <div class="modal-actions">
            <a href="#" class="btn-primary1">Register Now</a>
            <a href="#" class="btn-outline1"><i></i>Set Reminder</a>
          </div>
        </div>
      </div>
    </div>
  </main>
  
  <style>
    /* Events Hero Section */
    /* Full screen modal buttons */
    .btn-primary1 {
      display: inline-block;
      padding: 12px 25px;
      background: var(--primary);
      color: white;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 600;
      transition: var(--transition);
      border: 2px solid rgb(135, 166, 250);
      box-shadow: var(--light);
      justify-content: center;
      
    }
  
    .btn-primary1:hover {
      background: var(--primary-dark);
      transform: translateY(-2px);
      box-shadow: var(--shadow-md);
      color: white;
    }
  
    .btn-outline1 {
      display: inline-block;
      padding: 12px 25px;
      background: transparent;
      color: var(--primary);
      border-radius: 8px;
      text-decoration: none;
      font-weight: 600;
      transition: var(--transition);
      border: 2px solid rgb(135, 166, 250);
      color: black;
      align-items: center;
    }
  
    .btn-outline1:hover {
      background: rgba(32, 3, 94, 0.1);
      transform: translateY(-2px);
    }


    .events-hero {
      background: linear-gradient(rgba(38, 1, 119, 0.8), rgba(108, 74, 182, 0.8)), 
                  url('https://i.imgur.com/temple-bg.jpg') center/cover no-repeat;
      color: white;
      padding: 150px 0 100px;
      text-align: center;
      position: relative;
    }
    
  
    .hero-content {
      max-width: 800px;
      margin: 0 auto;
    }
  
    .events-hero h1 {
      font-family: 'Playfair Display', serif;
      font-size: 3.5rem;
      margin-bottom: 20px;
      text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }
  
    .events-hero p {
      font-size: 1.2rem;
      margin-bottom: 30px;
      opacity: 0.9;
    }
  
    .hero-buttons {
      display: flex;
      gap: 15px;
      justify-content: center;
    }
  
    /* Featured Events Section */
    .featured-events {
      padding: 100px 0;
      background-color: var(--light);
    }
  
    .section-header {
      text-align: center;
      margin-bottom: 60px;
    }
  
    .section-header h2 {
      font-family: 'Playfair Display', serif;
      font-size: 2.5rem;
      color: var(--primary-dark);
      margin-bottom: 15px;
    }
  
    .section-header p {
      color: var(--text-dark);
      font-size: 1.1rem;
      max-width: 700px;
      margin: 0 auto;
    }
  
    .event-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 24px;
  justify-items: center;
}

  
    .event-card {
      background: white;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: var(--shadow-md);
      transition: var(--transition);
    }
  
    .event-card:hover {
      transform: translateY(-5px);
      box-shadow: var(--shadow-lg);
    }
  
    .event-image {
      position: relative;
      height: 220px;
      overflow: hidden;
    }
  
    .event-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.5s ease;
    }
  
    .event-card:hover .event-image img {
      transform: scale(1.05);
    }
  
    .event-date {
      position: absolute;
      top: 20px;
      right: 20px;
      background: white;
      padding: 10px 15px;
      border-radius: 8px;
      text-align: center;
      box-shadow: var(--shadow-sm);
    }
  
    .date-day {
      font-size: 1.5rem;
      font-weight: 700;
      color: var(--primary);
      display: block;
      line-height: 1;
    }
  
    .date-month {
      font-size: 0.9rem;
      font-weight: 600;
      color: var(--dark);
      text-transform: uppercase;
    }
  
    .event-details {
      padding: 25px;
    }
  
    .event-details h3 {
      font-size: 1.5rem;
      margin-bottom: 15px;
      color: var(--primary-dark);
    }
  
    .event-meta {
      display: flex;
      flex-wrap: wrap;
      gap: 15px;
      margin-bottom: 15px;
      font-size: 0.9rem;
      color: var(--text-dark);
    }
  
    .event-meta i {
      margin-right: 5px;
      color: var(--primary);
    }
  
    .event-details p {
      color: var(--text-dark);
      margin-bottom: 20px;
    }
  
    .event-actions {
      display: flex;
      gap: 10px;
    }
  
    /* Weekly Programs Section */
    .weekly-programs {
      padding: 80px 0;
      background-color: white;
    }
  
    .programs-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 30px;
    }
  
    
    .program-card {
      background: var(--light);
      padding: 30px;
      border-radius: 12px;
      text-align: center;
      box-shadow: var(--shadow-sm);
      transition: var(--transition);
      display: flex;
      flex-direction: column;
    }
  
    .program-card:hover {
      transform: translateY(-5px);
      box-shadow: var(--shadow-md);
    }
  
    .program-icon {
      width: 70px;
      height: 70px;
      margin: 0 auto 20px;
      background: rgba(108, 74, 182, 0.1);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.8rem;
      color: var(--primary);
    }
  
    .program-card h3 {
      font-size: 1.3rem;
      margin-bottom: 10px;
      color: var(--primary-dark);
    }
  
    .program-time {
      color: var(--primary);
      font-weight: 500;
      margin-bottom: 15px;
      font-size: 0.95rem;
    }
  
    .program-card p {
      color: var(--text-dark);
      font-size: 0.95rem;
      margin-bottom: 20px;
      flex-grow: 1;
    }
  
    .program-card .btn-small {
      align-self: center;
    }
  
    /* Event Modal */
    .event-modal {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: white;
      z-index: 2000;
      overflow-y: auto;
      transform: translateY(100%);
      transition: transform 0.4s ease-out;
      display: flex;
      flex-direction: column;
    }
  
    .event-modal.active {
      transform: translateY(0);
    }
  
    .modal-close-btn {
      position: fixed;
      top: 20px;
      right: 20px;
      width: 50px;
      height: 50px;
      background: rgba(0,0,0,0.2);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 1.5rem;
      cursor: pointer;
      z-index: 2001;
      transition: var(--transition);
    }
  
    .modal-close-btn:hover {
      background: rgba(0,0,0,0.3);
      transform: rotate(90deg);
    }
  
    .modal-content {
      display: flex;
      flex-direction: column;
      padding-top: 40px;
    }
  
    .modal-image {
      height: 300px;
      overflow: hidden;
    }
  
    .modal-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
  
    .modal-details {
      padding: 30px;
    }
  
    .modal-details h2 {
      font-family: 'Playfair Display', serif;
      font-size: 2rem;
      color: var(--primary-dark);
      margin-bottom: 20px;
    }
  
    .modal-meta {
      margin-bottom: 25px;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 15px;
    }
  
    .modal-meta p {
      display: flex;
      align-items: center;
      gap: 10px;
      color: var(--text-dark);
    }
  
    .modal-meta i {
      color: var(--primary);
      font-size: 1.1rem;
    }
  
    .modal-description {
      margin-bottom: 30px;
      line-height: 1.8;
      color: var(--text-dark);
    }
  
    .modal-schedule {
      margin-bottom: 30px;
    }
  
    .modal-schedule h4 {
      font-size: 1.3rem;
      margin-bottom: 15px;
      color: var(--primary-dark);
    }
  
    .modal-schedule ul {
      list-style: none;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: var(--shadow-sm);
    }
  
    .modal-schedule li {
      padding: 15px 20px;
      border-bottom: 1px solid rgba(0,0,0,0.05);
      display: flex;
      justify-content: space-between;
    }
  
    .modal-schedule li:last-child {
      border-bottom: none;
    }
  
    .modal-schedule li span:first-child {
      font-weight: 500;
      color: var(--primary-dark);
    }
  
    .modal-actions {
      display: flex;
      gap: 15px;
      margin-top: 30px;
    }
  
    /* Buttons */
    .btn-primary {
      display: inline-block;
      padding: 12px 25px;
      background: var(--primary-light);
      color: white;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 600;
      transition: var(--transition);
      border: 2px solid rgb(208, 229, 237);
      box-shadow: var(--shadow-sm);
      text-align: center;
    }
  
    .btn-primary:hover {
      background: var(--primary-dark);
      transform: translateY(-2px);
      box-shadow: var(--shadow-md);
      color: white;
    }
  
    .btn-outline {
      display: inline-block;
      padding: 12px 25px;
      background: transparent;
      color: white;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 600;
      transition: var(--transition);
      border: 2px solid rgb(147, 223, 250);
    }
  
    .btn-outline:hover {
      background: rgba(108, 74, 182, 0.1);
      transform: translateY(-2px);
    }
  
    .btn-small {
      display: inline-block;
      padding: 8px 15px;
      background: var(--primary);
      color: white;
      border-radius: 6px;
      text-decoration: none;
      font-weight: 500;
      font-size: 0.9rem;
      transition: var(--transition);
      border: 2px solid var(--primary);
      text-align: center;
    }
  
    .btn-small:hover {
      background: var(--primary-dark);
      transform: translateY(-2px);
    }
  
    .btn-small.btn-outline {
      background: transparent;
      color: var(--primary);
    }
  
    .btn-small.btn-outline:hover {
      background: rgba(108, 74, 182, 0.1);
    }
  
    /* Animation Classes */
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
    @media (min-width: 768px) {
      .modal-content {
        flex-direction: row;
        padding-top: 0;
      }
      
      .modal-image {
        height: auto;
        flex: 1;
      }
      
      .modal-details {
        flex: 1;
        padding: 50px;
      }
    }
  
    @media (max-width: 992px) {
      .events-hero h1 {
        font-size: 2.8rem;
      }
    }
  
    @media (max-width: 768px) {
      .events-hero {
        padding: 120px 0 80px;
      }
      
      .events-hero h1 {
        font-size: 2.3rem;
      }
      
      .hero-buttons {
        flex-direction: column;
        gap: 10px;
      }
      
      .section-header h2 {
        font-size: 2rem;
      }
      
      .modal-actions {
        flex-direction: column;
      }
    }
  
    @media (max-width: 480px) {
      .events-grid {
        grid-template-columns: 1fr;
      }
      
      .event-actions {
        flex-direction: column;
        gap: 10px;
      }
      
      .modal-meta {
        grid-template-columns: 1fr;
      }
    }
  </style>
  
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Event details data
      const eventDetails = {
        'Anual-Yatra': {
          title: 'ISKCON Burla Annual Yatra 3.0',
          image: 'https://iskconburla.com/images/image-will-be-uploaded.jpg',
          date: '27 Sep - 05 Oct, 2025',
          time: 'To be decided',
          location: 'Vrindavan & Rajasthan',
          description: 'Unseen Places of Vrindavan Yatra 2 and Nathdwara (Srinathji, the Original Deity of Madhavendra Puri), Rajasthan. Special Highlights:<ul><li>Journey by Train </li><li> Stay near ISKCON temple</li><li>AC Accommodation with attached bathroom</li><li>Mahaprasad</li><li>Travel all nearby places by bus</li></ul>',
          schedule: [
            ['00 Oct', 'Will be added soon'],
            ['00 Oct', 'Will be added soon'],
            ['00 Oct', 'Will be added soon'],
            ['00 Oct', 'Will be added soon'],
            ['00 Oct', 'Will be added soon'],
            ['00 Oct', 'Will be added soon'],
            ['00 Oct', 'Will be added soon']
          ]
        },

        
        'rath-yatra': {
          title: '',
          image: 'https://iskconburla.com/images/image-will-be-uploaded.jpg',
          date: 'July 7, 2025',
          time: '9:00 AM - 6:00 PM',
          location: 'City Procession Route',
          description: 'Experience the grand chariot festival of Lord Jagannath, Baladev and Subhadra. The deities will be taken in procession on beautifully decorated chariots through the main streets of Burla. Highlights include:<ul><li>Chariot pulling by devotees</li><li>Continuous kirtan and dancing</li><li>Free prasadam distribution</li><li>Cultural programs at the festival grounds</li></ul>',
          schedule: [
            ['00 Jun', 'Will be added soon'],
            ['00 Jun', 'Will be added soon'],
            ['00 Jun', 'Will be added soon'],
            ['00 Jun', 'Will be added soon'],
            ['00 Jun', 'Will be added soon'],
            ['00 Jun', 'Will be added soon'],
            ['00 Jun', 'Will be added soon']
          ]
        },
        'radha-kunda': {
          title: 'Jhulan Yatra',
          image: 'https://iskconburla.com/images/image-will-be-uploaded.jpg',
          date: 'August 5-9, 2025',
          time: '6:00 PM - 8:30 PM',
          location: 'Temple Hall',
          description: 'From tuesday to saturday, Radha-Govinda"s swing festival will be held at main temple hall. Program includes:<ul><li> --</li><li>--</li><li>--</li><li>--</li></ul>',
          schedule: [
            ['00 Aug', 'Will be added soon'],
            ['00 Aug', 'Will be added soon'],
            ['00 Aug', 'Will be added soon'],
            ['00 Aug', 'Will be added soon'],
            ['00 Aug', 'Will be added soon'],
            ['00 Aug', 'Will be added soon'],
            ['00 Aug', 'Will be added soon']
          ]
        },

        'janmashtami': {
          title: 'Krishna Janmashtami Celebration',
          image: 'https://iskconburla.com/images/image-will-be-uploaded.jpg',
          date: 'August 19, 2025',
          time: '6:00 PM - Midnight',
          location: 'Main Temple Hall',
          description: 'Join us for the most auspicious celebration of Lord Krishna\'s appearance day. The temple will be beautifully decorated with flowers and lights, and the Deities will be dressed in special midnight blue outfits. The program includes:<ul><li>Ecstatic kirtan performances</li><li>Drama depicting Krishna\'s pastimes</li><li>Krishna appearance Katha</li><li>Midnight abhishekam ceremony</li></ul>',
          schedule: [
            ['00 Aug', 'Will be added soon'],
            ['00 Aug', 'Will be added soon'],
            ['00 Aug', 'Will be added soon'],
            ['00 Aug', 'Will be added soon'],
            ['00 Aug', 'Will be added soon'],
            ['00 Aug', 'Will be added soon'],
            ['00 Aug', 'Will be added soon']
          ]
        },
        

        'vyasa-puja': {
          title: 'Srila Prabhupada Appearance Day (Vyasa Puja) & Nandotsav celebration', 
          image: 'https://iskconburla.com/images/image-will-be-uploaded.jpg',
          date: 'August 17, 2025',
          time: '00:00 AM - 0:00 PM',
          location: 'Main Temple Hall',
          description: 'Annual celebration honoring the appearance day of ISKCON\'s founder-acharya, His Divine Grace A.C. Bhaktivedanta Swami Prabhupada. Along with Nandotsav celebrations. The program includes:<ul><li> --</li><li>--</li><li>--</li><li>--</li></ul>',
          schedule: [
            ['00 Aug', 'Will be added soon'],
            ['00 Aug', 'Will be added soon'],
            ['00 Aug', 'Will be added soon'],
            ['00 Aug', 'Will be added soon'],
            ['00 Aug', 'Will be added soon'],
            ['00 Aug', 'Will be added soon'],
            ['00 Aug', 'Will be added soon']
          ]
        },
        'govardhan-puja': {
          title: 'Radhashtami',
          image: 'https://iskconburla.com/images/image-will-be-uploaded.jpg',
          date: 'August 31, 2025',
          time: '0:00 AM - 0:00 PM',
          location: '--',
          description: 'Join us in celebrating Radhashtami — the divine appearance day of Srimati Radharani! Program includes:<ul><li> --</li><li>--</li><li>--</li><li>--</li></ul>',
          schedule: [
            ['00 Aug', 'Will be added soon'],
            ['00 Aug', 'Will be added soon'],
            ['00 Aug', 'Will be added soon'],
            ['00 Aug', 'Will be added soon'],
            ['00 Aug', 'Will be added soon'],
            ['00 Aug', 'Will be added soon'],
            ['00 Aug', 'Will be added soon']
          ]
        },
        'morning-aarti': {
          title: 'Morning Aarti Ceremony',
          image: 'https://iskconburla.com/images/image-will-be-uploaded.jpg',
          date: 'Daily',
          time: '4:30 AM - 7:30 AM',
          location: 'Main Temple Hall',
          description: 'Begin your day with the sacred mangala arati ceremony to wake the Deities. This beautiful morning ritual includes:<ul><li>Traditional arati with lamps</li><li>Devotional songs glorifying the Lord</li><li>Offering of fresh flowers</li><li>Peaceful morning atmosphere</li></ul>',
          schedule: [
            ['4:30 AM', 'Mangala Arati'],
            ['5:00 AM', 'Tulsi Puja'],
            ['5:15-7:15 AM', 'Maha-mantra chanting'],
            ['7:15 AM', 'Shringar arati & darshan'],
            ['7:30 AM', 'Guru Puja']
          ]
        },
        'sunday-feast': {
          title: 'Sunday Love Feast',
          image: 'https://iskconburla.com/images/image-will-be-uploaded.jpg',
          date: 'Every Sunday',
          time: '8:00 AM - 12:00 PM',
          location: 'Temple Hall & Dining Area',
          description: 'Our weekly spiritual gathering featuring:<ul><li>Inspiring discourse on Bhagavad-gita</li><li>Congregational chanting (kirtan)</li><li>Delicious vegetarian feast (prasadam)</li><li>Association with devotees</li></ul>Perfect for families and spiritual seekers.',
          schedule: [
            ['4:30 AM', 'Mangala Arati'],
            ['5:00 AM', 'Tulsi Puja'],
            ['5:15-7:15 AM', 'Maha-mantra chanting'],
            ['7:15 AM', 'Shringar arati & darshan'],
            ['7:30 AM', 'Guru Puja'],
            ['8:00 AM', 'Bhagavatam class & Q&A'],
            ['10:00 AM', 'Ecstatic Kirtan'],
            ['10:30 AM', 'Prasadam Distribution'],
            
          ]
        },
        'gita-class': {
          title: 'Bhagavatam Class',
          image: 'https://iskconburla.com/images/image-will-be-uploaded.jpg',
          date: 'Tuesday, Thursday, Saturday',
          time: '8:00 AM (Sun) & 8:00 PM (Thur, online)',
          location: 'Online & Temple Hall',
          description: 'Verse-by-verse study of the Bhagavatam with practical applications for modern life. Each class includes:<ul><li>Reading of the verse and purports</li><li>Discussion and Q&A session</li><li>Real-life applications</li><li>Closing prayers</li></ul>',
          schedule: [
            ['8:00 AM/PM', 'Class begins. Q&A session after class'],
           
          ]
        },
        'kirtan-mela': {
          title: 'Friday Kirtan Mela',
          image: 'https://iskconburla.com/images/image-will-be-uploaded.jpg',
          date: 'Every Friday',
          time: '6:00 PM - 8:00 PM',
          location: 'Temple Hall',
          description: 'Ecstatic congregational chanting of the Holy Names with instruments and dancing. This program features:<ul><li>Call-and-response kirtan</li><li>Various musical instruments</li><li>Devotional dancing</li><li>Meditative atmosphere</li></ul>',
          schedule: [
            ['6:00 PM', 'Opening Kirtan'],
            ['6:30 PM', 'Devotee Experiences'],
            ['7:00 PM', 'Main Kirtan'],
            ['7:45 PM', 'Closing Prayers'],
            ['8:00 PM', 'Prasadam Distribution']
          ]
        },
        'guru-puja': {
          title: 'Guru Puja Ceremony',
          image: 'https://iskconburla.com/images/image-will-be-uploaded.jpg',
          date: 'Every Thursday',
          time: '7:30 AM - 8:30 AM',
          location: 'Main Temple Hall',
          description: 'Special worship ceremony for spiritual masters with:<ul><li>Arati with lamps and flowers</li><li>Prayers to the guru parampara</li><li>Offerings of bhoga</li><li>Reading from guru-vandana</li></ul>',
          schedule: [
            ['7:30 AM', 'Guru Puja Arati'],
            ['7:45 AM', 'Prayers to Spiritual Masters'],
            ['8:00 AM', 'Reading from Scriptures'],
            ['8:20 AM', 'Closing Prayers'],
            ['8:30 AM', 'Prasadam Distribution']
          ]
        },
        'gau-seva': {
          title: 'Gau Seva Program',
          image: 'https://iskconburla.com/images/image-will-be-uploaded.jpg',
          date: 'Every Sunday',
          time: '0:00 PM - 0:00 PM',
          location: 'Temple Goshala',
          description: 'Service to our temple cows including:<ul><li>Feeding the cows</li><li>Cleaning the goshala</li><li>Brushing the cows</li><li>Learning about cow protection</li></ul>',
          schedule: [
            ['0:00 AM', '--'],
            ['0:00 AM', '--'],
            ['0:00 AM', '--'],
            ['0:00 AM', '--'],
            ['0:00 AM', '--']
          ]
        }
      };
  
      // Modal elements
      const modal = document.getElementById('event-modal');
      const closeBtn = document.querySelector('.modal-close-btn');
      const modalTitle = document.getElementById('modal-event-title');
      const modalImage = document.getElementById('modal-event-image');
      const modalDate = document.getElementById('modal-event-date');
      const modalTime = document.getElementById('modal-event-time');
      const modalLocation = document.getElementById('modal-event-location');
      const modalDescription = document.getElementById('modal-event-description');
      const modalSchedule = document.getElementById('modal-event-schedule');
  
      // Open modal when More Details is clicked
      document.querySelectorAll('.more-details-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
          e.preventDefault();
          const eventId = this.getAttribute('data-event');
          const eventData = eventDetails[eventId];
          
          if (eventData) {
            modalTitle.textContent = eventData.title;
            modalImage.src = eventData.image;
            modalImage.alt = eventData.title;
            modalDate.textContent = eventData.date;
            modalTime.textContent = eventData.time;
            modalLocation.textContent = eventData.location;
            modalDescription.innerHTML = eventData.description;
            
            // Clear previous schedule
            modalSchedule.innerHTML = '';
            
            // Add new schedule items
            eventData.schedule.forEach(item => {
              const li = document.createElement('li');
              li.innerHTML = `<span>${item[0]}</span><span>${item[1]}</span>`;
              modalSchedule.appendChild(li);
            });
            
            // Show modal
            modal.classList.add('active');
            document.body.classList.add('modal-open');
          }
        });
      });
  
      // Close modal
      closeBtn.addEventListener('click', function() {
        modal.classList.remove('active');
        document.body.classList.remove('modal-open');
      });
  
      // Close modal when clicking outside content
      modal.addEventListener('click', function(e) {
        if (e.target === modal) {
          modal.classList.remove('active');
          document.body.classList.remove('modal-open');
        }
      });
  
      // Animation on scroll
      const animateElements = document.querySelectorAll('.animate-on-scroll');
      
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('animated');
          }
        });
      }, { threshold: 0.1 });
      
      animateElements.forEach(element => {
        observer.observe(element);
      });
      
      // Event card hover effect for mobile
      const eventCards = document.querySelectorAll('.event-card');
      
      eventCards.forEach(card => {
        card.addEventListener('touchstart', function() {
          this.classList.add('hover-effect');
        });
        
        card.addEventListener('touchend', function() {
          this.classList.remove('hover-effect');
        });
      });
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
            'https://iskconburla.com/images/image-will-be-uploaded.jpg',
            // Add other important images to preload here
        ];
        
        images.forEach(img => {
            new Image().src = img;
        });
    });
</script>
</body>
</html>