<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Smart Laundry System</title>
    <style>
        :root {
            --primary-color: #079CD6;
            --secondary-color: #2F356D;
            --accent-color: #17E8FF;
            --text-color: #333;
            --light-text: #fff;
            --section-padding: 80px 20px;
        }
        
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            color: var(--text-color);
            line-height: 1.6;
        }
        
        /* Navigation */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            background-color: rgba(255, 255, 255, 0.95);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            padding: 15px 0;
        }
        
        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: var(--primary-color);
            text-decoration: none;
        }
        
        .nav-links {
            display: flex;
            gap: 25px;
        }
        
        .nav-links a {
            color: var(--text-color);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }
        
        .nav-links a:hover {
            color: var(--primary-color);
        }
        
        .auth-links {
            display: flex;
            gap: 15px;
        }
        
        .auth-links a {
            padding: 8px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 500;
        }
        
        .login-btn {
            color: var(--primary-color);
            border: 1px solid var(--primary-color);
        }
        
        .register-btn {
            background-color: var(--primary-color);
            color: white;
        }
        
        /* Hero Section */
        .hero {
            background: linear-gradient(137.15deg, rgba(23, 232, 255, 0.00) 0%, rgba(23, 232, 255, 0.18) 86.00000143051147%, rgba(23, 232, 255, 0.20) 100%), 
                        linear-gradient(to left, rgba(7, 156, 214, 0.20), rgba(7, 156, 214, 0.20)), 
                        linear-gradient(119.69deg, rgba(93, 141, 230, 0.00) 0%, rgba(142, 176, 239, 0.10) 45.691317319869995%, rgba(36, 89, 188, 0.20) 96.88477516174316%), 
                        linear-gradient(to left, rgba(47, 53, 109, 0.20), rgba(47, 53, 109, 0.20));
            height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            color: white;
            text-align: center;
        }
        
        .hero-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
        }
        
        .hero-text {
            flex: 1;
            min-width: 300px;
            padding: 20px;
            text-align: left;
        }
        
        .hero-image {
            flex: 1;
            min-width: 300px;
            padding: 20px;
        }
        
        .hero-image img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }
        
        .hero h1 {
            font-size: 3rem;
            margin-bottom: 20px;
            line-height: 1.2;
        }
        
        .hero p {
            font-size: 1.2rem;
            margin-bottom: 30px;
            max-width: 600px;
        }
        
        .cta-button {
            display: inline-block;
            padding: 12px 30px;
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1.1rem;
            transition: background-color 0.3s;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .cta-button:hover {
            background-color: rgba(255, 255, 255, 0.3);
        }
        
        /* About Section */
        .about {
            padding: var(--section-padding);
            background-color: white;
        }
        
        .section-container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 50px;
            font-size: 2.5rem;
            color: var(--primary-color);
        }
        
        .about-content {
            display: flex;
            gap: 40px;
            align-items: center;
            flex-wrap: wrap;
        }
        
        .about-text {
            flex: 1;
            min-width: 300px;
        }
        
        .about-image {
            flex: 1;
            min-width: 300px;
        }
        
        .about-image img {
            width: 100%;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        /* Guides Section */
        .guides {
            padding: var(--section-padding);
            background-color: #f9f9f9;
        }
        
        .guide-cards {
            display: flex;
            gap: 30px;
            flex-wrap: wrap;
            justify-content: center;
        }
        
        .guide-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            width: 300px;
            transition: transform 0.3s;
        }
        
        .guide-card:hover {
            transform: translateY(-10px);
        }
        
        .guide-image {
            height: 200px;
            overflow: hidden;
        }
        
        .guide-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .guide-content {
            padding: 20px;
        }
        
        .guide-title {
            font-size: 1.3rem;
            margin-bottom: 10px;
            color: var(--primary-color);
        }
        
        /* Bubble Animation */
        .bubbles {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            top: 0;
            left: 0;
            z-index: 1;
        }

        .bubble {
            position: absolute;
            bottom: -100px;
            border-radius: 50%;
            opacity: 0.5;
            animation: rise 15s infinite ease-in;
            background-color: rgba(255, 255, 255, 0.6);
        }

        .bubble:nth-child(1) {
            width: 40px;
            height: 40px;
            left: 10%;
            animation-duration: 8s;
        }
        .bubble:nth-child(2) {
            width: 60px;
            height: 60px;
            left: 20%;
            animation-duration: 12s;
        }
        .bubble:nth-child(3) {
            width: 30px;
            height: 30px;
            left: 35%;
            animation-duration: 10s;
        }
        .bubble:nth-child(4) {
            width: 50px;
            height: 50px;
            left: 50%;
            animation-duration: 14s;
        }
        .bubble:nth-child(5) {
            width: 45px;
            height: 45px;
            left: 70%;
            animation-duration: 11s;
        }
        .bubble:nth-child(6) {
            width: 35px;
            height: 35px;
            left: 85%;
            animation-duration: 9s;
        }
        .bubble:nth-child(7) {
            width: 55px;
            height: 55px;
            left: 65%;
            animation-duration: 13s;
        }

        @keyframes rise {
            0% {
                bottom: -100px;
                transform: translateX(0);
            }
            50% {
                transform: translateX(100px);
            }
            100% {
                bottom: 1080px;
                transform: translateX(-200px);
            }
        }
        
        /* Footer */
        footer {
            background-color: var(--secondary-color);
            color: white;
            padding: 40px 20px;
            text-align: center;
        }
        
        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 30px;
        }
        
        .footer-section {
            flex: 1;
            min-width: 200px;
        }
        
        .footer-section h3 {
            margin-bottom: 20px;
            font-size: 1.3rem;
        }
        
        .footer-section a {
            color: white;
            text-decoration: none;
            display: block;
            margin-bottom: 10px;
        }
        
        .footer-section a:hover {
            text-decoration: underline;
        }
        
        .copyright {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero-content, .about-content {
                flex-direction: column;
            }
            
            .hero-text, .about-text {
                text-align: center;
            }
            
            .hero h1 {
                font-size: 2.2rem;
            }
            
            .section-title {
                font-size: 2rem;
            }
        }
        :root {
            --primary-color: #079CD6;
            --secondary-color: #2F356D;
            --accent-color: #17E8FF;
            --text-color: #333;
            --light-text: #fff;
            --section-padding: 80px 20px;
        }
        
        /* ... (keep all your existing styles) ... */

        /* View Laundry Section */
        .view-laundry {
            padding: var(--section-padding);
            background-color: white;
        }

        .laundry-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .laundry-table th, 
        .laundry-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .laundry-table th {
            background-color: var(--primary-color);
            color: white;
            font-weight: 500;
        }

        .laundry-table tr:hover {
            background-color: #f9f9f9;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
        }

        .status-badge:hover {
            transform: scale(1.05);
        }

        .status-washing {
            background-color: #FFD700;
            color: #333;
        }

        .status-ironing {
            background-color: #FFA500;
            color: white;
        }

        .status-done {
            background-color: #4CAF50;
            color: white;
        }

        .status-pending {
            background-color: #f44336;
            color: white;
        }

        /* Status Modal */
        .status-modal {
            display: none;
            position: fixed;
            z-index: 2000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }

        .modal-content {
            background-color: white;
            margin: 10% auto;
            padding: 30px;
            border-radius: 10px;
            width: 80%;
            max-width: 500px;
            box-shadow: 0 5px 30px rgba(0,0,0,0.3);
            position: relative;
            animation: modalopen 0.4s;
        }

        @keyframes modalopen {
            from {opacity: 0; transform: translateY(-50px);}
            to {opacity: 1; transform: translateY(0);}
        }

        .close-modal {
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 1.5rem;
            cursor: pointer;
            color: #777;
        }

        .close-modal:hover {
            color: #333;
        }

        .status-details {
            margin-top: 20px;
        }

        .status-details p {
            margin-bottom: 10px;
        }

        .status-title {
            font-size: 1.5rem;
            margin-bottom: 20px;
            color: var(--primary-color);
        }

        .progress-bar {
            height: 10px;
            background-color: #e0e0e0;
            border-radius: 5px;
            margin: 20px 0;
            overflow: hidden;
        }

        .progress {
            height: 100%;
            background-color: var(--primary-color);
            width: 0%;
            transition: width 0.5s;
        }
        .order-lookup-container {
        max-width: 600px;
        margin: 0 auto 30px;
        padding: 30px;
        background-color: #f9f9f9;
        border-radius: 10px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }

        .form-group {
        margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }
        
        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
            transition: background-color 0.3s;
        }
        
        .btn-primary:hover {
            background-color: #0689ba;
        }
        
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="#" class="logo">Smart Laundry Management System</a>
            <div class="nav-links">
                <a href="#home">Home</a>
                <a href="#about">About</a>
                <a href="#guides">Samples</a>
                <a href="#view-laundry">View Laundry</a>
                <a href="#contact">Contact</a>
            </div>
            <div class="auth-links">
                @auth
                    <a href="{{ route('dashboard') }}" class="login-btn">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="login-btn">Login</a>
                    @if(Route::has('register'))
                        <a href="{{ route('register') }}" class="register-btn">Register</a>
                    @endif
                @endauth
            </div>
        </div>
    </nav>

    <section class="hero" id="home">
        <div class="bubbles">
            <div class="bubble"></div>
            <div class="bubble"></div>
            <div class="bubble"></div>
            <div class="bubble"></div>
            <div class="bubble"></div>
            <div class="bubble"></div>
            <div class="bubble"></div>
        </div>
        
        <div class="hero-content">
            <div class="hero-text">
                <h1>"Laundry Lessons: Finding Clean Moments in the Chaos"</h1>
                <p>Dirty laundry can be overwhelming, but it's a reminder that even messes can be cleaned. Each load brings us closer to a fresh start.</p>
            </div>
            <div class="hero-image">
                <img src="{{ asset('img/1ds-removebg-preview.png') }}" alt="Laundry Service">
            </div>
        </div>
    </section>

    <section class="about" id="about">
        <div class="section-container">
            <h2 class="section-title">About Our Laundry Service</h2>
            <div class="about-content">
                <div class="about-text">
                    <h3>Who We Are</h3>
                    <p>FreshFold is a premium laundry service dedicated to making your life easier. We combine cutting-edge technology with eco-friendly practices to deliver exceptional cleaning results.</p>
                    <p>Our team of laundry experts handles everything from everyday clothing to delicate fabrics with the utmost care and attention to detail.</p>
                    <h3>Our Mission</h3>
                    <p>To provide convenient, reliable, and environmentally responsible laundry solutions that give our customers back their precious time.</p>
                </div>
                <div class="about-image">
                    
                </div>
            </div>
        </div>
    </section>

    <section class="guides" id="guides">
        <div class="section-container">
            <h2 class="section-title">Laundry Care Guides</h2>
            <div class="guide-cards">
                <div class="guide-card">
                    <div class="guide-image">
                        <img src="https://images.unsplash.com/photo-1598300042247-d088f8ab3a91?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" alt="Sorting Laundry">
                    </div>
                 
                </div>
                
                <div class="guide-card">
                    
                </div>
                
                <div class="guide-card">
                
                </div>
            </div>
        </div>
    </section>
    <section class="view-laundry" id="view-laundry">
        <div class="section-container">
            <h2 class="section-title">Track Your Order</h2>
            
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            
            <div class="order-lookup-container">
                <form action="{{ route('track.order') }}" method="GET">
                    <div class="form-group">
                        <label for="order_id">Order ID / Receipt Number</label>
                        <input type="text" name="order_id" id="order_id" class="form-control" 
                            placeholder="Enter your order ID or receipt number" 
                            value="{{ request('order_id') }}" required>
                        <button type="submit" class="btn btn-primary">Track Order</button>
                    </div>
                </form>
            </div>
            
            <!-- Keep your existing table for demonstration purposes or remove it -->
            <!-- It shows what will appear for admins, but customer tracking will be separate -->
        </div>
    </section>

    <!-- Status Modal -->
    <div id="statusModal" class="status-modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeStatusModal()">&times;</span>
            <h3 class="status-title">Order Status Details</h3>
            <div class="progress-bar">
                <div class="progress" id="statusProgress"></div>
            </div>
            <div class="status-details" id="statusDetails">
                <!-- Content will be dynamically inserted here -->
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h3>FreshFold</h3>
                <p>Making laundry day easier with our premium cleaning services and expert care.</p>
            </div>
            <div class="footer-section">
                <h3>Quick Links</h3>
                <a href="#home">Home</a>
                <a href="#about">About</a>
                <a href="#guides">Guides</a>
                <a href="#services">Services</a>
                <a href="#contact">Contact</a>
            </div>
            <div class="footer-section">
                <h3>Contact Us</h3>
                <p>123 Laundry Street</p>
                <p>Clean City, CC 12345</p>
                <p>Phone: (123) 456-7890</p>
                <p>Email: info@freshfold.com</p>
            </div>
        </div>
        <div class="copyright">
            <p>&copy; 2023 FreshFold Laundry Service. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>