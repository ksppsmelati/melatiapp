<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
            font-family: Arial, sans-serif;
        }

        .success-container {
            text-align: center;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 200px; /* Increased width for better display */
        }

        .success-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: #4CAF50;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 15px;
            animation: pulse 1s ease-out;
        }

        .success-icon::before {
            content: "\2714";
            /* Checkmark character */
            font-size: 48px;
            color: #fff;
        }

        .success-message {
            font-size: 18px;
            color: #333;
            margin-bottom: 20px;
        }

        .back-button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #D3D3D3;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .back-button:hover {
            background-color: #cbcbcb;
        }

        .counter {
            font-size: 20px;
            color: #555;
            margin-top: 20px;
        }

        @keyframes pulse {
            0% {
                transform: scale(0.9);
                opacity: 0.7;
            }

            50% {
                transform: scale(1.1);
                opacity: 1;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }
    </style>
</head>

<body>
    <div class="success-container">
        <div class="success-icon"></div>
        <div class="success-message">Berhasil!</div>
        <a href="javascript:history.back()" class="back-button">Kembali</a>
        <div class="counter"><span id="countdown">3</span> detik...</div>
    </div>
    <script>
        var countdownElement = document.getElementById('countdown');
        var countdownTime = 3; // Set to 3 seconds
        var countdownInterval = setInterval(updateCountdown, 1000); // Update countdown every second

        function updateCountdown() {
            countdownElement.textContent = countdownTime;
            countdownTime--;

            if (countdownTime < 0) {
                clearInterval(countdownInterval); // Stop the countdown
                history.go(-2); // Redirect after countdown is finished
            }
        }
    </script>
</body>

</html>
