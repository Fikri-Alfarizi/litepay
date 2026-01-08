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
    <!-- Face ID Modal (Light Theme) -->
    <div id="face-modal" class="fixed inset-0 bg-white/95 backdrop-blur-sm hidden z-[60] flex flex-col items-center justify-center p-4">
        <div class="relative w-full max-w-sm aspect-[3/4] rounded-3xl overflow-hidden bg-gradient-to-br from-blue-50 to-indigo-100 border-2 border-blue-200 shadow-2xl">
            <!-- Video and Canvas Container -->
            <video id="face-video" class="w-full h-full object-cover transform scale-x-[-1]" autoplay playsinline muted></video>
            <canvas id="face-canvas" class="absolute inset-0 w-full h-full transform scale-x-[-1]"></canvas>

            <div class="absolute inset-0 flex flex-col items-center justify-between py-8 pointer-events-none">
                <div class="text-center space-y-2 px-4 bg-white/80 backdrop-blur rounded-2xl py-3 mx-4 shadow-lg">
                    <h3 class="text-gray-800 font-bold text-xl tracking-wide">Verifying Face</h3>
                    <p id="face-status" class="text-blue-600 text-sm font-medium animate-pulse">Scanning...</p>
                </div>

                <!-- Face Info Display -->
                <div id="face-info"
                    class="hidden bg-white/90 backdrop-blur-sm px-4 py-2 rounded-xl text-center space-y-1 shadow-md">
                    <div id="face-expression" class="text-2xl">😐</div>
                    <p id="match-confidence" class="text-blue-600 text-xs font-bold"></p>
                </div>

                <!-- Face Frame Guide -->
                <div class="relative w-56 h-56 border-3 border-blue-300/50 rounded-full bg-white/10">
                    <div id="face-scanner-line"
                        class="absolute top-0 w-full h-1 bg-blue-500 shadow-[0_0_15px_rgba(59,130,246,0.8)] opacity-0 animate-scan">
                    </div>
                    <!-- Corner Markers -->
                    <div class="absolute -top-1 -left-1 w-8 h-8 border-t-3 border-l-3 border-blue-500 rounded-tl-xl"></div>
                    <div class="absolute -top-1 -right-1 w-8 h-8 border-t-3 border-r-3 border-blue-500 rounded-tr-xl"></div>
                    <div class="absolute -bottom-1 -left-1 w-8 h-8 border-b-3 border-l-3 border-blue-500 rounded-bl-xl"></div>
                    <div class="absolute -bottom-1 -right-1 w-8 h-8 border-b-3 border-r-3 border-blue-500 rounded-br-xl"></div>
                </div>

                <button onclick="closeFaceModal()"
                    class="pointer-events-auto bg-gray-100 hover:bg-gray-200 px-6 py-2 rounded-full text-gray-600 text-sm font-medium transition shadow-md">
                    Use Password Instead
                </button>
            </div>

            <!-- Success Overlay -->
            <div id="face-success"
                class="hidden absolute inset-0 bg-gradient-to-br from-green-400 to-emerald-500 flex flex-col items-center justify-center transition-transform duration-500">
                <div class="bg-white rounded-full p-5 mb-4 shadow-2xl animate-bounce">
                    <svg class="w-14 h-14 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h3 class="text-white font-bold text-2xl mb-1 drop-shadow-md">Welcome Back!</h3>
                <p class="text-white/90 text-sm">Signing you in...</p>
            </div>
        </div>
    </div>

    <style>
        @keyframes scan {

            0%,
            100% {
                top: 0;
            }

            50% {
                top: 100%;
            }
        }

        .animate-scan {
            animation: scan 2s ease-in-out infinite;
        }
    </style>

    <!-- Hidden Form for Bio Login -->
    <form id="bio-login-form" action="{{ route('customer.login.biometric') }}" method="POST" class="hidden">
        @csrf
        <input type="hidden" name="face_descriptor" id="bio_face_descriptor">
    </form>

    <script src="https://cdn.jsdelivr.net/npm/@vladmandic/face-api/dist/face-api.js"></script>
    <script>
        // ============================================
        // FACE ID LOGIN WITH FULL FACE-API.JS
        // ============================================

        // Check for Bio Token AND Descriptor
        // Always show Face ID option - matching happens on server
        document.getElementById('face-login-container').classList.remove('hidden');

        const faceModal = document.getElementById('face-modal');
        const video = document.getElementById('face-video');
        const canvas = document.getElementById('face-canvas');
        const scannerLine = document.getElementById('face-scanner-line');
        const status = document.getElementById('face-status');
        const faceInfo = document.getElementById('face-info');
        const faceExpression = document.getElementById('face-expression');
        const matchConfidence = document.getElementById('match-confidence');
        const successOverlay = document.getElementById('face-success');

        let stream = null;
        let modelsLoaded = false;
        let authAttempts = 0;
        let animationId = null;

        // Expression to Emoji mapping
        const expressionEmoji = {
            neutral: '😐',
            happy: '😊',
            sad: '😢',
            angry: '😠',
            fearful: '😨',
            disgusted: '🤢',
            surprised: '😲'
        };

        async function loadModels() {
            if (modelsLoaded) return;
            status.innerText = "Loading AI Models...";
            status.classList.remove('text-green-400', 'text-red-400');
            status.classList.add('text-blue-300');

            try {
                // Use local models with fallback to CDN
                const MODEL_URL = '/models';

                await Promise.all([
                    faceapi.nets.tinyFaceDetector.loadFromUri(MODEL_URL),
                    faceapi.nets.faceLandmark68Net.loadFromUri(MODEL_URL),
                    faceapi.nets.faceRecognitionNet.loadFromUri(MODEL_URL),
                    faceapi.nets.faceExpressionNet.loadFromUri(MODEL_URL)
                ]);

                modelsLoaded = true;
                console.log('Face-API models loaded from local storage');
            } catch (e) {
                console.warn('Local models failed, trying CDN...', e);
                try {
                    const CDN_URL = 'https://justadudewhohacks.github.io/face-api.js/models';
                    await Promise.all([
                        faceapi.nets.tinyFaceDetector.loadFromUri(CDN_URL),
                        faceapi.nets.faceLandmark68Net.loadFromUri(CDN_URL),
                        faceapi.nets.faceRecognitionNet.loadFromUri(CDN_URL),
                        faceapi.nets.faceExpressionNet.loadFromUri(CDN_URL)
                    ]);
                    modelsLoaded = true;
                    console.log('Face-API models loaded from CDN');
                } catch (e2) {
                    console.error('Failed to load models:', e2);
                    alert("Failed to load AI models. Please check your connection.");
                    closeFaceModal();
                    return;
                }
            }
        }

        async function startFaceLogin() {
            faceModal.classList.remove('hidden');
            scannerLine.classList.remove('opacity-0');
            successOverlay.classList.add('hidden');
            faceInfo.classList.add('hidden');
            authAttempts = 0;

            await loadModels();

            // Try camera with retry
            async function tryCamera(attempt = 1) {
                try {
                    status.innerText = attempt > 1 ? `Retrying camera (${attempt}/3)...` : "Starting camera...";
                    
                    stream = await navigator.mediaDevices.getUserMedia({
                        video: {
                            facingMode: 'user',
                            width: { ideal: attempt === 1 ? 640 : 320 },
                            height: { ideal: attempt === 1 ? 480 : 240 }
                        }
                    });

                    video.srcObject = stream;

                    video.onloadedmetadata = () => {
                        canvas.width = video.videoWidth;
                        canvas.height = video.videoHeight;

                        status.innerText = "Scanning...";
                        verifyFace();
                    };
                } catch (err) {
                    console.error('Camera error:', err);
                    
                    if (attempt < 3) {
                        // Wait and retry
                        await new Promise(r => setTimeout(r, 1000));
                        return tryCamera(attempt + 1);
                    }
                    
                    // Final failure
                    if (err.name === 'NotAllowedError') {
                        alert('Camera permission denied. Please allow camera access.');
                    } else if (err.name === 'AbortError') {
                        alert('Camera timeout. Please close other apps using camera and try again.');
                    } else {
                        alert('Camera error: ' + err.message);
                    }
                    closeFaceModal();
                }
            }
            
            await tryCamera();
        }

        async function verifyFace() {
            if (!stream) return;

            if (authAttempts > 30) {
                status.innerText = "Face not recognized. Try password.";
                status.classList.remove('text-blue-300', 'text-green-400');
                status.classList.add('text-red-400');
                scannerLine.classList.add('opacity-0');
                faceInfo.classList.add('hidden');
                return;
            }

            try {
                const detection = await faceapi
                    .detectSingleFace(video, new faceapi.TinyFaceDetectorOptions({
                        inputSize: 416,
                        scoreThreshold: 0.5
                    }))
                    .withFaceLandmarks()
                    .withFaceExpressions()
                    .withFaceDescriptor();

                const ctx = canvas.getContext('2d');
                ctx.clearRect(0, 0, canvas.width, canvas.height);

                if (detection) {
                    // Get display size for resizing
                    const displaySize = { width: video.videoWidth, height: video.videoHeight };
                    const resizedDetection = faceapi.resizeResults(detection, displaySize);

                    // Draw face bounding box
                    const box = resizedDetection.detection.box;
                    ctx.strokeStyle = '#3b82f6';
                    ctx.lineWidth = 3;
                    ctx.strokeRect(box.x, box.y, box.width, box.height);

                    // Draw corner accents
                    const cornerSize = 15;
                    ctx.strokeStyle = '#22c55e';
                    ctx.lineWidth = 4;

                    // Top-left
                    ctx.beginPath();
                    ctx.moveTo(box.x, box.y + cornerSize);
                    ctx.lineTo(box.x, box.y);
                    ctx.lineTo(box.x + cornerSize, box.y);
                    ctx.stroke();

                    // Top-right
                    ctx.beginPath();
                    ctx.moveTo(box.x + box.width - cornerSize, box.y);
                    ctx.lineTo(box.x + box.width, box.y);
                    ctx.lineTo(box.x + box.width, box.y + cornerSize);
                    ctx.stroke();

                    // Bottom-left
                    ctx.beginPath();
                    ctx.moveTo(box.x, box.y + box.height - cornerSize);
                    ctx.lineTo(box.x, box.y + box.height);
                    ctx.lineTo(box.x + cornerSize, box.y + box.height);
                    ctx.stroke();

                    // Bottom-right
                    ctx.beginPath();
                    ctx.moveTo(box.x + box.width - cornerSize, box.y + box.height);
                    ctx.lineTo(box.x + box.width, box.y + box.height);
                    ctx.lineTo(box.x + box.width, box.y + box.height - cornerSize);
                    ctx.stroke();

                    // Draw landmarks
                    ctx.fillStyle = '#60a5fa';
                    resizedDetection.landmarks.positions.forEach(point => {
                        ctx.beginPath();
                        ctx.arc(point.x, point.y, 2, 0, 2 * Math.PI);
                        ctx.fill();
                    });

                    // Update face info display
                    faceInfo.classList.remove('hidden');

                    // Expression
                    const expressions = detection.expressions;
                    const maxExpression = Object.keys(expressions).reduce((a, b) =>
                        expressions[a] > expressions[b] ? a : b
                    );
                    faceExpression.innerText = expressionEmoji[maxExpression] || '😐';

                    // Show detection confidence
                    const detectionConfidence = Math.round(detection.detection.score * 100);
                    matchConfidence.innerText = `Detecting: ${detectionConfidence}%`;

                    if (detectionConfidence >= 70) {
                        matchConfidence.classList.remove('text-red-400', 'text-yellow-400');
                        matchConfidence.classList.add('text-green-400');
                    } else {
                        matchConfidence.classList.remove('text-green-400');
                        matchConfidence.classList.add('text-yellow-400');
                    }

                    // If good detection, send to server for matching
                    if (detection.detection.score > 0.7) {
                        status.innerText = "Verifying with server...";
                        status.classList.remove('text-blue-300', 'text-red-400');
                        status.classList.add('text-green-400');

                        if (animationId) {
                            cancelAnimationFrame(animationId);
                            animationId = null;
                        }

                        // Send face descriptor to server
                        const descriptorArray = Array.from(detection.descriptor);
                        submitBioLogin(descriptorArray);
                        return;
                    } else {
                        authAttempts++;
                        status.innerText = "Move closer for better detection...";
                    }
                } else {
                    faceInfo.classList.add('hidden');
                    authAttempts++;
                    status.innerText = "Looking for face...";
                }

                animationId = requestAnimationFrame(() => setTimeout(verifyFace, 100));

            } catch (err) {
                console.error('Detection error:', err);
                authAttempts++;
                animationId = requestAnimationFrame(() => setTimeout(verifyFace, 200));
            }
        }

        function submitBioLogin(descriptorArray) {
            status.innerText = "Matching face on server...";

            fetch("{{ route('customer.login.biometric') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ face_descriptor: descriptorArray })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        console.log('Face matched:', data.user, 'Distance:', data.distance);
                        status.innerText = `Welcome, ${data.user}!`;
                        successOverlay.classList.remove('hidden');

                        setTimeout(() => {
                            window.location.href = data.redirect;
                        }, 1000);
                    } else {
                        throw new Error(data.message || 'Face not recognized');
                    }
                })
                .catch(err => {
                    console.error('Server verification failed:', err);
                    status.innerText = err.message || "Face not recognized. Try again.";
                    status.classList.remove('text-green-400');
                    status.classList.add('text-red-400');

                    setTimeout(() => {
                        authAttempts = 0;
                        status.innerText = "Scanning...";
                        status.classList.remove('text-red-400');
                        status.classList.add('text-blue-300');
                        verifyFace();
                    }, 2000);
                });
        }

        function closeFaceModal() {
            faceModal.classList.add('hidden');

            if (animationId) {
                cancelAnimationFrame(animationId);
                animationId = null;
            }

            if (stream) {
                stream.getTracks().forEach(track => track.stop());
                stream = null;
            }

            const ctx = canvas.getContext('2d');
            ctx.clearRect(0, 0, canvas.width, canvas.height);
        }
    </script>
</body>

</html>