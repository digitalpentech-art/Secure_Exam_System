<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verify OTP</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h1 class="text-2xl font-bold mb-6 text-center">Verify OTP</h1>
        <p class="text-center mb-4 text-gray-600">DEBUG: Your OTP is: {{ session('otp_debug') }}</p>
        <form action="/verify-otp" method="POST">
            @csrf
            <div class="mb-6">
                <label class="block text-gray-700">Enter OTP</label>
                <input type="text" name="otp" class="w-full p-2 border border-gray-300 rounded mt-1" required>
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded hover:bg-blue-700">Verify</button>
        </form>
    </div>
</body>
</html>
