<?php
session_start();
if (!isset($_COOKIE[$_SESSION['hashemail']]) || $_COOKIE[$_SESSION['hashemail']] != 'register') {
    header("Location:/authentication");
    exit();
}
include_once('/app/vendor/autoload.php');
$newIncludePath = '/app/vendor';
set_include_path($newIncludePath);

use RobThree\Auth\Providers\Qr\EndroidQrCodeProvider;
use RobThree\Auth\TwoFactorAuth;

$tfa = new TwoFactorAuth(
    qrcodeprovider: new EndroidQrCodeProvider()
);
$pattern = '#^(?:[A-Z2-7]{8})*(?:[A-Z2-7]{2}={6}|[A-Z2-7]{4}={4}|[A-Z2-7]{5}={3}|[A-Z2-7]{7}=)?$#';
do {
    $secret = $tfa->createSecret();
} while (!preg_match($pattern, $secret));
$_SESSION['secret'] = $secret;

?>
<!DOCTYPE html>
<html>

<head>
    <title>Two-Factor Authentication</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            box-sizing: border-box;
        }

        body {
            background: #00a7a7;
            font-family: "Lato", sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            margin: 0;
        }

        p {
            background-color: rgba(255, 255, 255, 0.3);
            font-size: 20px;
            border-radius: 10px;
            max-width: 1000px;
            text-align: center;
        }

        .qr-code {
            max-width: 1100px;
            width: 30%;
            margin: 0 auto;
            text-align: center;
            padding: 25px 35px;
            background: #f5f5f5;
            border: 1px solid #ddd;
            border-radius: 10px;
        }

        .Form .btn {
            background: #231919;
            color: white;
            margin-top: 30px;
            width: 100%;
            padding: 10px 0;
            border-radius: 10px;
        }

        .qr-box img {
            width: 15rem;
            height: 15rem;
        }
    </style>
</head>

<body>
    <div class="qr-code">
        <br><br>
        <p>Scan the following image with your authenticator app:</p><br><br>
        <div class="qr-box">
            <img src="<?php
                        echo $tfa->getQRCodeImageAsDataUri($_SESSION['Username'] . '_' . $_SESSION['email'], $secret, 400); ?>">
        </div>

        <div class="Form">
            <form method="post" action="/authentication/register-otp">
                <label for="otp"><br>Enter OTP: </label>
                <input type="text" id="otpInput" placeholder=" Your OTP" name="otp" id="otp" required><br>
                <button type="submit" class="btn">Submit</button>
            </form>
        </div>
    </div>

    <script>
        // otp validation
        var otpInput = document.getElementById('otpInput');
        var otpValidationMessage = document.getElementById('otpValidationMessage');
        var typingTimer; // Timer identifier
        var doneTypingInterval = 1000; // Delay in milliseconds (1 second)

        otpInput.addEventListener('input', function () {
            clearTimeout(typingTimer); // Clear the previous timer

            // Start a new timer to delay the validation
            typingTimer = setTimeout(validateOTP, doneTypingInterval);
        });

        function validateOTP() {
            var otp = otpInput.value;
            var otpRegex = /^\d{6}$/;

            if (otpRegex.test(otp)) {
                otpValidationMessage.textContent = '';
            } else {
                alert('Please enter a 6-digit OTP.');
                otpInput.value = '';
            }
        }
    </script>
</body>

</html>