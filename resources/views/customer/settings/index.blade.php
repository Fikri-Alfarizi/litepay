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
    <div id="face-modal" class="fixed inset-0 bg-black/90 hidden z-[60] flex flex-col items-center justify-center p-6">
        <div
            class="relative w-full max-w-sm aspect-[3/4] rounded-3xl overflow-hidden bg-gray-900 border-2 border-blue-500/50 shadow-2xl">
            <video id="face-video" class="w-full h-full object-cover transform scale-x-[-1]" autoplay playsinline
                muted></video>

            <!-- Overlay UI -->
            <div class="absolute inset-0 flex flex-col items-center justify-between py-12 pointer-events-none">
                <div class="text-center space-y-2">
                    <h3 class="text-white font-bold text-xl tracking-wide drop-shadow-md">Face ID Setup</h3>
                    <p id="face-instruction" class="text-blue-300 text-sm font-medium animate-pulse">Position your face in
                        the frame</p>
                </div>

                <!-- Face Frame -->
                <div class="relative w-64 h-64 border-2 border-white/30 rounded-full overflow-hidden">
                    <div id="face-scanner-line"
                        class="absolute top-0 w-full h-1 bg-green-400 shadow-[0_0_15px_rgba(74,222,128,0.8)] opacity-0 transition-all duration-300">
                    </div>
                </div>

                <button onclick="closeFaceModal()"
                    class="pointer-events-auto text-white/50 text-sm hover:text-white transition">Cancel</button>
            </div>

            <!-- Success Overlay -->
            <div id="face-success"
                class="absolute inset-0 bg-green-500 flex flex-col items-center justify-center translate-y-full transition-transform duration-500">
                <div class="bg-white rounded-full p-4 mb-4 shadow-lg">
                    <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h3 class="text-white font-bold text-2xl">Verified!</h3>
            </div>
        </div>
    </div>

    <!-- Scripts -->
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

        // Biometric Logic
        const bioToggle = document.getElementById('bio-toggle');
        const faceModal = document.getElementById('face-modal');
        const video = document.getElementById('face-video');
        const instruction = document.getElementById('face-instruction');
        const scannerLine = document.getElementById('face-scanner-line');
        const successOverlay = document.getElementById('face-success');
        let stream = null;

        // Initialize Toggle State
        if (localStorage.getItem('litepay_bio_token') && {{ $user->settings['biometric_enabled'] ?? 'false' }}) {
            bioToggle.checked = true;
        } else {
            bioToggle.checked = false;
        }

        bioToggle.addEventListener('change', function (e) {
            e.preventDefault(); // Stop default change

            if (this.checked) {
                // User wants to Enable -> Start Enrollment
                this.checked = false; // Wait for success
                startFaceEnrollment();
            } else {
                // User wants to Disable
                disableBiometric();
            }
        });

        function startFaceEnrollment() {
            faceModal.classList.remove('hidden');

            navigator.mediaDevices.getUserMedia({ video: { facingMode: 'user' } })
                .then(s => {
                    stream = s;
                    video.srcObject = stream;
                    runLivenessCheck();
                })
                .catch(err => {
                    alert('Camera access denied');
                    closeFaceModal();
                });
        }

        function runLivenessCheck() {
            const steps = [
                { text: "Position your face...", delay: 2000 },
                { text: "Blink your eyes...", delay: 2500 },
                { text: "Turn slightly left...", delay: 2500 },
                { text: "Smile!", delay: 2000 },
                { text: "Verifying...", delay: 1500 }
            ];

            let step = 0;

            function nextStep() {
                if (step >= steps.length) {
                    finishEnrollment();
                    return;
                }

                instruction.innerText = steps[step].text;
                scannerLine.classList.remove('opacity-0');
                scannerLine.style.top = '0%';

                // Animate scan line
                setTimeout(() => {
                    scannerLine.style.transition = 'top 1.5s ease-in-out';
                    scannerLine.style.top = '100%';
                }, 100);

                // Simulate reset scan line
                setTimeout(() => {
                    scannerLine.style.transition = 'none';
                    scannerLine.style.top = '0%';
                    if (step < steps.length - 1) scannerLine.classList.add('opacity-0');
                }, 1500);

                setTimeout(() => {
                    step++;
                    nextStep();
                }, steps[step].delay);
            }

            nextStep();
        }

        function finishEnrollment() {
            successOverlay.classList.remove('translate-y-full');

            // Generate pseudo-token
            const token = 'bio_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);

            // 1. Save to Server
            fetch("{{ route('customer.settings.biometric') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: JSON.stringify({ enabled: true, token: token })
            })
                .then(res => res.json())
                .then(data => {
                    // 2. Save to LocalStorage
                    localStorage.setItem('litepay_bio_token', data.token);
                    localStorage.setItem('litepay_user_email', "{{ $user->email }}"); // Helper for login

                    setTimeout(() => {
                        closeFaceModal();
                        bioToggle.checked = true;
                        successOverlay.classList.add('translate-y-full'); // Reset
                    }, 1500);
                })
                .catch(err => {
                    alert('Server Error');
                    closeFaceModal();
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
                    bioToggle.checked = false;
                });
        }

        function closeFaceModal() {
            faceModal.classList.add('hidden');
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
                stream = null;
            }
        }
    </script>
@endsection