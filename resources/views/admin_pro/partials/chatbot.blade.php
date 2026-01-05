<div x-data="chatbot()" x-init="initChat()" class="fixed bottom-6 right-6 z-50 flex flex-col items-end space-y-4">

    <!-- Chat Window -->
    <div x-show="isOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 scale-95"
         class="bg-white dark:bg-gray-800 w-80 md:w-96 rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-700 flex flex-col overflow-hidden"
         style="display: none; height: 500px;">
        
        <!-- Header -->
        <div class="bg-indigo-600 p-4 flex justify-between items-center text-white shrink-0">
            <div class="flex items-center space-x-3">
                <div class="p-2 bg-white/20 rounded-full">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <div>
                    <h3 class="font-bold text-sm">LitePay AI</h3>
                    <p class="text-xs text-indigo-200 flex items-center">
                        <span class="w-2 h-2 bg-green-400 rounded-full mr-1.5"></span>
                        Online
                    </p>
                </div>
            </div>
            <button @click="toggleChat()" class="text-white hover:bg-white/20 rounded-full p-1 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <!-- Messages Area -->
        <div class="flex-1 overflow-y-auto p-4 space-y-4 bg-gray-50 dark:bg-gray-900 scroll-smooth" x-ref="messagesContainer">
            <template x-for="(msg, index) in messages" :key="index">
                <div :class="msg.role === 'user' ? 'flex justify-end' : 'flex justify-start'">
                    <div :class="msg.role === 'user' ? 'bg-indigo-600 text-white rounded-br-none' : 'bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200 shadow-sm border border-gray-100 dark:border-gray-700 rounded-bl-none'" 
                         class="max-w-[85%] rounded-2xl px-4 py-2.5 text-sm leading-relaxed relative group">
                        <div x-html="parseMarkdown(msg.content)"></div>
                         <span class="text-[10px] opacity-50 mt-1 block text-right" x-text="formatTime(new Date())"></span>
                    </div>
                </div>
            </template>

            <!-- Loading Indicator -->
            <div x-show="isLoading" class="flex justify-start">
                 <div class="bg-white dark:bg-gray-800 p-3 rounded-2xl rounded-bl-none shadow-sm border border-gray-100 dark:border-gray-700 flex space-x-1.5 items-center">
                    <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></div>
                    <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                    <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                </div>
            </div>
        </div>

        <!-- Filters/Context Chips -->
        <div class="px-4 py-2 bg-gray-50 dark:bg-gray-900 border-t border-gray-100 dark:border-gray-800 flex space-x-2 overflow-x-auto custom-scrollbar">
             <button @click="setContext('analyze')" :class="context === 'analyze' ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/50 dark:text-indigo-300 border-indigo-200' : 'bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-400 border-gray-200 dark:border-gray-700 hover:border-indigo-300'" class="whitespace-nowrap px-3 py-1 rounded-full text-xs font-medium border transition-colors">
                Analisis Data
            </button>
            <button @click="setContext('support')" :class="context === 'support' ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/50 dark:text-indigo-300 border-indigo-200' : 'bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-400 border-gray-200 dark:border-gray-700 hover:border-indigo-300'" class="whitespace-nowrap px-3 py-1 rounded-full text-xs font-medium border transition-colors">
                Bantuan
            </button>
            <button @click="setContext('creative')" :class="context === 'creative' ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/50 dark:text-indigo-300 border-indigo-200' : 'bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-400 border-gray-200 dark:border-gray-700 hover:border-indigo-300'" class="whitespace-nowrap px-3 py-1 rounded-full text-xs font-medium border transition-colors">
                Kreatif
            </button>
        </div>

        <!-- Input Area -->
        <div class="p-4 bg-white dark:bg-gray-800 border-t border-gray-100 dark:border-gray-700">
            <form @submit.prevent="sendMessage" class="relative">
                <input type="text" x-model="userInput" placeholder="Tanya sesuatu..." 
                       class="w-full pl-4 pr-12 py-3 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white dark:focus:bg-gray-800 transition-colors dark:text-white"
                       :disabled="isLoading">
                
                <button type="submit" :disabled="!userInput.trim() || isLoading" 
                        class="absolute right-2 top-2 p-1.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors shadow-sm">
                    <svg class="w-4 h-4 transform rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                </button>
            </form>
            <p class="text-[10px] text-gray-400 text-center mt-2">Powered by Gemini AI • internal use only</p>
        </div>
    </div>

    <!-- Floating Trigger Button -->
    <button @click="toggleChat()" 
            class="group relative flex items-center justify-center w-14 h-14 bg-indigo-600 hover:bg-indigo-700 text-white rounded-full shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-indigo-300"
            :class="{'rotate-90': isOpen}">
         
        <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 rounded-full border-2 border-white dark:border-gray-900 animate-pulse" x-show="!isOpen && hasNewMessage"></span>
        
        <svg x-show="!isOpen" class="w-7 h-7 transition-opacity duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
        <svg x-show="isOpen" class="w-7 h-7 transition-opacity duration-300" style="display: none;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
    </button>
