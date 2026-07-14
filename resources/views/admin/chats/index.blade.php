<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('ระบบแชทบริการลูกค้า (Customer Live Support)') }}
        </h2>
    </x-slot>

    <div class="py-6" x-data="{ 
        activeChat: null, 
        messages: [], 
        newMessage: '', 
        users: {{ json_encode($users) }},
        searchQuery: '',
        unreadChatsCount: 0,
        quickReplies: [
            'สวัสดีครับ ดีดี.ไอที.คอม ยินดีให้บริการครับ มีอะไรให้แอดมินช่วยเหลือไหมครับ? 😊',
            'ทางเราได้รับเรื่องแล้วครับ ขออภัยในความไม่สะดวก จะรีบดำเนินการตรวจสอบให้ทันทีครับ',
            'ต้องการเปลี่ยนที่อยู่จัดส่ง หรือรายละเอียดสินค้าส่วนไหนสามารถแจ้งได้เลยครับ',
            'ดำเนินการแก้ไขให้เรียบร้อยแล้วครับ ขอบพระคุณสำหรับข้อมูลครับ 🙏'
        ],
         playNotificationSound() {
            try {
                let ctx = new (window.AudioContext || window.webkitAudioContext)();
                let playNote = (frequency, startTime, duration) => {
                    let osc = ctx.createOscillator();
                    let gain = ctx.createGain();
                    
                    osc.type = 'sine';
                    osc.frequency.setValueAtTime(frequency, startTime);
                    
                    gain.gain.setValueAtTime(0.15, startTime);
                    gain.gain.exponentialRampToValueAtTime(0.001, startTime + duration);
                    
                    osc.connect(gain);
                    gain.connect(ctx.destination);
                    
                    osc.start(startTime);
                    osc.stop(startTime + duration);
                };
                
                let now = ctx.currentTime;
                playNote(523.25, now, 0.12); // C5
                playNote(659.25, now + 0.08, 0.12); // E5
                playNote(783.99, now + 0.16, 0.25); // G5
            } catch(e) {
                console.log('Audio playback blocked or failed:', e);
            }
        },
        getReplyingAdmins() {
            let admins = [];
            this.messages.forEach(msg => {
                if (msg.sender && this.activeChat && msg.sender.id !== this.activeChat.id && (msg.sender.role === 'admin' || msg.sender.role === 'super_admin')) {
                    if (!admins.includes(msg.sender.name)) {
                        admins.push(msg.sender.name);
                    }
                }
            });
            return admins;
        },
        init() {
            // Initial unread count summation
            this.unreadChatsCount = this.users.reduce((acc, u) => acc + (u.unread_count || 0), 0);

            if (window.Echo) {
                window.Echo.private('chat.admin')
                    .listen('MessageSent', (e) => {
                        if (this.activeChat && this.activeChat.id === e.message.sender_id) {
                            this.messages.push(e.message);
                            this.scrollToBottom();
                            this.playNotificationSound();
                        }
                        let userExists = this.users.some(u => u.id === e.message.sender_id);
                        if (!userExists) {
                            this.fetchUsers();
                        }
                    });
            }

            setInterval(() => {
                this.fetchUsers();
                if (this.activeChat) {
                    fetch('/messages?user_id=' + this.activeChat.id + '&_t=' + Date.now(), { headers: { 'Cache-Control': 'no-cache', 'Pragma': 'no-cache' } })
                        .then(res => res.json())
                        .then(data => {
                            if (data.length > this.messages.length) {
                                // If active, play sound if new message is from customer
                                let newCustomerMsg = data.slice(this.messages.length).some(m => m.sender_id === this.activeChat.id);
                                if (newCustomerMsg) {
                                    this.playNotificationSound();
                                }
                                this.messages = data;
                                this.scrollToBottom();
                                this.updateNavBadges();
                            } else if (data.length !== this.messages.length) {
                                this.messages = data;
                                this.scrollToBottom();
                                this.updateNavBadges();
                            }
                        });
                }
            }, 3000);
        },
        fetchUsers() {
            fetch('{{ route('admin.chats.list_ajax') }}?_t=' + Date.now(), { headers: { 'Cache-Control': 'no-cache', 'Pragma': 'no-cache' } })
                .then(res => res.json())
                .then(data => {
                    this.users = data;
                });
        },
        getFilteredUsers() {
            if (!this.searchQuery) return this.users;
            return this.users.filter(u => 
                (u.name && u.name.toLowerCase().includes(this.searchQuery.toLowerCase())) ||
                (u.email && u.email.toLowerCase().includes(this.searchQuery.toLowerCase()))
            );
        },
        selectUser(user) {
            this.activeChat = user;
            fetch('/messages?user_id=' + user.id + '&_t=' + Date.now(), { headers: { 'Cache-Control': 'no-cache', 'Pragma': 'no-cache' } })
                .then(res => res.json())
                .then(data => {
                    this.messages = data;
                    this.scrollToBottom();
                    this.updateNavBadges();
                });
        },
        useQuickReply(text) {
            this.newMessage = text;
        },
        sendReply() {
            if (this.newMessage.trim() === '' || !this.activeChat) return;
            fetch('/messages', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ content: this.newMessage, receiver_id: this.activeChat.id })
            })
            .then(res => res.json())
            .then(data => {
                this.messages.push(data);
                this.newMessage = '';
                this.scrollToBottom();
            });
        },
        scrollToBottom() {
            setTimeout(() => {
                const el = document.getElementById('admin-chat-messages');
                if (el) {
                    el.scrollTop = el.scrollHeight;
                }
            }, 50);
        },
        updateNavBadges() {
            fetch('/admin/notification-counts?_t=' + Date.now(), { headers: { 'Cache-Control': 'no-cache', 'Pragma': 'no-cache' } })
                .then(res => res.json())
                .then(data => {
                    if (data.unread_chats > this.unreadChatsCount) {
                        this.playNotificationSound();
                    }
                    this.unreadChatsCount = data.unread_chats;

                    document.querySelectorAll('.nav-chat-badge').forEach(el => {
                        if (data.unread_chats > 0) {
                            el.textContent = data.unread_chats;
                            el.style.display = '';
                        } else {
                            el.style.display = 'none';
                        }
                    });
                    document.querySelectorAll('.nav-order-badge').forEach(el => {
                        if (data.pending_orders > 0) {
                            el.textContent = data.pending_orders;
                            el.style.display = '';
                        } else {
                            el.style.display = 'none';
                        }
                    });
                });
            this.fetchUsers();
        }
    }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col md:flex-row gap-6 h-[calc(100vh-220px)] min-h-[480px]">
            
            <!-- Chat List Sidebar -->
            <div :class="activeChat ? 'hidden md:flex' : 'flex'" 
                 class="w-full md:w-80 bg-white rounded-2xl shadow-sm border border-gray-100 flex-col overflow-hidden h-full">
                <div class="p-5 border-b border-gray-100">
                    <h3 class="font-bold text-gray-800 text-lg flex items-center gap-2 mb-3">
                        💬 แชทบริการลูกค้า
                    </h3>
                    <!-- Search input -->
                    <div class="relative">
                        <input type="text" x-model="searchQuery" 
                               placeholder="ค้นหาชื่อลูกค้า..." 
                               class="w-full pl-9 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-slate-800 focus:border-slate-800 outline-none transition">
                        <span class="absolute left-3 top-2 text-gray-400">🔍</span>
                    </div>
                </div>
                
                <div class="flex-grow overflow-y-auto">
                    <template x-if="getFilteredUsers().length === 0">
                        <div class="py-12 px-4 text-center text-gray-400 text-sm">
                            ไม่พบรายชื่อลูกค้าที่ติดต่อ
                        </div>
                    </template>
                    
                    <template x-for="user in getFilteredUsers()" :key="user.id">
                        <div @click="selectUser(user)" 
                             :class="activeChat && activeChat.id === user.id ? 'bg-slate-50 border-r-4 border-slate-900' : 'border-r-4 border-transparent hover:bg-gray-50'"
                             class="p-4 border-b border-gray-50 cursor-pointer transition flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 font-semibold text-sm">
                                👤
                            </div>
                            <div class="flex-grow min-w-0">
                                <div class="font-semibold text-gray-800 truncate" x-text="user.name"></div>
                                <template x-if="user.last_message_content">
                                    <div class="text-xs truncate mt-1 flex items-center gap-1"
                                         :class="user.unread_count > 0 ? 'text-slate-800 font-bold' : 'text-gray-500'">
                                        <template x-if="user.last_message_sender_id === user.id">
                                            <span class="text-blue-500 font-semibold">[ลูกค้า]</span>
                                        </template>
                                        <template x-if="user.last_message_sender_id !== user.id">
                                            <span class="text-slate-400">[คุณ]</span>
                                        </template>
                                        <span x-text="user.last_message_content"></span>
                                    </div>
                                </template>
                                <template x-if="!user.last_message_content">
                                    <div class="text-xs text-gray-400 truncate" x-text="user.email"></div>
                                </template>
                            </div>
                            <div x-show="user.unread_count && user.unread_count > 0">
                                <span class="bg-blue-500 text-white rounded-full text-[10px] min-w-[20px] h-5 flex items-center justify-center font-bold px-1.5" x-text="user.unread_count"></span>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Chat Conversation Area -->
            <div :class="activeChat ? 'flex' : 'hidden md:flex'" 
                 class="flex-grow bg-white rounded-2xl shadow-sm border border-gray-100 flex-col overflow-hidden h-full">
                
                <!-- Unselected State -->
                <div x-show="!activeChat" class="flex-grow flex flex-col items-center justify-center text-gray-400 gap-4">
                    <div class="w-20 h-20 rounded-full bg-slate-50 flex items-center justify-center text-3xl">
                        💬
                    </div>
                    <div class="text-center">
                        <p class="font-semibold text-gray-700">ยินดีต้อนรับสู่ระบบช่วยเหลือลูกค้า</p>
                        <p class="text-sm text-gray-400 mt-1">เลือกแชทลูกค้าจากแถบซ้ายมือเพื่อเริ่มการสนทนา</p>
                    </div>
                </div>
                
                <!-- Active Conversation -->
                <div x-show="activeChat" style="display: none;" class="flex flex-col h-full">
                    <!-- Header -->
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <!-- Back Button for Mobile -->
                            <button @click="activeChat = null" class="md:hidden p-1.5 text-gray-600 hover:text-gray-900 transition flex items-center gap-1 mr-1">
                                <i class="fa-solid fa-chevron-left text-lg"></i>
                                <span class="text-sm font-semibold">กลับ</span>
                            </button>
                            <div class="w-10 h-10 rounded-full bg-slate-800 text-white flex items-center justify-center text-sm font-bold">
                                👤
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800" x-text="activeChat ? activeChat.name : ''"></h4>
                                <div class="flex flex-col gap-0.5">
                                    <p class="text-xs text-gray-400" x-text="activeChat ? activeChat.email : ''"></p>
                                    <template x-if="getReplyingAdmins().length > 0">
                                        <p class="text-[10px] text-indigo-600 font-medium">
                                            🧑‍💻 แอดมินผู้ดูแล: <span class="font-bold" x-text="getReplyingAdmins().join(', ')"></span>
                                        </p>
                                    </template>
                                </div>
                            </div>
                        </div>
                        <span class="px-2.5 py-1 text-xs bg-emerald-50 text-emerald-600 rounded-full font-medium flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span> กำลังคุยกับลูกค้า
                        </span>
                    </div>

                    <!-- Messages Container -->
                    <div id="admin-chat-messages" class="flex-grow min-h-0 p-6 overflow-y-auto bg-slate-50/50 flex flex-col gap-4">
                        <template x-for="msg in messages" :key="msg.id">
                            <div :class="msg.sender_id !== activeChat.id ? 'self-end items-end' : 'self-start items-start'" 
                                 class="flex flex-col max-w-[75%] gap-1">
                                <div :class="msg.sender_id !== activeChat.id ? 'bg-slate-900 text-white rounded-2xl rounded-tr-none shadow-sm' : 'bg-white text-gray-800 border border-gray-100 rounded-2xl rounded-tl-none shadow-sm'" 
                                     class="px-4 py-2.5 text-sm line-height-1.5 break-words">
                                    <span x-text="msg.content"></span>
                                </div>
                                <div class="flex items-center gap-1.5 text-[10px] text-gray-400 px-1">
                                    <template x-if="msg.sender_id === activeChat.id">
                                        <span class="font-bold text-blue-600">👤 ลูกค้า</span>
                                    </template>
                                    <template x-if="msg.sender_id !== activeChat.id">
                                        <span class="font-bold text-slate-500" x-text="'🧑‍💻 ' + (msg.sender ? msg.sender.name : 'แอดมิน')"></span>
                                    </template>
                                    <span>•</span>
                                    <span x-text="new Date(msg.created_at).toLocaleTimeString('th-TH', { hour: '2-digit', minute: '2-digit' })"></span>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Quick Replies & Input Box -->
                    <div class="p-4 border-t border-gray-100 bg-white">
                        <!-- Quick Reply Chips -->
                        <div class="flex flex-wrap gap-2 mb-3 items-center">
                            <span class="text-xs text-gray-400 font-semibold mr-1">⚡ ข้อความด่วน:</span>
                            <template x-for="reply in quickReplies">
                                <button type="button" @click="useQuickReply(reply)" 
                                        class="px-3 py-1 bg-slate-50 hover:bg-slate-100 text-slate-700 border border-gray-200/60 rounded-full text-xs transition font-medium">
                                    <span x-text="reply.length > 25 ? reply.substring(0, 25) + '...' : reply"></span>
                                </button>
                            </template>
                        </div>

                        <!-- Main Send Box -->
                        <div class="flex items-center gap-3">
                            <input type="text" x-model="newMessage" @keydown.enter="sendReply()" 
                                   placeholder="พิมพ์ข้อความตอบกลับลูกค้าที่นี่..." 
                                   class="flex-grow px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-slate-800 focus:border-slate-800 outline-none transition bg-gray-50/50 focus:bg-white">
                            <button @click="sendReply()" 
                                    class="px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white rounded-xl font-bold text-sm transition shadow-sm">
                                ส่งข้อความ
                            </button>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
