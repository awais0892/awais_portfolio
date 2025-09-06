@extends('layouts.admin')

@section('title', 'Comments & Ratings Management')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 relative overflow-hidden">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-cyan-500/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-purple-500/10 rounded-full blur-3xl animate-pulse delay-1000"></div>
    </div>

    <!-- Content Container -->
    <div class="relative z-10 container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-4xl font-bold bg-gradient-to-r from-cyan-400 via-purple-400 to-pink-400 bg-clip-text text-transparent">
                    Comments & Ratings Management
                </h1>
                <p class="text-cyan-200/80 mt-2">Manage user comments and ratings</p>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-blue-500/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-comments text-blue-400 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-white">{{ $comments->total() }}</h3>
                        <p class="text-cyan-300/70">Total Comments</p>
                    </div>
                </div>
            </div>

            <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-yellow-500/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-star text-yellow-400 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-white">{{ $ratings->total() }}</h3>
                        <p class="text-cyan-300/70">Total Ratings</p>
                    </div>
                </div>
            </div>

            <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-orange-500/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-clock text-orange-400 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-white">{{ $comments->where('is_approved', false)->count() + $ratings->where('is_approved', false)->count() }}</h3>
                        <p class="text-cyan-300/70">Pending Approval</p>
                    </div>
                </div>
            </div>

            <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-green-500/20 rounded-xl flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-400 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-white">{{ $comments->where('is_approved', true)->count() + $ratings->where('is_approved', true)->count() }}</h3>
                        <p class="text-cyan-300/70">Approved</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6">
            <div class="flex space-x-1 mb-6">
                <button id="comments-tab" class="tab-button active px-6 py-3 rounded-xl font-semibold transition-all duration-300">
                    Comments ({{ $comments->total() }})
                </button>
                <button id="ratings-tab" class="tab-button px-6 py-3 rounded-xl font-semibold transition-all duration-300">
                    Ratings ({{ $ratings->total() }})
                </button>
            </div>

            <!-- Comments Tab -->
            <div id="comments-content" class="tab-content">
                <div class="space-y-4">
                    @forelse($comments as $comment)
                        <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl p-6">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <div class="w-8 h-8 bg-gradient-to-r from-cyan-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                                            {{ $comment->initials }}
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-white">{{ $comment->name }}</h4>
                                            <p class="text-sm text-cyan-300/70">{{ $comment->email }}</p>
                                        </div>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $comment->is_approved ? 'bg-green-500/20 text-green-300' : 'bg-orange-500/20 text-orange-300' }}">
                                            {{ $comment->is_approved ? 'Approved' : 'Pending' }}
                                        </span>
                                    </div>
                                    
                                    <p class="text-cyan-200/90 mb-3">{{ $comment->content }}</p>
                                    
                                    <div class="flex items-center gap-4 text-sm text-cyan-300/70">
                                        <span><i class="fas fa-calendar mr-1"></i>{{ $comment->formatted_date }}</span>
                                        <span><i class="fas fa-link mr-1"></i>{{ class_basename($comment->commentable_type) }} #{{ $comment->commentable_id }}</span>
                                        @if($comment->parent_id)
                                            <span><i class="fas fa-reply mr-1"></i>Reply to comment #{{ $comment->parent_id }}</span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="flex items-center gap-2 ml-4">
                                    @if(!$comment->is_approved)
                                        <button onclick="approveComment({{ $comment->id }})" 
                                                class="px-3 py-1 bg-green-500/20 text-green-300 rounded-lg hover:bg-green-500/30 transition-colors text-sm">
                                            <i class="fas fa-check mr-1"></i>Approve
                                        </button>
                                    @endif
                                    <button onclick="rejectComment({{ $comment->id }})" 
                                            class="px-3 py-1 bg-red-500/20 text-red-300 rounded-lg hover:bg-red-500/30 transition-colors text-sm">
                                        <i class="fas fa-times mr-1"></i>{{ $comment->is_approved ? 'Reject' : 'Delete' }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <div class="text-4xl text-purple-400/50 mb-4">
                                <i class="fas fa-comment-slash"></i>
                            </div>
                            <h3 class="text-xl font-bold text-white mb-2">No Comments Found</h3>
                            <p class="text-cyan-200/80">No comments have been submitted yet.</p>
                        </div>
                    @endforelse
                </div>
                
                <!-- Comments Pagination -->
                @if($comments->hasPages())
                    <div class="mt-6">
                        {{ $comments->links() }}
                    </div>
                @endif
            </div>

            <!-- Ratings Tab -->
            <div id="ratings-content" class="tab-content hidden">
                <div class="space-y-4">
                    @forelse($ratings as $rating)
                        <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl p-6">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <div class="w-8 h-8 bg-gradient-to-r from-yellow-500 to-orange-600 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                                            {{ $rating->initials }}
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-white">{{ $rating->name }}</h4>
                                            <p class="text-sm text-cyan-300/70">{{ $rating->email }}</p>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            {!! $rating->stars_html !!}
                                        </div>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $rating->is_approved ? 'bg-green-500/20 text-green-300' : 'bg-orange-500/20 text-orange-300' }}">
                                            {{ $rating->is_approved ? 'Approved' : 'Pending' }}
                                        </span>
                                    </div>
                                    
                                    @if($rating->review)
                                        <p class="text-cyan-200/90 mb-3">{{ $rating->review }}</p>
                                    @endif
                                    
                                    <div class="flex items-center gap-4 text-sm text-cyan-300/70">
                                        <span><i class="fas fa-calendar mr-1"></i>{{ $rating->formatted_date }}</span>
                                        <span><i class="fas fa-link mr-1"></i>{{ class_basename($rating->rateable_type) }} #{{ $rating->rateable_id }}</span>
                                    </div>
                                </div>
                                
                                <div class="flex items-center gap-2 ml-4">
                                    @if(!$rating->is_approved)
                                        <button onclick="approveRating({{ $rating->id }})" 
                                                class="px-3 py-1 bg-green-500/20 text-green-300 rounded-lg hover:bg-green-500/30 transition-colors text-sm">
                                            <i class="fas fa-check mr-1"></i>Approve
                                        </button>
                                    @endif
                                    <button onclick="rejectRating({{ $rating->id }})" 
                                            class="px-3 py-1 bg-red-500/20 text-red-300 rounded-lg hover:bg-red-500/30 transition-colors text-sm">
                                        <i class="fas fa-times mr-1"></i>{{ $rating->is_approved ? 'Reject' : 'Delete' }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <div class="text-4xl text-yellow-400/50 mb-4">
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <h3 class="text-xl font-bold text-white mb-2">No Ratings Found</h3>
                            <p class="text-cyan-200/80">No ratings have been submitted yet.</p>
                        </div>
                    @endforelse
                </div>
                
                <!-- Ratings Pagination -->
                @if($ratings->hasPages())
                    <div class="mt-6">
                        {{ $ratings->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab switching
    const commentsTab = document.getElementById('comments-tab');
    const ratingsTab = document.getElementById('ratings-tab');
    const commentsContent = document.getElementById('comments-content');
    const ratingsContent = document.getElementById('ratings-content');

    commentsTab.addEventListener('click', function() {
        commentsTab.classList.add('active');
        ratingsTab.classList.remove('active');
        commentsContent.classList.remove('hidden');
        ratingsContent.classList.add('hidden');
    });

    ratingsTab.addEventListener('click', function() {
        ratingsTab.classList.add('active');
        commentsTab.classList.remove('active');
        ratingsContent.classList.remove('hidden');
        commentsContent.classList.add('hidden');
    });
});

// Comment management functions
function approveComment(commentId) {
    if (confirm('Are you sure you want to approve this comment?')) {
        fetch(`/admin/comments/${commentId}/approve`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                location.reload();
            } else {
                showNotification(data.message || 'Failed to approve comment', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('An error occurred while approving the comment', 'error');
        });
    }
}

function rejectComment(commentId) {
    if (confirm('Are you sure you want to reject/delete this comment?')) {
        fetch(`/admin/comments/${commentId}/reject`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                location.reload();
            } else {
                showNotification(data.message || 'Failed to reject comment', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('An error occurred while rejecting the comment', 'error');
        });
    }
}

function approveRating(ratingId) {
    if (confirm('Are you sure you want to approve this rating?')) {
        fetch(`/admin/ratings/${ratingId}/approve`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                location.reload();
            } else {
                showNotification(data.message || 'Failed to approve rating', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('An error occurred while approving the rating', 'error');
        });
    }
}

function rejectRating(ratingId) {
    if (confirm('Are you sure you want to reject/delete this rating?')) {
        fetch(`/admin/ratings/${ratingId}/reject`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                location.reload();
            } else {
                showNotification(data.message || 'Failed to reject rating', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('An error occurred while rejecting the rating', 'error');
        });
    }
}

function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-xl shadow-lg backdrop-blur-sm transition-all duration-300 transform translate-x-full ${
        type === 'success' ? 'bg-green-500/90 text-white border border-green-400/30' : 'bg-red-500/90 text-white border border-red-400/30'
    }`;
    notification.innerHTML = `
        <div class="flex items-center gap-3">
            <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);
    
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 5000);
}
</script>

<style>
.tab-button {
    background: rgba(255, 255, 255, 0.05);
    color: #94a3b8;
}

.tab-button.active {
    background: linear-gradient(90deg, #06b6d4, #8b5cf6);
    color: white;
}

.tab-button:hover {
    background: rgba(255, 255, 255, 0.1);
    color: white;
}

.tab-button.active:hover {
    background: linear-gradient(90deg, #0891b2, #7c3aed);
}
</style>
@endsection