</div>

<script>
    function chatbot() {
        return {
            isOpen: false,
            isLoading: false,
            userInput: '',
            messages: [
                { role: 'assistant', content: 'Halo! Saya **LitePay AI**. Ada yang bisa saya bantu? Pilih mode di atas atau langsung tanyakan sesuatu!' }
            ],
            context: 'general',
            hasNewMessage: false,

            initChat() {
                // Initialize checks or restores if needed
            },

            toggleChat() {
                this.isOpen = !this.isOpen;
                if (this.isOpen) {
                    this.hasNewMessage = false;
                    this.$nextTick(() => this.scrollToBottom());
                }
            },

            setContext(ctx) {
                this.context = ctx;
                let greeting = '';
                switch(ctx) {
                    case 'analyze': greeting = "Saya siap menganalisis data Anda. Statistik apa yang harus saya lihat?"; break;
                    case 'support': greeting = "Mode bantuan aktif. Jelaskan masalah yang Anda hadapi."; break;
                    case 'creative': greeting = "Ayo berkreasi! Apa yang perlu dibantu tulis?"; break;
                    default: greeting = "Bagaimana saya bisa membantu Anda secara umum?";
                }
                this.messages.push({ role: 'assistant', content: `**Beralih ke mode ${ctx === 'analyze' ? 'Analisis' : (ctx === 'support' ? 'Bantuan' : 'Kreatif')}.** ${greeting}` });
                this.$nextTick(() => this.scrollToBottom());
            },

            async sendMessage() {
                if (!this.userInput.trim()) return;

                const userMsg = this.userInput;
                this.messages.push({ role: 'user', content: userMsg });
                this.userInput = '';
                this.isLoading = true;
                this.$nextTick(() => this.scrollToBottom());

                try {
                    const response = await fetch("{{ route('admin_pro.chatbot.send') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            message: userMsg,
                            history: this.messages.slice(-5), // Send last 5 messages for context
                            context: this.context
                        })
                    });

                    const data = await response.json();

                    if (data.success) {
                        this.messages.push({ role: 'assistant', content: data.message });
                    } else {
                        this.messages.push({ role: 'assistant', content: '⚠️ Error: ' + (data.message || 'Something went wrong.') });
                    }

                } catch (error) {
                    this.messages.push({ role: 'assistant', content: '⚠️ Network error. Please check your connection.' });
                    console.error(error);
                } finally {
                    this.isLoading = false;
                    this.$nextTick(() => this.scrollToBottom());
                }
            },

            scrollToBottom() {
                const container = this.$refs.messagesContainer;
                container.scrollTop = container.scrollHeight;
            },
            
            formatTime(date) {
                return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            },

            parseMarkdown(text) {
                // Simple parser for bold and basic formatting
                // For a production app, use marked.js
                return text
                    .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
                    .replace(/\*(.*?)\*/g, '<em>$1</em>')
                    .replace(/\n/g, '<br>');
            }
        }
    }
</script>
