<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #1a1a1a;
            color: white;
        }
        
        .header {
            background-color: #1a1a1a;
            padding: 10px 20px;
            color: #9e9e9e;
            font-size: 14px;
        }
        
        .dashboard {
            background-color: #1c3856;
            margin: 0 20px;
            border-radius: 5px;
            overflow: hidden;
        }
        
        .top-nav {
            display: flex;
            background-color: #1a2d45;
            padding: 15px 20px;
        }
        
        .top-nav h1 {
            flex: 1;
            margin: 0;
            font-size: 24px;
            font-weight: normal;
        }
        
        .nav-links {
            display: flex;
            align-items: center;
        }
        
        .nav-links a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-size: 16px;
        }
        
        .dashboard-content {
            padding: 20px;
            display: flex;
            flex-direction: column;
        }

        .track-label {
            color: #9e9e9e;
            text-align: right;
            margin-bottom: 10px;
        }
        
        .charts-container {
            display: flex;
            gap: 20px;
        }
        
        .line-chart {
            flex: 1;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 5px;
            padding: 20px;
            height: 250px;
        }
        
        .pie-chart {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .sales-label {
            font-size: 18px;
            margin-bottom: 10px;
        }
        
        /* SVG styles */
        .line {
            fill: none;
            stroke: white;
            stroke-width: 2;
        }
    </style>
</head>
<body>
    <div class="header">Admin Dash</div>

    <div class="dashboard">
        <div class="top-nav">
            <h1>Administrator</h1>
            <div class="nav-links">
                <a href="#">Order Track</a>
                <a href="#">Employee Assignment</a>
                <a href="#">Sales Report</a>
            </div>
        </div>

        <div class="dashboard-content">
            <div class="track-label">Track</div>
            <div class="charts-container">
                <div class="line-chart">
                    <div class="sales-label">Sales:</div>
                    <svg width="100%" height="90%" viewBox="0 0 400 200">
                        <path class="line" d="M0,150 C20,140 40,170 60,160 C80,150 100,140 120,130 C140,120 160,100 180,85 C200,70 220,60 240,55 C260,50 280,45 300,40 C320,35 340,30 360,20 C380,10 400,15 420,10" />
                    </svg>
                </div>
                <div class="pie-chart">
                    <?php
                    // PHP code to generate a pie chart
                    echo '<svg width="250" height="250" viewBox="0 0 100 100">';
                    
                    // Pie chart segments
                    echo '<circle cx="50" cy="50" r="50" fill="#4b8fd8" />';
                    echo '<path d="M50,50 L50,0 A50,50 0 0,1 85,15 Z" fill="#2b6cb0" />';
                    echo '<path d="M50,50 L85,15 A50,50 0 0,1 100,50 Z" fill="#1e4d8c" />';
                    echo '<path d="M50,50 L100,50 A50,50 0 0,1 95,75 Z" fill="#36a3c9" />';
                    
                    echo '</svg>';
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>