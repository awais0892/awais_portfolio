@extends('layouts.app')

@section('title', 'Contact Messages - Admin')
@section('page-title', 'Contact Messages')

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
                    Contact Messages
                </h1>
                <p class="text-cyan-200/80">Manage and respond to contact form submissions</p>
            </div>
            
            <div class="flex gap-3">
                <a href="{{ route('admin.dashboard') }}" 
                   class="px-4 py-2 bg-gradient-to-r from-cyan-500 to-blue-600 text-white font-semibold rounded-xl hover:from-cyan-600 hover:to-blue-700 transition-all duration-300 transform hover:scale-105">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Dashboard
                </a>
            </div>
        </div>

        <!-- Search and Filter Section -->
        <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6 mb-8">
            <form method="GET" action="{{ route('admin.contacts.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Search Input -->
                    <div>
                        <input type="text" name="search" placeholder="Search messages..." 
                               value="{{ request('search') }}"
                               class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-cyan-300/50 focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300">
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <select name="status" class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300">
                            <option value="">All Status</option>
                            <option value="unread" {{ request('status') === 'unread' ? 'selected' : '' }}>Unread</option>
                            <option value="read" {{ request('status') === 'read' ? 'selected' : '' }}>Read</option>
                            <option value="replied" {{ request('status') === 'replied' ? 'selected' : '' }}>Replied</option>
                        </select>
                    </div>

                    <!-- Search Button -->
                    <div>
                        <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-cyan-500 to-purple-600 text-white font-bold rounded-xl hover:from-cyan-600 hover:to-purple-700 transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-search mr-2"></i>
                            Search
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Messages Table -->
        <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-white/10">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-cyan-300 uppercase tracking-wider">
                                <input type="checkbox" id="select-all" class="rounded border-white/20 bg-white/10 text-cyan-400 focus:ring-cyan-400">
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-cyan-300 uppercase tracking-wider">Contact</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-cyan-300 uppercase tracking-wider">Subject</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-cyan-300 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-cyan-300 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-cyan-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/10">
                        @forelse($contacts as $contact)
                            <tr class="hover:bg-white/5 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="checkbox" name="selected_contacts[]" value="{{ $contact->id }}" 
                                           class="contact-checkbox rounded border-white/20 bg-white/10 text-cyan-400 focus:ring-cyan-400">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div>
                                        <div class="text-sm font-medium text-white">{{ $contact->name }}</div>
                                        <div class="text-sm text-cyan-300">{{ $contact->email }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-white max-w-xs truncate">{{ $contact->subject }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                        {{ $contact->status === 'unread' ? 'bg-red-500/20 text-red-300' : 
                                           ($contact->status === 'read' ? 'bg-blue-500/20 text-blue-300' : 'bg-green-500/20 text-green-300') }}">
                                        {{ ucfirst($contact->status ?? 'new') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-cyan-300">
                                    {{ $contact->created_at->format('M d, Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.contacts.show', $contact) }}" 
                                           class="text-cyan-400 hover:text-cyan-300 transition-colors">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button onclick="updateStatus('{{ $contact->id }}', '{{ $contact->status === 'unread' ? 'read' : 'unread' }}')" 
                                                class="text-blue-400 hover:text-blue-300 transition-colors">
                                            <i class="fas fa-{{ $contact->status === 'unread' ? 'check' : 'undo' }}"></i>
                                        </button>
                                        <button onclick="deleteContact('{{ $contact->id }}')" 
                                                class="text-red-400 hover:text-red-300 transition-colors">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="text-6xl text-purple-400/50 mb-4">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <h3 class="text-xl font-bold text-white mb-2">No Contact Messages</h3>
                                    <p class="text-cyan-200/80">No contact form submissions found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Bulk Actions -->
            @if($contacts->count() > 0)
                <div class="px-6 py-4 bg-white/5 border-t border-white/10">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-cyan-300">
                            <span id="selected-count">0</span> messages selected
                        </div>
                        <div class="flex gap-3">
                            <button onclick="bulkUpdateStatus('read')" 
                                    class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                                <i class="fas fa-check mr-2"></i>
                                Mark as Read
                            </button>
                            <button onclick="bulkUpdateStatus('unread')" 
                                    class="px-4 py-2 bg-yellow-600 text-white text-sm font-semibold rounded-lg hover:bg-yellow-700 transition-colors">
                                <i class="fas fa-undo mr-2"></i>
                                Mark as Unread
                            </button>
                            <button onclick="bulkDelete()" 
                                    class="px-4 py-2 bg-red-600 text-white text-sm font-semibold rounded-lg hover:bg-red-700 transition-colors">
                                <i class="fas fa-trash mr-2"></i>
                                Delete Selected
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Pagination -->
        @if($contacts->hasPages())
            <div class="flex justify-center mt-8">
                {{ $contacts->appends(request()->query())->links('components.pagination') }}
            </div>
        @endif
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

        // Search and filter section animation
        gsap.fromTo('.bg-white\\/5', 
            { y: 30, opacity: 0 }, 
            { y: 0, opacity: 1, duration: 0.8, delay: 0.4, ease: "power2.out" }
        );

        // Table animation
        gsap.fromTo('tbody tr', 
            { y: 20, opacity: 0 }, 
            { 
                y: 0, 
                opacity: 1, 
                duration: 0.6, 
                stagger: 0.05, 
                delay: 0.6,
                ease: "power2.out"
            }
        );

        // Floating background elements
        gsap.to('.absolute.-top-40', { y: -20, x: 20, duration: 8, repeat: -1, yoyo: true, ease: "power1.inOut" });
        gsap.to('.absolute.-bottom-40', { y: 20, x: -20, duration: 10, repeat: -1, yoyo: true, ease: "power1.inOut" });
        gsap.to('.absolute.top-1\\/2', { y: -30, x: 30, duration: 12, repeat: -1, yoyo: true, ease: "power1.inOut" });
    });

    // Contact management functionality
    let contactToDelete = null;

    // Select all functionality
    document.getElementById('select-all')?.addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.contact-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateSelectedCount();
    });

    // Update selected count
    document.querySelectorAll('.contact-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', updateSelectedCount);
    });

    function updateSelectedCount() {
        const selectedCount = document.querySelectorAll('.contact-checkbox:checked').length;
        document.getElementById('selected-count').textContent = selectedCount;
    }

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
                location.reload();
            } else {
                alert('Error deleting contact');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error deleting contact');
        });
    }

    // Bulk operations
    function bulkUpdateStatus(newStatus) {
        const selectedIds = Array.from(document.querySelectorAll('.contact-checkbox:checked'))
            .map(checkbox => checkbox.value);

        if (selectedIds.length === 0) {
            alert('Please select contacts to update');
            return;
        }

        const promises = selectedIds.map(id => 
            fetch(`/admin/contacts/${id}/status`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ status: newStatus })
            })
        );

        Promise.all(promises)
            .then(() => location.reload())
            .catch(error => {
                console.error('Error:', error);
                alert('Error updating contacts');
            });
    }

    function bulkDelete() {
        const selectedIds = Array.from(document.querySelectorAll('.contact-checkbox:checked'))
            .map(checkbox => checkbox.value);

        if (selectedIds.length === 0) {
            alert('Please select contacts to delete');
            return;
        }

        if (!confirm(`Are you sure you want to delete ${selectedIds.length} contact messages?`)) {
            return;
        }

        fetch('/admin/contacts/bulk-delete', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ ids: selectedIds })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error deleting contacts');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error deleting contacts');
        });
    }
</script>
@endpush
