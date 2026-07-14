@if(auth()->check() && auth()->user()->role === 'customer')
<div x-data="chatWidget()" x-init="initChat()" @open-customer-chat.window="open = true; fetchMessages(); scrollDown();" style="position: fixed; bottom: 25px; right: 25px; z-index: 9999; font-family: 'Prompt', sans-serif;">
     
    <!-- Chat Window -->
    <div x-show="open" x-cloak
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="opacity-0 translate-y-10 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200 transform"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-10 scale-95"
         style="width: 360px; height: 520px; max-height: calc(100vh - 120px); background: #fff; border-radius: 20px; box-shadow: 0 15px 40px rgba(27, 42, 71, 0.2); margin-bottom: 16px; overflow: hidden; border: 1px solid rgba(27, 42, 71, 0.08); position: relative;">
        
        <!-- Header -->
        <div style="position: absolute; top: 0; left: 0; right: 0; height: 72px; box-sizing: border-box; background: linear-gradient(135deg, #1B2A47 0%, #2A3E5C 100%); color: white; padding: 16px 20px; display: flex; justify-content: space-between; align-items: center; z-index: 10;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="position: relative; width: 40px; height: 40px; background: rgba(255, 255, 255, 0.15); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">
                    🧑‍💼
                    <span style="position: absolute; bottom: 1px; right: 1px; width: 10px; height: 10px; background: #10B981; border: 2px solid #1B2A47; border-radius: 50%;"></span>
                </div>
                <div>
                    <div style="font-weight: 700; font-size: 0.95rem; line-height: 1.2;">ฝ่ายบริการลูกค้า</div>
                    <div style="font-size: 0.72rem; color: rgba(255,255,255,0.7); display: flex; align-items: center; gap: 4px;">
                        <span style="display: inline-block; width: 6px; height: 6px; background: #10B981; border-radius: 50%;"></span>
                        ออนไลน์พร้อมช่วยเหลือ
                    </div>
                </div>
            </div>
            <button @click="open = false" style="background: rgba(255,255,255,0.15); border: none; color: white; cursor: pointer; font-size: 1.1rem; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.3)'" onmouseout="this.style.background='rgba(255,255,255,0.15)'">&times;</button>
        </div>
        
        <!-- Messages Area -->
        <div id="chat-widget-messages" style="position: absolute; top: 72px; bottom: 64px; left: 0; right: 0; padding: 16px; overflow-y: auto; background: #F8FAFC; display: flex; flex-direction: column; gap: 12px; z-index: 1;">
            <div style="text-align: center; margin-bottom: 8px;">
                <span style="background: rgba(27, 42, 71, 0.05); color: #64748B; font-size: 0.72rem; padding: 4px 12px; border-radius: 12px; font-weight: 500;">
                    เริ่มต้นการสนทนา
                </span>
            </div>
            
            <template x-for="msg in messages" :key="msg.id">
                <div :style="msg.sender_id === userId ? 'align-self: flex-end;' : 'align-self: flex-start;'" 
                     style="display: flex; flex-direction: column; max-width: 80%; gap: 3px;">
                    <div :style="msg.sender_id === userId 
                        ? 'background: linear-gradient(135deg, #1B2A47, #2A3E5C); color: white; border-radius: 16px 16px 4px 16px; box-shadow: 0 2px 8px rgba(27,42,71,0.15);' 
                        : 'background: white; color: #1B2A47; border-radius: 16px 16px 16px 4px; border: 1px solid #e2e8f0; box-shadow: 0 1px 4px rgba(0,0,0,0.04);'" 
                          style="padding: 10px 14px; font-size: 0.85rem; line-height: 1.5;">
                        <span x-text="msg.content"></span>
                    </div>
                    <span :style="msg.sender_id === userId ? 'text-align: right;' : 'text-align: left;'" 
                          style="font-size: 0.68rem; color: #94A3B8;" 
                          x-text="new Date(msg.created_at).toLocaleTimeString('th-TH', { hour: '2-digit', minute: '2-digit' })">
                    </span>
                </div>
            </template>
        </div>
        
        <!-- Input Area -->
        <div style="position: absolute; bottom: 0; left: 0; right: 0; height: 64px; box-sizing: border-box; padding: 12px 16px; border-top: 1px solid #e2e8f0; background: white; display: flex; gap: 8px; align-items: center; z-index: 10;">
            <input type="text" x-model="newMessage" 
                   @keydown.enter="sendMessage()"
                   placeholder="พิมพ์ข้อความที่นี่..." 
                   style="flex: 1; padding: 10px 16px; border: 1.5px solid #e2e8f0; border-radius: 24px; outline: none; font-size: 0.85rem; font-family: 'Prompt', sans-serif; transition: all 0.2s; background: #F8FAFC;"
                   onfocus="this.style.borderColor='#1B2A47'; this.style.background='white'; this.style.boxShadow='0 0 0 3px rgba(27,42,71,0.06)';"
                   onblur="this.style.borderColor='#e2e8f0'; this.style.background='#F8FAFC'; this.style.boxShadow='none';">
            
            <button @click="sendMessage()" 
                    style="background: linear-gradient(135deg, #1B2A47, #2A3E5C); color: white; border: none; border-radius: 50%; width: 40px; height: 40px; min-width: 40px; cursor: pointer; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(27,42,71,0.2); transition: transform 0.2s;"
                    onmouseover="this.style.transform='scale(1.08)'"
                    onmouseout="this.style.transform='scale(1)'">
                <i class="fa-solid fa-paper-plane" style="font-size: 0.9rem;"></i>
            </button>
        </div>
    </div>

    <!-- Floating Button -->
    <button @click="toggleChat()" 
            style="background: linear-gradient(135deg, #1B2A47, #2A3E5C); color: white; width: 60px; height: 60px; border-radius: 50%; border: none; box-shadow: 0 8px 24px rgba(27, 42, 71, 0.3); cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.3s; float: right; position: relative;"
            onmouseover="this.style.transform='scale(1.08) translateY(-2px)'"
            onmouseout="this.style.transform='scale(1) translateY(0)'">
        <span x-show="!open" style="font-size: 1.6rem;">💬</span>
        <span x-show="open" x-cloak style="font-size: 1.4rem;">✕</span>
        <span x-show="!open && unreadCount() > 0" 
              style="position: absolute; top: -5px; right: -5px; width: 22px; height: 22px; background: #EF4444; border: 2px solid white; border-radius: 50%; color: white; font-size: 11px; font-weight: 800; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 5px rgba(0,0,0,0.2);"
              x-text="unreadCount()"></span>
    </button>
