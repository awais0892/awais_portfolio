{{-- resources/views/components/chatbot.blade.php --}}
<div id="chatbot-container" class="fixed bottom-6 right-6 z-50">
    <button id="chatbot-toggle"
        class="bg-cyan-500 w-16 h-16 rounded-full flex items-center justify-center text-black text-3xl glow-button">
        <i class="fas fa-robot"></i>
    </button>

    <div id="chat-window"
        class="hidden absolute bottom-20 right-0 w-80 h-[28rem] glass-card rounded-lg flex flex-col transition-all duration-300">
        <div class="p-3 border-b border-cyan-500/30 flex justify-between items-center">
            <h3 class="font-orbitron text-lg text-white">AI Assistant</h3>
            <button id="chatbot-close" class="text-cyan-500 hover:text-cyan-400 p-1 transition-colors">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <div id="chat-messages" class="flex-1 p-4 overflow-y-auto">
            <div class="chat-message ai-message mb-3">
                <p class="bg-cyan-900/50 p-3 rounded-lg text-sm">Hello! I'm Awais's AI assistant. How can I help you?
                    Ask me about his projects, skills, or experience.</p>
            </div>
        </div>

        <div class="p-3 border-t border-cyan-500/30">
            <form id="chat-form" class="flex gap-2">
                <input type="text" id="chat-input" class="w-full form-input p-2 rounded-md"
                    placeholder="Ask a question..." autocomplete="off">
                <button type="submit"
                    class="bg-cyan-500 text-black px-4 rounded-md hover:bg-cyan-400 transition-colors"><i
                        class="fas fa-paper-plane"></i></button>
            </form>
        </div>
    </div>
</div>