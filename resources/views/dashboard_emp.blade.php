@extends('layouts.employee-layout')

@section('content')

<div class="dashboard-container" id="dashboardContainer">
    <div class="bubbles" id="bubblesContainer"></div>

    <div class="content-wrapper">
        <div class="text-content">
            <h1>Cashier Dashboard</h1>
            <div class="welcome-message">
                <h2>Hello, {{ $user->name }}!</h2>
                <p class="welcome-time">Logged in at {{ now()->format('h:i A') }} - {{ now()->format('d M Y') }}</p>
            </div>
            
            <!-- Order Status Summary Cards -->
            <div class="status-summary">
                <div class="status-card pending">
                    <div class="status-count">{{ $pendingCount }}</div>
                    <div class="status-label">Pending Orders</div>
                </div>
                <div class="status-card washing">
                    <div class="status-count">{{ $washingCount }}</div>
                    <div class="status-label">In Washing</div>
                </div>
                <div class="status-card ready">
                    <div class="status-count">{{ $readyCount }}</div>
                    <div class="status-label">Ready for Pickup</div>
                </div>
            </div>
            
            <p>Manage your laundry orders efficiently. Track order statuses and update them as work progresses.</p>
            <a href="{{ route('orders.index') }}" class="get-started" id="getStartedBtn">View All Orders</a>
        </div>

        <div class="image-content">
            <img src="{{ asset('img/1ds-removebg-preview.png') }}" alt="Laundry Illustration" id="laundryImage">
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const bubblesContainer = document.getElementById('bubblesContainer');
    const bubbleCount = 7;
    const bubbleSizes = [40, 60, 30, 50, 45, 35, 55];
    const animationDurations = [8, 12, 10, 14, 11, 9, 13];
    const positions = [10, 20, 35, 50, 70, 85, 65];

    for (let i = 0; i < bubbleCount; i++) {
        const bubble = document.createElement('div');
        bubble.className = 'bubble';
        bubble.style.width = `${bubbleSizes[i]}px`;
        bubble.style.height = `${bubbleSizes[i]}px`;
        bubble.style.left = `${positions[i]}%`;
        bubble.style.animationDuration = `${animationDurations[i]}s`;
        bubblesContainer.appendChild(bubble);
    }

    // Add click effect to Get Started button
    const getStartedBtn = document.getElementById('getStartedBtn');
    getStartedBtn.addEventListener('click', function(e) {
        e.preventDefault();
        const ripple = document.createElement('span');
        ripple.className = 'ripple';
        this.appendChild(ripple);
        
        setTimeout(() => {
            ripple.remove();
        }, 600);

        setTimeout(() => {
            window.location.href = this.href;
        }, 300);
    });

    const laundryImage = document.getElementById('laundryImage');
    laundryImage.addEventListener('mouseenter', function() {
        this.style.transform = 'scale(1.05)';
        this.style.transition = 'transform 0.3s ease';
    });
    
    laundryImage.addEventListener('mouseleave', function() {
        this.style.transform = 'scale(1)';
    });

    // Responsive adjustments
    function adjustLayout() {
        const dashboardContainer = document.getElementById('dashboardContainer');
        if (window.innerWidth < 768) {
            dashboardContainer.style.flexDirection = 'column';
        } else {
            dashboardContainer.style.flexDirection = 'row';
        }
    }

    window.addEventListener('resize', adjustLayout);
    adjustLayout(); 
});
</script>

<style>
    .dashboard-container {
        display: flex;
        flex-direction: column;
        height: calc(100vh - 60px);
        padding: 20px;
        position: relative;
        overflow: hidden;
        background: linear-gradient(137.15deg, rgba(23, 232, 255, 0.00) 0%, rgba(23, 232, 255, 0.18) 86.00000143051147%, rgba(23, 232, 255, 0.20) 100%), 
                    linear-gradient(to left, rgba(7, 156, 214, 0.20), rgba(7, 156, 214, 0.20)), 
                    linear-gradient(119.69deg, rgba(93, 141, 230, 0.00) 0%, rgba(142, 176, 239, 0.10) 45.691317319869995%, rgba(36, 89, 188, 0.20) 96.88477516174316%), 
                    linear-gradient(to left, rgba(47, 53, 109, 0.20), rgba(47, 53, 109, 0.20));
        color: white;
        margin-top: 0px;
    }

    .content-wrapper {
        display: flex;
        flex: 1;
        align-items: center;
        justify-content: space-between;
        max-width: 1200px;
        margin: 0 auto;
        width: 90%;
        z-index: 2;
    }

    .text-content {
        flex: 1;
        max-width: 500px;
    }

    .image-content {
        flex: 1;
        max-width: 500px;
        display: flex;
        justify-content: center;
    }

    .image-content img {
        max-width: 100%;
        height: auto;
        border-radius: 10px;
        transition: transform 0.3s ease;
    }

    h1 {
        font-size: 2.5rem;
        line-height: 1.2;
        margin-bottom: 1.5rem;
    }

    p {
        font-size: 1.1rem;
        line-height: 1.6;
        margin-bottom: 2rem;
    }

    .get-started {
        display: inline-block;
        padding: 12px 30px;
        background-color: rgba(255, 255, 255, 0.2);
        color: white;
        text-decoration: none;
        border-radius: 5px;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.3);
        position: relative;
        overflow: hidden;
    }

    .get-started:hover {
        background-color: rgba(255, 255, 255, 0.3);
    }

    .ripple {
        position: absolute;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.4);
        transform: scale(0);
        animation: ripple 0.6s linear;
        pointer-events: none;
    }

    @keyframes ripple {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }

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
        background-color: rgba(255, 255, 255, 0.6);
        animation-name: rise;
        animation-iteration-count: infinite;
        animation-timing-function: ease-in;
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

    /* Status Summary Cards */
    .status-summary {
        display: flex;
        gap: 15px;
        margin-bottom: 30px;
        flex-wrap: wrap;
    }

    .status-card {
        flex: 1;
        min-width: 120px;
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        padding: 15px;
        text-align: center;
        transition: transform 0.3s ease;
    }

    .status-card:hover {
        transform: translateY(-5px);
    }

    .status-count {
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .status-label {
        font-size: 0.9rem;
        opacity: 0.8;
    }

    .status-card.pending {
        background-color: rgba(255, 193, 7, 0.2);
        border-left: 4px solid #ffc107;
    }

    .status-card.washing {
        background-color: rgba(0, 123, 255, 0.2);
        border-left: 4px solid #007bff;
    }

    .status-card.ready {
        background-color: rgba(40, 167, 69, 0.2);
        border-left: 4px solid #28a745;
    }

    /* Welcome Message Styles */
    .welcome-message {
        background-color: rgba(255, 255, 255, 0.15);
        border-radius: 10px;
        padding: 15px 20px;
        margin-bottom: 20px;
        border-left: 4px solid rgba(255, 255, 255, 0.4);
        animation: fadeIn 0.8s ease;
    }

    .welcome-message h2 {
        font-size: 1.4rem;
        margin-bottom: 5px;
        color: white;
    }

    .welcome-time {
        font-size: 0.9rem;
        color: rgba(255, 255, 255, 0.8);
        margin-bottom: 0;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 768px) {
        .content-wrapper {
            flex-direction: column;
        }
        
        .text-content, .image-content {
            max-width: 100%;
            text-align: center;
        }
        
        .image-content {
            margin-top: 30px;
        }

        .status-summary {
            justify-content: center;
        }

        .status-card {
            min-width: 100px;
        }
    }
</style>
@endsection