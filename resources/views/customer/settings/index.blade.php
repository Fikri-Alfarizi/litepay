@extends('layouts.mobile')

@section('content')
    <!-- Top Bar -->
    <div class="bg-white shadow-sm p-4 sticky top-0 z-10 flex items-center gap-4">
        <a href="{{ route('customer.profile') }}" class="text-gray-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </a>
        <h1 class="font-bold text-lg text-gray-800">Settings</h1>
    </div>

    <div class="p-4 pb-24">

        <!-- Alerts -->
        @if(session('success'))
            <div
                class="bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-4 text-sm font-medium flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-4 text-sm font-medium">
                <ul class="list-disc pl-4">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Account Section -->
        <h2 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 ml-1">Account</h2>
        <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
            <div class="p-4 border-b border-gray-100">
                <form action="{{ route('customer.settings.profile') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-xs font-bold text-gray-500 mb-1">Full Name</label>
                        <input type="text" name="name" value="{{ $user->name }}"
                            class="w-full border-b border-gray-200 py-2 focus:outline-none focus:border-blue-500 transition text-gray-800 font-medium">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-1">Email Address</label>
                        <input type="email" name="email" value="{{ $user->email }}"
                            class="w-full border-b border-gray-200 py-2 focus:outline-none focus:border-blue-500 transition text-gray-800 font-medium">
                    </div>
                    <div class="mt-4 text-right">
                        <button type="submit"
                            class="bg-blue-600 text-white text-xs font-bold px-4 py-2 rounded-lg hover:bg-blue-700 transition">Save
                            Changes</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Security Section -->
        <h2 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 ml-1">Security</h2>
        <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
            <!-- Change Password -->
            <button onclick="document.getElementById('password-form').classList.toggle('hidden')"
                class="w-full flex items-center justify-between p-4 border-b border-gray-100 hover:bg-gray-50 transition text-left">
                <div class="flex items-center gap-3">
                    <div class="bg-orange-100 p-2 rounded-lg text-orange-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                    </div>
                    <span class="font-medium text-gray-700">Change Password</span>
                </div>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div id="password-form" class="hidden bg-gray-50 p-4 border-b border-gray-100">
                <form action="{{ route('customer.settings.password') }}" method="POST">
                    @csrf
                    <div class="space-y-3">
                        <input type="password" name="current_password" placeholder="Current Password"
                            class="w-full border rounded-lg p-2 text-sm">
                        <input type="password" name="new_password" placeholder="New Password (min 8 chars)"
                            class="w-full border rounded-lg p-2 text-sm">
                        <input type="password" name="new_password_confirmation" placeholder="Confirm New Password"
                            class="w-full border rounded-lg p-2 text-sm">
                        <button type="submit"
                            class="w-full bg-orange-500 text-white font-bold py-2 rounded-lg text-sm hover:bg-orange-600 transition">Update
                            Password</button>
                    </div>
                </form>
            </div>

            <!-- Fake Biometric Toggle -->
            <div class="flex items-center justify-between p-4 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="bg-purple-100 p-2 rounded-lg text-purple-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.131A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.2-2.85.591-4.161m6.065 1.606L11 8">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-gray-700">Biometric Login</p>
                        <p class="text-[10px] text-gray-500">Use fingerprint or face ID</p>
                    </div>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="bio-toggle" class="sr-only peer">
                    <div
                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                    </div>
                </label>
            </div>
        </div>

        <!-- Notifications Section -->
        <h2 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 ml-1">Notifications</h2>
        <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
            @foreach(['Transaction Alerts' => 'tx_alerts', 'Promo & Discounts' => 'promo', 'Security Alerts' => 'security'] as $label => $key)
                <div class="flex items-center justify-between p-4 border-b border-gray-100 last:border-0">
                    <span class="font-medium text-gray-700">{{ $label }}</span>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer notification-toggle" data-key="{{ $key }}" {{ ($user->settings['notifications'][$key] ?? true) ? 'checked' : '' }}>
                        <div
                            class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600">
                        </div>
                    </label>
                </div>
            @endforeach
        </div>

        <!-- General Section -->
        <h2 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 ml-1">General</h2>
        <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-8">
            <a href="#" class="flex items-center justify-between p-4 border-b border-gray-100 hover:bg-gray-50 transition">
                <span class="font-medium text-gray-700">Help Center</span>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
            <a href="#" class="flex items-center justify-between p-4 border-b border-gray-100 hover:bg-gray-50 transition">
                <span class="font-medium text-gray-700">Terms of Service</span>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
            <a href="#" class="flex items-center justify-between p-4 border-b border-gray-100 hover:bg-gray-50 transition">
                <span class="font-medium text-gray-700">Privacy Policy</span>
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
            <div class="p-4 text-center text-xs text-gray-400 bg-gray-50">
                Version 1.2.0 (Build 4452)
            </div>
        </div>

    </div>
    <!-- Face ID Enrollment Modal -->
    <div id="face-modal" class="fixed inset-0 bg-black/95 hidden z-[60] flex flex-col items-center justify-center p-4">
        <div
            class="relative w-full max-w-sm aspect-[3/4] rounded-3xl overflow-hidden bg-gray-900 border-2 border-blue-500/50 shadow-2xl">
            <!-- Video and Canvas Container -->
            <video id="face-video" class="w-full h-full object-cover transform scale-x-[-1]" autoplay playsinline
                muted></video>
            <canvas id="face-canvas" class="absolute inset-0 w-full h-full transform scale-x-[-1]"></canvas>

            <!-- Overlay UI -->
            <div class="absolute inset-0 flex flex-col items-center justify-between py-8 pointer-events-none">
                <div class="text-center space-y-2 px-4">
                    <h3 class="text-white font-bold text-xl tracking-wide drop-shadow-md">Face ID Setup</h3>
                    <p id="face-instruction" class="text-blue-300 text-sm font-medium animate-pulse">Position your face in
                        the frame</p>
                </div>

                <!-- Face Info Display -->
                <div id="face-info" class="hidden bg-black/60 backdrop-blur-sm px-4 py-2 rounded-xl text-center space-y-1">
                    <div id="face-expression" class="text-2xl">😐</div>
                    <p id="face-age-gender" class="text-white/80 text-xs font-medium"></p>
                    <p id="face-confidence" class="text-green-400 text-xs font-bold"></p>
                </div>

                <!-- Face Frame Guide -->
                <div class="relative w-56 h-56 border-2 border-white/20 rounded-full">
                    <div id="face-scanner-line"
                        class="absolute top-0 w-full h-1 bg-green-400 shadow-[0_0_15px_rgba(74,222,128,0.8)] opacity-0 animate-scan">
                    </div>
                    <!-- Corner Markers -->
                    <div class="absolute -top-1 -left-1 w-6 h-6 border-t-2 border-l-2 border-blue-400 rounded-tl-lg"></div>
                    <div class="absolute -top-1 -right-1 w-6 h-6 border-t-2 border-r-2 border-blue-400 rounded-tr-lg"></div>
                    <div class="absolute -bottom-1 -left-1 w-6 h-6 border-b-2 border-l-2 border-blue-400 rounded-bl-lg">
                    </div>
                    <div class="absolute -bottom-1 -right-1 w-6 h-6 border-b-2 border-r-2 border-blue-400 rounded-br-lg">
                    </div>
                </div>

                <button onclick="closeFaceModal()"
                    class="pointer-events-auto bg-white/10 backdrop-blur px-6 py-2 rounded-full text-white/70 text-sm hover:bg-white/20 hover:text-white transition">Cancel</button>
            </div>

            <!-- Success Overlay -->
            <div id="face-success"
                class="absolute inset-0 bg-gradient-to-br from-green-500 to-emerald-600 flex flex-col items-center justify-center translate-y-full transition-transform duration-500">
                <div class="bg-white rounded-full p-5 mb-4 shadow-2xl animate-bounce">
                    <svg class="w-14 h-14 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h3 class="text-white font-bold text-2xl mb-1">Face ID Enrolled!</h3>
                <p class="text-white/80 text-sm">You can now login with your face</p>
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

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@vladmandic/face-api/dist/face-api.js"></script>
    <script>
        // Notification Toggles
        document.querySelectorAll('.notification-toggle').forEach(toggle => {
            toggle.addEventListener('change', function () {
                const key = this.dataset.key;
                const value = this.checked ? 1 : 0;

                fetch("{{ route('customer.settings.notifications') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ key, value })
                }).catch(err => console.error(err));
            });
        });

        // ============================================
        // FACE ID ENROLLMENT WITH FULL FACE-API.JS
        // ============================================

        const bioToggle = document.getElementById('bio-toggle');
        const faceModal = document.getElementById('face-modal');
        const video = document.getElementById('face-video');
        const canvas = document.getElementById('face-canvas');
        const instruction = document.getElementById('face-instruction');
        const scannerLine = document.getElementById('face-scanner-line');
        const successOverlay = document.getElementById('face-success');
        const faceInfo = document.getElementById('face-info');
        const faceExpression = document.getElementById('face-expression');
        const faceAgeGender = document.getElementById('face-age-gender');
        const faceConfidence = document.getElementById('face-confidence');

        let stream = null;
        let modelsLoaded = false;
        let captureAttempts = 0;
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

        // Initialize Toggle State
        if (localStorage.getItem('litepay_bio_token') && {{ $user->settings['biometric_enabled'] ?? 'false' }}) {
            bioToggle.checked = true;
        } else {
            bioToggle.checked = false;
        }

        bioToggle.addEventListener('change', function (e) {
            e.preventDefault();

            if (this.checked) {
                this.checked = false;
                startFaceEnrollment();
            } else {
                disableBiometric();
            }
        });

        async function loadModels() {
            if (modelsLoaded) return;
            instruction.innerText = "Loading AI Models...";
            instruction.classList.remove('text-green-400', 'text-red-400');
            instruction.classList.add('text-blue-300');

            try {
                // Use local models with fallback to CDN
                const MODEL_URL = '/models';

                await Promise.all([
                    faceapi.nets.tinyFaceDetector.loadFromUri(MODEL_URL),
                    faceapi.nets.faceLandmark68Net.loadFromUri(MODEL_URL),
                    faceapi.nets.faceRecognitionNet.loadFromUri(MODEL_URL),
                    faceapi.nets.faceExpressionNet.loadFromUri(MODEL_URL),
                    faceapi.nets.ageGenderNet.loadFromUri(MODEL_URL)
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
                        faceapi.nets.faceExpressionNet.loadFromUri(CDN_URL),
                        faceapi.nets.ageGenderNet.loadFromUri(CDN_URL)
                    ]);
                    modelsLoaded = true;
                    console.log('Face-API models loaded from CDN');
                } catch (e2) {
                    console.error('Failed to load models:', e2);
                    alert("Failed to load AI models. Please check your connection and reload.");
                    closeFaceModal();
                    return;
                }
            }
        }

        async function startFaceEnrollment() {
            faceModal.classList.remove('hidden');
            scannerLine.classList.remove('opacity-0');
            successOverlay.classList.add('translate-y-full');
            faceInfo.classList.add('hidden');
            instruction.innerText = "Loading AI Models...";
            instruction.classList.remove('text-green-400', 'text-red-400');
            instruction.classList.add('text-blue-300');

            await loadModels();

            try {
                stream = await navigator.mediaDevices.getUserMedia({
                    video: {
                        facingMode: 'user',
                        width: { ideal: 640 },
                        height: { ideal: 480 }
                    }
                });

                video.srcObject = stream;

                video.onloadedmetadata = () => {
                    // Match canvas to video dimensions
                    canvas.width = video.videoWidth;
                    canvas.height = video.videoHeight;

                    instruction.innerText = "Position your face in the frame";
                    captureAttempts = 0;
                    detectFace();
                };
            } catch (err) {
                console.error('Camera error:', err);
                alert('Camera access denied. Please allow camera access for Face ID.');
                closeFaceModal();
            }
        }

        async function detectFace() {
            if (!stream) return;

            if (captureAttempts > 100) {
                instruction.innerText = "Face not found. Try again.";
                instruction.classList.remove('text-blue-300', 'text-green-400');
                instruction.classList.add('text-red-400');
                scannerLine.classList.add('opacity-0');
                return;
            }

            try {
                // Full detection with all features
                const detection = await faceapi
                    .detectSingleFace(video, new faceapi.TinyFaceDetectorOptions({
                        inputSize: 416,
                        scoreThreshold: 0.5
                    }))
                    .withFaceLandmarks()
                    .withFaceExpressions()
                    .withAgeAndGender()
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

                    // Draw landmarks (eyes, nose, mouth points)
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

                    // Age and Gender
                    const age = Math.round(detection.age);
                    const gender = detection.gender;
                    const genderIcon = gender === 'male' ? '♂️' : '♀️';
                    faceAgeGender.innerText = `${genderIcon} ~${age} years old`;

                    // Confidence
                    const confidence = Math.round(detection.detection.score * 100);
                    faceConfidence.innerText = `${confidence}% confidence`;

                    if (detection.detection.score > 0.85) {
                        instruction.innerText = "Perfect! Hold still...";
                        instruction.classList.remove('text-blue-300', 'text-red-400');
                        instruction.classList.add('text-green-400');

                        setTimeout(() => {
                            finishEnrollment(detection.descriptor);
                        }, 600);
                        return;
                    } else if (detection.detection.score > 0.6) {
                        instruction.innerText = "Good! Move slightly closer...";
                        instruction.classList.remove('text-red-400');
                        instruction.classList.add('text-blue-300');
                    } else {
                        instruction.innerText = "Improve lighting or move closer...";
                    }
                } else {
                    faceInfo.classList.add('hidden');
                    instruction.innerText = "Looking for face...";
                    instruction.classList.remove('text-green-400', 'text-red-400');
                    instruction.classList.add('text-blue-300');
                }

                captureAttempts++;
                animationId = requestAnimationFrame(() => setTimeout(detectFace, 100));

            } catch (err) {
                console.error('Detection error:', err);
                captureAttempts++;
                animationId = requestAnimationFrame(() => setTimeout(detectFace, 200));
            }
        }

        function finishEnrollment(descriptor) {
            if (animationId) {
                cancelAnimationFrame(animationId);
                animationId = null;
            }

            successOverlay.classList.remove('translate-y-full');

            const descriptorArray = Array.from(descriptor);
            const token = 'bio_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);

            // Always close modal after 2.5 seconds
            const closeTimeout = setTimeout(() => {
                closeFaceModal();
                bioToggle.checked = true;
            }, 2500);

            // Send face descriptor to server for secure storage
            fetch("{{ route('customer.settings.biometric') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    enabled: true,
                    token: token,
                    face_descriptor: descriptorArray  // Send to server!
                })
            })
                .then(async res => {
                    if (!res.ok) {
                        const text = await res.text();
                        console.error("Server Error:", text);
                        throw new Error("Server responded with " + res.status);
                    }
                    return res.json();
                })
                .then(data => {
                    // Only save token to localStorage (face_descriptor now on server)
                    localStorage.setItem('litepay_bio_enrolled', 'true');
                    console.log('Biometric enrolled successfully on server');
                })
                .catch(err => {
                    console.error('Server save failed:', err);
                    alert('Failed to save Face ID. Please try again.');
                });
        }

        function disableBiometric() {
            if (!confirm('Disable Face ID login?')) {
                bioToggle.checked = true;
                return;
            }

            fetch("{{ route('customer.settings.biometric') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: JSON.stringify({ enabled: false })
            })
                .then(() => {
                    localStorage.removeItem('litepay_bio_token');
                    localStorage.removeItem('litepay_face_descriptor');
                    bioToggle.checked = false;
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
@endsection