<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - LitePay</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 flex items-center justify-center min-h-screen p-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Welcome Back</h1>
            <p class="text-gray-500 mt-2">Login to manage your transactions history</p>
        </div>

        <div id="face-login-container" class="mb-6 hidden">
            <button onclick="startFaceLogin()"
                class="w-full flex items-center justify-center gap-2 bg-gray-900 text-white font-bold py-3 rounded-xl hover:bg-black transition shadow-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.131A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.2-2.85.591-4.161m6.065 1.606L11 8">
                    </path>
                </svg>
                Login with Face ID
            </button>
            <div class="relative flex py-5 items-center">
                <div class="flex-grow border-t border-gray-300"></div>
                <span class="flex-shrink-0 mx-4 text-gray-400 text-xs">OR LOGIN WITH EMAIL</span>
                <div class="flex-grow border-t border-gray-300"></div>
            </div>
        </div>

        <form action="{{ route('customer.login.submit') }}" method="POST" class="bg-white p-8 rounded-2xl shadow-xl">
            @csrf

            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                <input type="email" name="email" required
                    class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition"
                    placeholder="name@example.com">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <input type="password" name="password" required
                    class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none transition"
                    placeholder="••••••••">
                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl shadow-lg shadow-blue-500/30 transition transform active:scale-[0.98]">
                Login
            </button>
        </form>

        <p class="text-center mt-6 text-gray-600">
            Don't have an account?
            <a href="{{ route('customer.register') }}" class="text-blue-600 font-bold hover:underline">Register</a>
        </p>
    </div>
    <!-- Face ID Modal (Reused) -->
    <div id="face-modal" class="fixed inset-0 bg-black/90 hidden z-[60] flex flex-col items-center justify-center p-6">
        <div class="relative w-full max-w-sm aspect-[3/4] rounded-3xl overflow-hidden bg-gray-900 border-2 border-blue-500/50 shadow-2xl">
            <video id="face-video" class="w-full h-full object-cover transform scale-x-[-1]" autoplay playsinline muted></video>
            <div class="absolute inset-0 flex flex-col items-center justify-between py-12 pointer-events-none">
                <div class="text-center space-y-2">
                    <h3 class="text-white font-bold text-xl tracking-wide drop-shadow-md">Verifying Face</h3>
                    <p id="face-status" class="text-blue-300 text-sm font-medium animate-pulse">Scanning...</p>
                </div>
                <div class="relative w-64 h-64 border-2 border-white/30 rounded-full overflow-hidden">
                    <div id="face-scanner-line" class="absolute top-0 w-full h-1 bg-green-400 shadow-[0_0_15px_rgba(74,222,128,0.8)] opacity-0 transition-all duration-300"></div>
                </div>
                <button onclick="closeFaceModal()" class="pointer-events-auto text-white/50 text-sm hover:text-white transition">Use Password Instead</button>
            </div>
        </div>
    </div>

    <!-- Hidden Form for Bio Login -->
    <form id="bio-login-form" action="{{ route('customer.login.biometric') }}" method="POST" class="hidden">
        @csrf
        <input type="hidden" name="email" id="bio_email">
        <input type="hidden" name="token" id="bio_token">
    </form>

    <script>
        // Check for Bio Token
        if (localStorage.getItem('litepay_bio_token') && localStorage.getItem('litepay_user_email')) {
            document.getElementById('face-login-container').classList.remove('hidden');
        }

        const faceModal = document.getElementById('face-modal');
        const video = document.getElementById('face-video');
        const scannerLine = document.getElementById('face-scanner-line');
        let stream = null;

        function startFaceLogin() {
            faceModal.classList.remove('hidden');
            navigator.mediaDevices.getUserMedia({ video: { facingMode: 'user' } })
                .then(s => {
                    stream = s;
                    video.srcObject = stream;
                    simulateFaceScan();
                })
                .catch(err => {
                    alert('Camera access required for Face ID');
                    closeFaceModal();
                });
        }

        function simulateFaceScan() {
            const status = document.getElementById('face-status');
            
            setTimeout(() => {
                scannerLine.classList.remove('opacity-0');
                scannerLine.style.top = '0%';
                
                // Scan animation
                setTimeout(() => {
                    scannerLine.style.transition = 'top 1.5s ease-in-out';
                    scannerLine.style.top = '100%';
                }, 100);

                setTimeout(() => {
                    status.innerText = "Matching biometric data...";
                    status.classList.remove('text-blue-300');
                    status.classList.add('text-green-400');
                    
                    // Proceed to login
                    submitBioLogin();
                }, 1800);
            }, 500);
        }

        function submitBioLogin() {
            document.getElementById('bio_email').value = localStorage.getItem('litepay_user_email');
            document.getElementById('bio_token').value = localStorage.getItem('litepay_bio_token');
            document.getElementById('bio-login-form').submit();
        }

        function closeFaceModal() {
            faceModal.classList.add('hidden');
            if (stream) stream.getTracks().forEach(track => track.stop());
        }
    </script>
</body>
</html>