</div>

<script>
function chatWidget() {
    return {
        open: false,
        messages: [],
        newMessage: '',
        userId: {{ auth()->id() }},
        initChat() {
            // Fetch initial messages once without playing sound
            let url = '/messages?_t=' + Date.now();
            fetch(url, { headers: { 'Cache-Control': 'no-cache', 'Pragma': 'no-cache' } })
                .then(res => res.json())
                .then(data => {
                    this.messages = data;
                    this.updateNavBadge(this.unreadCount());
                    this.scrollDown();
                });

            // Start normal polling
            setInterval(() => this.fetchMessages(), 3000);
        },
        unreadCount() {
            return this.messages.filter(m => m.sender_id !== this.userId && !m.is_read).length;
        },
        playChime() {
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
                playNote(587.33, now, 0.12); // D5
                playNote(880.00, now + 0.1, 0.25); // A5
            } catch(e) {
                console.log('Chime error:', e);
            }
        },
        fetchMessages() {
            let url = '/messages?_t=' + Date.now();
            if (this.open) {
                url += '&read=1';
            }
            fetch(url, { headers: { 'Cache-Control': 'no-cache', 'Pragma': 'no-cache' } })
                .then(res => res.json())
                .then(data => {
                    if (data.length > this.messages.length) {
                        // Play sound only if it's a new message from someone else (admin)
                        let newAdminMsg = data.slice(this.messages.length).some(m => m.sender_id !== this.userId);
                        if (newAdminMsg) {
                            this.playChime();
                        }
                        this.messages = data;
                        this.scrollDown();
                    } else {
                        this.messages = data;
                    }
                    this.updateNavBadge(this.unreadCount());
                });
        },
        updateNavBadge(count) {
            document.querySelectorAll('.customer-nav-chat-badge').forEach(el => {
                if (count > 0) {
                    el.textContent = count;
                    el.style.display = 'inline-block';
                } else {
                    el.style.display = 'none';
                }
            });
        },
        sendMessage() {
            if (this.newMessage.trim() === '') return;
            fetch('/messages', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ content: this.newMessage, receiver_id: null })
            })
            .then(res => res.json())
            .then(data => {
                this.messages.push(data);
                this.newMessage = '';
                this.scrollDown();
            });
        },
        toggleChat() {
            this.open = !this.open;
            if (this.open) {
                this.fetchMessages(); // Immediately mark as read on opening
                this.scrollDown();
            }
        },
        scrollDown() {
            setTimeout(() => {
                const el = document.getElementById('chat-widget-messages');
                if (el) el.scrollTop = el.scrollHeight;
            }, 100);
        }
    };
}
</script>
@endif
