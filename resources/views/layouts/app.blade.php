{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', $settings['site_title'] ?? 'Awais Ahmad - Full-Stack Developer')</title>
    <meta name="description" content="@yield('description', $settings['site_description'] ?? 'Portfolio of Awais Ahmad')">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700&family=Rajdhani:wght@400;600&display=swap" rel="stylesheet">
    
    <!-- GSAP and SweetAlert2 are now loaded via Vite in app.js -->
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    @stack('styles')
    
    <style>
        body {
            background-color: #0A0F1E;
            color: #E0E0E0;
            font-family: 'Rajdhani', sans-serif;
            overflow-x: hidden;
        }
        .font-orbitron {
            font-family: 'Orbitron', sans-serif;
        }
        .gradient-text {
            background: linear-gradient(90deg, #00F5FF, #7A00FF);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .glass-card {
            background: rgba(23, 29, 49, 0.5);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 245, 255, 0.2);
            box-shadow: 0 0 20px rgba(0, 245, 255, 0.1);
        }
        .glow-button {
            box-shadow: 0 0 5px #00F5FF, 0 0 15px #00F5FF, 0 0 25px #00F5FF;
            transition: box-shadow 0.3s ease-in-out, transform 0.3s ease-in-out;
        }
        .glow-button:hover {
            box-shadow: 0 0 10px #00F5FF, 0 0 25px #00F5FF, 0 0 50px #00F5FF;
            transform: scale(1.05);
        }
        .skill-icon {
            transition: transform 0.3s, filter 0.3s;
        }
        .skill-icon:hover {
            transform: scale(1.1);
            filter: drop-shadow(0 0 10px #00F5FF);
        }
        #particle-canvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }
        .gsap-reveal {
            opacity: 0;
            visibility: visible;
            transform: translateY(50px);
            transition: none;
        }
        .gsap-reveal.animated {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Enhanced animations for home page elements */
        .hero-text {
            animation: fadeInUp 1s ease-out 0.5s both;
        }
        
        .skill-icon {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .skill-icon:hover {
            transform: translateY(-10px) scale(1.1);
            filter: drop-shadow(0 10px 20px rgba(0, 245, 255, 0.4));
        }
        
        .glass-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .glass-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 245, 255, 0.15);
            border-color: rgba(0, 245, 255, 0.4);
        }
        
        .glow-button {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        
        .glow-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }
        
        .glow-button:hover::before {
            left: 100%;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .floating {
            animation: float 6s ease-in-out infinite;
        }
        
        /* Typing effect styles */
        #home h1 span {
            display: inline-block;
            opacity: 0;
            transform: translateY(20px);
        }
        
        /* Enhanced glass card effects */
        .glass-card {
            position: relative;
            overflow: hidden;
        }
        
        .glass-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(0, 245, 255, 0.1), transparent);
            transition: left 0.6s ease;
        }
        
        .glass-card:hover::before {
            left: 100%;
        }
        
        /* Skill icon pulse effect */
        .skill-icon {
            position: relative;
        }
        
        .skill-icon::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(0, 245, 255, 0.3) 0%, transparent 70%);
            transform: translate(-50%, -50%) scale(0);
            transition: transform 0.3s ease;
            border-radius: 50%;
        }
        
        .skill-icon:hover::after {
            transform: translate(-50%, -50%) scale(1.5);
        }
        
        /* Button ripple effect */
        .glow-button {
            position: relative;
            overflow: hidden;
        }
        
        .glow-button::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }
        
        .glow-button:active::after {
            width: 300px;
            height: 300px;
        }
        .exp-card {
            border-left: 3px solid #00F5FF;
        }
        .form-input {
            background: rgba(10, 15, 30, 0.7);
            border: 1px solid rgba(0, 245, 255, 0.3);
            color: #E0E0E0;
        }
        .form-input:focus {
            outline: none;
            border-color: #00F5FF;
            box-shadow: 0 0 10px rgba(0, 245, 255, 0.5);
        }
        .loader {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #00F5FF;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .chat-message p {
            max-width: 90%;
        }
        .user-message {
            display: flex;
            justify-content: flex-end;
        }
        .user-message p {
            background-color: rgba(122, 0, 255, 0.4);
            text-align: right;
        }
        
        /* SweetAlert2 theme overrides - Now properly scoped */
        .swal2-container { 
            z-index: 99999; 
        }
        
        .swal2-popup {
            background: rgba(23, 29, 49, 0.95) !important;
            border: 1px solid rgba(0, 245, 255, 0.15) !important;
            box-shadow: 0 0 30px rgba(0, 245, 255, 0.06) !important;
            color: #E0E0E0 !important;
            font-family: 'Rajdhani', sans-serif !important;
            padding: 16px 18px !important;
            border-width: 2px !important;
            border-radius: 10px !important;
            position: relative;
            overflow: hidden;
        }
        
        .swal2-popup.swal2-modal.swal2-show {
            max-width: 360px !important;
        }
        
        .swal2-title {
            font-family: 'Orbitron', sans-serif !important;
            color: #FFFFFF !important;
            font-size: 1.05rem !important; 
            margin-bottom: 6px !important;
        }
        
        .swal2-html-container {
            color: #C8D1DA !important;
            font-size: 0.95rem !important; 
            margin-bottom: 8px !important;
        }
        
        .swal2-confirm {
            background: linear-gradient(90deg, #00F5FF, #7A00FF) !important;
            color: #000 !important;
            border: none !important;
            box-shadow: 0 0 12px #00F5FF !important;
            border-radius: 8px !important;
            padding: 10px 18px !important;
        }
        
        .swal2-cancel {
            color: #FFF !important;
            border: 1px solid rgba(255,255,255,0.06) !important;
            background: transparent !important;
        }
        
        .swal2-timer-progress-bar {
            position: absolute !important;
            top: 0 !important;
            left: 0 !important;
            height: 6px !important;
            width: 100% !important;
            border-top-left-radius: 10px !important;
            border-top-right-radius: 10px !important;
            background: linear-gradient(90deg, #00F5FF, #7A00FF) !important;
            box-shadow: 0 0 12px rgba(0,245,255,0.08) !important;
            z-index: 1000 !important;
        }
        
        .swal2-icon {
            margin: 8px auto 6px !important;
            width: auto !important;
            height: auto !important;
        }
        
        .swal2-success-circular-line-left,
        .swal2-success-circular-line-right,
        .swal2-success-fix {
            background-color: #00F5FF !important;
        }
        
        .swal2-success-line-tip,
        .swal2-success-line-long {
            background-color: #00F5FF !important;
        }
        
        .swal2-error-line {
            background-color: #ff6b6b !important;
        }
        
        .swal2-warning {
            border-color: #f39c12 !important;
            color: #f39c12 !important;
        }
    </style>
</head>
<body>
    <canvas id="particle-canvas"></canvas>

    @include('components.header')

    <main class="container mx-auto px-6 pt-24 relative z-10">
        @yield('content')
    </main>
    
    @include('components.footer')
    @include('components.chatbot')

    @stack('scripts')
    
    @include('components.scripts')
</body>
</html>