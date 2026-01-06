<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Merchant Panel - LitePay</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans antialiased">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <span class="text-xl font-bold text-blue-600">LitePay Merchant</span>
                        </div>
                        <div class="hidden sm:-my-px sm:ml-6 sm:flex sm:space-x-8">
                            <a href="{{ route('merchant.dashboard') }}"
                                class="{{ request()->routeIs('merchant.dashboard') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                Dashboard
                            </a>
                            <a href="{{ route('merchant.invoices.index') }}"
                                class="{{ request()->routeIs('merchant.invoices.*') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                Invoices
                            </a>
                            <a href="{{ route('merchant.transactions.index') }}"
                                class="{{ request()->routeIs('merchant.transactions.*') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                Transactions
                            </a>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="ml-3 relative">
                            <div class="flex items-center gap-4">
                                <span class="text-gray-700">{{ Auth::user()->name }}</span>
                                <form method="POST" action="{{ route('merchant.logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="text-sm text-red-600 hover:text-red-900">Logout</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="py-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                        role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif
                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>

        <!-- Floating AI Chatbot -->
        <div id="ai-chatbot-container" class="fixed bottom-6 right-6 z-50">
            <!-- Chatbot Bubble -->
            <button id="ai-chatbot-bubble"
                class="w-14 h-14 bg-blue-600 text-white rounded-full shadow-2xl flex items-center justify-center hover:bg-blue-700 transition transform hover:scale-110 active:scale-95">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                    </path>
                </svg>
            </button>

            <!-- Chat Window -->
            <div id="ai-chat-window"
                class="hidden absolute bottom-20 right-0 w-80 md:w-96 bg-white rounded-2xl shadow-2xl border border-gray-100 flex flex-col overflow-hidden transition-all duration-300 transform scale-95 origin-bottom-right">
                <!-- Header -->
                <div class="bg-blue-600 p-4 text-white flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <span class="font-bold">LitePay AI Assistant</span>
                    </div>
                    <button id="close-ai-chat" class="hover:text-gray-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l18 18"></path>
                        </svg>
                    </button>
                </div>

                <!-- Messages area -->
                <div id="ai-chat-messages" class="h-80 overflow-y-auto p-4 space-y-4 bg-gray-50 flex flex-col">
                    <div
                        class="bg-blue-100 p-3 rounded-2xl rounded-tl-none self-start max-w-[80%] text-sm text-gray-800">
                        Halo! Saya LitePay AI. Ada yang bisa saya bantu terkait transaksi atau sistem hari ini?
                    </div>
                </div>

                <!-- Input area -->
                <div class="p-4 bg-white border-t border-gray-100">
                    <form id="ai-chat-form" class="flex gap-2">
                        <input type="text" id="ai-chat-input"
                            class="flex-1 bg-gray-100 rounded-full px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Tanya sesuatu...">
                        <button type="submit" id="send-btn"
                            class="bg-blue-600 text-white p-2 rounded-full hover:bg-blue-700 disabled:bg-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const bubble = document.getElementById('ai-chatbot-bubble');
                const windowEl = document.getElementById('ai-chat-window');
                const closeBtn = document.getElementById('close-ai-chat');
                const form = document.getElementById('ai-chat-form');
                const input = document.getElementById('ai-chat-input');
                const messagesArea = document.getElementById('ai-chat-messages');
                const sendBtn = document.getElementById('send-btn');

                let history = [];

                bubble.addEventListener('click', () => {
                    windowEl.classList.toggle('hidden');
                    windowEl.classList.toggle('scale-100');
                    if (!windowEl.classList.contains('hidden')) input.focus();
                });

                closeBtn.addEventListener('click', () => {
                    windowEl.classList.add('hidden');
                    windowEl.classList.remove('scale-100');
                });

                function appendMessage(role, text) {
                    const div = document.createElement('div');
                    const isUser = role === 'user';
                    div.className = isUser
                        ? 'bg-blue-600 text-white p-3 rounded-2xl rounded-tr-none self-end max-w-[80%] text-sm'
                        : 'bg-white border border-gray-200 p-3 rounded-2xl rounded-tl-none self-start max-w-[80%] text-sm text-gray-800 shadow-sm';
                    div.textContent = text;
                    messagesArea.appendChild(div);
                    messagesArea.scrollTop = messagesArea.scrollHeight;
                }

                form.addEventListener('submit', async (e) => {
                    e.preventDefault();
                    const text = input.value.trim();
                    if (!text) return;

                    appendMessage('user', text);
                    input.value = '';
                    input.disabled = true;
                    sendBtn.disabled = true;

                    // Add typing...
                    const typingDiv = document.createElement('div');
                    typingDiv.className = 'text-xs text-gray-400 italic self-start';
                    typingDiv.textContent = 'Menjawab...';
                    messagesArea.appendChild(typingDiv);

                    try {
                        const response = await fetch("{{ route('admin_pro.chatbot.send') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                message: text,
                                history: history
                            })
                        });

                        const data = await response.json();
                        typingDiv.remove();

                        if (data.success) {
                            appendMessage('ai', data.message);
                            history.push({ role: 'user', content: text });
                            history.push({ role: 'model', content: data.message });
                        } else {
                            appendMessage('ai', 'Error: ' + data.message);
                        }
                    } catch (err) {
                        typingDiv.remove();
                        appendMessage('ai', 'Terjadi kesalahan koneksi.');
                    } finally {
                        input.disabled = false;
                        sendBtn.disabled = false;
                        input.focus();
                    }
                });
            });
        </script>
    </div>
</body>

</html>