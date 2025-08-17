@extends('layouts.app')

@section('title', 'Contact Message - Admin')
@section('page-title', 'Contact Message')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 relative overflow-hidden">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-cyan-500/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-purple-500/10 rounded-full blur-3xl animate-pulse delay-1000"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-blue-500/5 rounded-full blur-3xl animate-pulse delay-500"></div>
    </div>

    <!-- Grid Pattern Overlay -->
    <div class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.02)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.02)_1px,transparent_1px)] bg-[size:50px_50px]"></div>

    <!-- Content Container -->
    <div class="relative z-10 container mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6 mb-8">
            <div>
                <h1 class="text-4xl font-bold bg-gradient-to-r from-cyan-400 via-purple-400 to-pink-400 bg-clip-text text-transparent mb-2">
                    Contact Message
                </h1>
                <p class="text-cyan-200/80">View and manage contact form submission</p>
            </div>
            
            <div class="flex gap-3">
                <a href="{{ route('admin.contacts.index') }}" 
                   class="px-4 py-2 bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-semibold rounded-xl hover:from-cyan-600 hover:to-blue-700 transition-all duration-300 transform hover:scale-105">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Messages
                </a>
                <a href="{{ route('admin.dashboard') }}" 
                   class="px-4 py-2 bg-gradient-to-r from-purple-500 to-pink-600 text-white font-semibold rounded-xl hover:from-purple-600 hover:to-pink-700 transition-all duration-300 transform hover:scale-105">
                    <i class="fas fa-tachometer-alt mr-2"></i>
                    Dashboard
                </a>
            </div>
        </div>

        <!-- Message Details -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Message Card -->
                <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6">
                    <div class="flex items-start justify-between mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-white mb-2">{{ $contact->subject }}</h2>
                            <div class="flex items-center gap-4 text-sm text-cyan-300">
                                <span class="flex items-center gap-2">
                                    <i class="fas fa-user"></i>
                                    {{ $contact->name }}
                                </span>
                                <span class="flex items-center gap-2">
                                    <i class="fas fa-envelope"></i>
                                    {{ $contact->email }}
                                </span>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="px-3 py-1 text-sm font-semibold rounded-full 
                                {{ $contact->status === 'unread' ? 'bg-red-500/20 text-red-300' : 
                                   ($contact->status === 'read' ? 'bg-blue-500/20 text-blue-300' : 'bg-green-500/20 text-green-300') }}">
                                {{ ucfirst($contact->status ?? 'new') }}
                            </span>
                            <div class="text-xs text-cyan-300/70 mt-2">
                                {{ $contact->created_at->format('M d, Y \a\t H:i') }}
                            </div>
                        </div>
                    </div>

                    <div class="bg-white/5 rounded-xl p-4 mb-6">
                        <h3 class="text-lg font-semibold text-white mb-3">Message</h3>
                        <div class="text-cyan-200/90 leading-relaxed whitespace-pre-wrap">{{ $contact->message }}</div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-wrap gap-3">
                        <button onclick="updateStatus('{{ $contact->id }}', '{{ $contact->status === 'unread' ? 'read' : 'unread' }}')" 
                                class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fas fa-{{ $contact->status === 'unread' ? 'check' : 'undo' }} mr-2"></i>
                            {{ $contact->status === 'unread' ? 'Mark as Read' : 'Mark as Unread' }}
                        </button>
                        
                        <button onclick="updateStatus('{{ $contact->id }}', 'replied')" 
                                class="px-4 py-2 bg-green-600 text-white text-sm font-semibold rounded-lg hover:bg-green-700 transition-colors">
                            <i class="fas fa-reply mr-2"></i>
                            Mark as Replied
                        </button>

                        <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject }}" 
                           class="px-4 py-2 bg-cyan-600 text-white text-sm font-semibold rounded-lg hover:bg-cyan-700 transition-colors">
                            <i class="fas fa-envelope mr-2"></i>
                            Reply via Email
                        </a>

                        <button onclick="deleteContact('{{ $contact->id }}')" 
                                class="px-4 py-2 bg-red-600 text-white text-sm font-semibold rounded-lg hover:bg-red-700 transition-colors">
                            <i class="fas fa-trash mr-2"></i>
                            Delete Message
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Contact Info Card -->
                <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6">
                    <h3 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                        <i class="fas fa-user-circle text-cyan-400"></i>
                        Contact Information
                    </h3>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-cyan-500/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-user text-cyan-400"></i>
                            </div>
                            <div>
                                <div class="text-sm text-cyan-300/70">Name</div>
                                <div class="text-white font-medium">{{ $contact->name }}</div>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-purple-500/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-envelope text-purple-400"></i>
                            </div>
                            <div>
                                <div class="text-sm text-purple-300/70">Email</div>
                                <div class="text-white font-medium">{{ $contact->email }}</div>
                            </div>
                        </div>

                        @if($contact->ip_address)
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-500/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-globe text-blue-400"></i>
                            </div>
                            <div>
                                <div class="text-sm text-blue-300/70">IP Address</div>
                                <div class="text-white font-medium">{{ $contact->ip_address }}</div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Message Meta Card -->
                <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6">
                    <h3 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                        <i class="fas fa-info-circle text-blue-400"></i>
                        Message Details
                    </h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-cyan-300/70">Status</span>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $contact->status === 'unread' ? 'bg-red-500/20 text-red-300' : 
                                   ($contact->status === 'read' ? 'bg-blue-500/20 text-blue-300' : 'bg-green-500/20 text-green-300') }}">
                                {{ ucfirst($contact->status ?? 'new') }}
                            </span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-cyan-300/70">Received</span>
                            <span class="text-white text-sm">{{ $contact->created_at->diffForHumans() }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-cyan-300/70">Date</span>
                            <span class="text-white text-sm">{{ $contact->created_at->format('M d, Y') }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-cyan-300/70">Time</span>
                            <span class="text-white text-sm">{{ $contact->created_at->format('H:i') }}</span>
                        </div>

                        @if($contact->updated_at && $contact->updated_at != $contact->created_at)
                        <div class="flex justify-between items-center">
                            <span class="text-cyan-300/70">Last Updated</span>
                            <span class="text-white text-sm">{{ $contact->updated_at->diffForHumans() }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Quick Actions Card -->
                <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6">
                    <h3 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                        <i class="fas fa-bolt text-yellow-400"></i>
                        Quick Actions
                    </h3>
                    <div class="space-y-3">
                        <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject }}" 
                           class="block w-full px-4 py-2 bg-cyan-600 text-white text-sm font-semibold rounded-lg hover:bg-cyan-700 transition-colors text-center">
                            <i class="fas fa-envelope mr-2"></i>
                            Send Email Reply
                        </a>
                        
                        <button onclick="copyEmail()" 
                                class="w-full px-4 py-2 bg-purple-600 text-white text-sm font-semibold rounded-lg hover:bg-purple-700 transition-colors">
                            <i class="fas fa-copy mr-2"></i>
                            Copy Email Address
                        </button>
                        
                        <button onclick="copyMessage()" 
                                class="w-full px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fas fa-copy mr-2"></i>
                            Copy Message
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="delete-modal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-6 max-w-md w-full">
            <h3 class="text-lg font-bold text-white mb-4">Confirm Deletion</h3>
            <p class="text-cyan-200/80 mb-6">Are you sure you want to delete this contact message? This action cannot be undone.</p>
            <div class="flex gap-3">
                <button onclick="closeDeleteModal()" 
                        class="flex-1 px-4 py-2 bg-white/10 border border-white/20 text-white font-semibold rounded-lg hover:bg-white/20 transition-colors">
                    Cancel
                </button>
                <button onclick="confirmDelete()" 
                        class="flex-1 px-4 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition-colors">
                    Delete
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const { gsap } = window;
        if (!gsap) return;

        // Header animations
        gsap.fromTo('.text-4xl', 
            { y: 50, opacity: 0 }, 
            { y: 0, opacity: 1, duration: 0.8, ease: "power2.out" }
        );

        gsap.fromTo('.text-cyan-200\\/80', 
            { y: 30, opacity: 0 }, 
            { y: 0, opacity: 1, duration: 0.8, delay: 0.2, ease: "power2.out" }
        );

        // Content animations
        gsap.fromTo('.bg-white\\/5', 
            { y: 30, opacity: 0 }, 
            { y: 0, opacity: 1, duration: 0.8, delay: 0.4, ease: "power2.out" }
        );

        // Floating background elements
        gsap.to('.absolute.-top-40', { y: -20, x: 20, duration: 8, repeat: -1, yoyo: true, ease: "power1.inOut" });
        gsap.to('.absolute.-bottom-40', { y: 20, x: -20, duration: 10, repeat: -1, yoyo: true, ease: "power1.inOut" });
        gsap.to('.absolute.top-1\\/2', { y: -30, x: 30, duration: 12, repeat: -1, yoyo: true, ease: "power1.inOut" });
    });

    // Contact management functionality
    let contactToDelete = null;

    // Update contact status
    function updateStatus(contactId, newStatus) {
        fetch(`/admin/contacts/${contactId}/status`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ status: newStatus })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error updating status');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error updating status');
        });
    }

    // Delete contact
    function deleteContact(contactId) {
        contactToDelete = contactId;
        document.getElementById('delete-modal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('delete-modal').classList.add('hidden');
        contactToDelete = null;
    }

    function confirmDelete() {
        if (!contactToDelete) return;

        fetch(`/admin/contacts/${contactToDelete}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = '{{ route("admin.contacts.index") }}';
            } else {
                alert('Error deleting contact');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error deleting contact');
        });
    }

    // Utility functions
    function copyEmail() {
        const email = '{{ $contact->email }}';
        navigator.clipboard.writeText(email).then(() => {
            alert('Email address copied to clipboard!');
        }).catch(() => {
            // Fallback for older browsers
            const textArea = document.createElement('textarea');
            textArea.value = email;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
            alert('Email address copied to clipboard!');
        });
    }

    function copyMessage() {
        const message = '{{ $contact->message }}';
        navigator.clipboard.writeText(message).then(() => {
            alert('Message copied to clipboard!');
        }).catch(() => {
            // Fallback for older browsers
            const textArea = document.createElement('textarea');
            textArea.value = message;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
            alert('Message copied to clipboard!');
        });
    }
</script>
@endpush
