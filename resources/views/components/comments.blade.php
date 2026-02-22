{{-- Comments Section Component --}}
<div class="comments-section" data-commentable-type="{{ $commentableType }}" data-commentable-id="{{ $commentableId }}">
    <!-- Comments Header -->
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-2xl font-bold text-white flex items-center gap-2">
            <i class="fas fa-comments text-cyan-400"></i>
            Comments
            <span class="text-sm text-cyan-300/70 comment-count">(0)</span>
        </h3>
    </div>

    <!-- Comment Form -->
    <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6 mb-8">
        <h4 class="text-lg font-semibold text-white mb-4">Leave a Comment</h4>
        <form id="comment-form" class="space-y-4">
            @csrf
            <input type="hidden" name="commentable_type" value="{{ $commentableType }}">
            <input type="hidden" name="commentable_id" value="{{ $commentableId }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="comment_name" class="block text-sm font-medium text-cyan-300 mb-2">Name *</label>
                    <input type="text" id="comment_name" name="name" required
                        class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-cyan-300/50 focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300">
                </div>
                <div>
                    <label for="comment_email" class="block text-sm font-medium text-cyan-300 mb-2">Email *</label>
                    <input type="email" id="comment_email" name="email" required
                        class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-cyan-300/50 focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300">
                </div>
            </div>

            <div>
                <label for="comment_content" class="block text-sm font-medium text-cyan-300 mb-2">Comment *</label>
                <textarea id="comment_content" name="content" rows="4" required
                    class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-cyan-300/50 focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300 resize-none"
                    placeholder="Share your thoughts..."></textarea>
            </div>

            <div class="flex items-center justify-between">
                <div class="text-sm text-cyan-300/70">
                    <i class="fas fa-info-circle mr-1"></i>
                    Comments are moderated and will appear after approval
                </div>
                <button type="submit"
                    class="px-6 py-3 bg-gradient-to-r from-cyan-500 to-purple-600 text-white font-semibold rounded-xl hover:from-cyan-600 hover:to-purple-700 transition-all duration-300 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Post Comment
                </button>
            </div>
        </form>
    </div>

    <!-- Comments List -->
    <div id="comments-list" class="space-y-6">
        <!-- Comments will be loaded here via AJAX -->
        <div class="text-center py-8">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-cyan-400 mx-auto mb-4"></div>
            <p class="text-cyan-300/70">Loading comments...</p>
        </div>
    </div>

    <!-- Load More Button -->
    <div id="load-more-container" class="text-center mt-8 hidden">
        <button id="load-more-comments"
            class="px-6 py-3 bg-white/10 text-white font-semibold rounded-xl hover:bg-white/20 transition-all duration-300">
            <i class="fas fa-chevron-down mr-2"></i>
            Load More Comments
        </button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const commentsSection = document.querySelector('.comments-section');
        const commentForm = document.getElementById('comment-form');
        const commentsList = document.getElementById('comments-list');
        const commentCount = document.querySelector('.comment-count');
        const loadMoreBtn = document.getElementById('load-more-comments');
        const loadMoreContainer = document.getElementById('load-more-container');

        const commentableType = commentsSection.dataset.commentableType;
        const commentableId = commentsSection.dataset.commentableId;

        let currentPage = 1;
        let isLoading = false;
        let hasMoreComments = true;

        // Load comments on page load
        loadComments();

        // Comment form submission
        commentForm.addEventListener('submit', function (e) {
            e.preventDefault();

            if (isLoading) return;

            const formData = new FormData(commentForm);
            const submitBtn = commentForm.querySelector('button[type="submit"]');

            // Debug: Log form data
            console.log('Comment form data being sent:');
            for (let [key, value] of formData.entries()) {
                console.log(key, value);
            }

            // Debug: Check content specifically
            const contentField = document.getElementById('comment_content');
            console.log('Content field value:', contentField ? contentField.value : 'NOT FOUND');
            console.log('Content length:', contentField ? contentField.value.length : 'N/A');

            // Disable form
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Posting...';

            fetch('{{ route("api.comments.store") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
                .then(response => {
                    console.log('Comment response status:', response.status);
                    return response.json();
                })
                .then(data => {
                    console.log('Comment response data:', data);
                    if (data.success) {
                        // Show success message
                        showNotification(data.message, 'success');

                        // Reset form
                        commentForm.reset();

                        // Reload comments
                        loadComments();
                    } else {
                        if (data.errors) {
                            console.error('Comment validation errors:', data.errors);
                            let errorMsg = data.message || 'Validation failed';
                            if (data.errors.content) errorMsg = data.errors.content[0];
                            showNotification(errorMsg, 'error');
                        } else {
                            showNotification(data.message || 'Failed to post comment', 'error');
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('An error occurred while posting your comment', 'error');
                })
                .finally(() => {
                    // Re-enable form
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-paper-plane mr-2"></i>Post Comment';
                });
        });

        // Load more comments
        if (loadMoreBtn) {
            loadMoreBtn.addEventListener('click', function () {
                if (!isLoading && hasMoreComments) {
                    currentPage++;
                    loadComments();
                }
            });
        }

        function loadComments() {
            if (isLoading) return;

            isLoading = true;

            fetch(`{{ route("api.comments.index") }}?commentable_type=${commentableType}&commentable_id=${commentableId}&page=${currentPage}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (currentPage === 1) {
                            commentsList.innerHTML = '';
                        }

                        if (data.comments.length > 0) {
                            data.comments.forEach(comment => {
                                commentsList.appendChild(createCommentElement(comment));
                            });
                        } else if (currentPage === 1) {
                            commentsList.innerHTML = `
                        <div class="text-center py-8">
                            <div class="text-4xl text-purple-400/50 mb-4">
                                <i class="fas fa-comment-slash"></i>
                            </div>
                            <h4 class="text-lg font-semibold text-white mb-2">No Comments Yet</h4>
                            <p class="text-cyan-200/80">Be the first to share your thoughts!</p>
                        </div>
                    `;
                        }

                        // Update comment count
                        commentCount.textContent = `(${data.total})`;

                        // Show/hide load more button
                        hasMoreComments = data.comments.length >= 10; // Assuming 10 comments per page
                        if (hasMoreComments && data.comments.length > 0) {
                            loadMoreContainer.classList.remove('hidden');
                        } else {
                            loadMoreContainer.classList.add('hidden');
                        }
                    }
                })
                .catch(error => {
                    console.error('Error loading comments:', error);
                    if (currentPage === 1) {
                        commentsList.innerHTML = `
                    <div class="text-center py-8">
                        <div class="text-4xl text-red-400/50 mb-4">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <h4 class="text-lg font-semibold text-white mb-2">Error Loading Comments</h4>
                        <p class="text-cyan-200/80">Please try refreshing the page</p>
                    </div>
                `;
                    }
                })
                .finally(() => {
                    isLoading = false;
                });
        }

        function createCommentElement(comment) {
            const commentDiv = document.createElement('div');
            commentDiv.className = 'comment-item bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl p-6';
            commentDiv.innerHTML = `
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 bg-gradient-to-r from-cyan-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                    ${comment.initials}
                </div>
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2">
                        <h5 class="font-semibold text-white">${comment.name}</h5>
                        <span class="text-sm text-cyan-300/70">${comment.formatted_date}</span>
                    </div>
                    <p class="text-cyan-200/90 leading-relaxed mb-3">${comment.content}</p>
                    <button class="reply-btn text-sm text-cyan-400 hover:text-cyan-300 transition-colors" data-comment-id="${comment.id}">
                        <i class="fas fa-reply mr-1"></i>
                        Reply
                    </button>
                </div>
            </div>
            ${comment.replies && comment.replies.length > 0 ? `
                <div class="replies ml-14 mt-4 space-y-4">
                    ${comment.replies.map(reply => `
                        <div class="reply-item bg-white/5 backdrop-blur-sm border border-white/10 rounded-lg p-4">
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 bg-gradient-to-r from-purple-500 to-pink-600 rounded-full flex items-center justify-center text-white font-semibold text-xs">
                                    ${reply.initials}
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <h6 class="font-medium text-white text-sm">${reply.name}</h6>
                                        <span class="text-xs text-cyan-300/70">${reply.formatted_date}</span>
                                    </div>
                                    <p class="text-cyan-200/90 text-sm leading-relaxed">${reply.content}</p>
                                </div>
                            </div>
                        </div>
                    `).join('')}
                </div>
            ` : ''}
        `;

            // Add reply functionality
            const replyBtn = commentDiv.querySelector('.reply-btn');
            if (replyBtn) {
                replyBtn.addEventListener('click', function () {
                    showReplyForm(comment.id, commentDiv);
                });
            }

            return commentDiv;
        }

        function showReplyForm(parentId, commentElement) {
            const existingForm = commentElement.querySelector('.reply-form');
            if (existingForm) {
                existingForm.remove();
                return;
            }

            const replyForm = document.createElement('div');
            replyForm.className = 'reply-form ml-14 mt-4 bg-white/5 backdrop-blur-sm border border-white/10 rounded-lg p-4';
            replyForm.innerHTML = `
            <h6 class="text-sm font-semibold text-white mb-3">Reply to ${commentElement.querySelector('h5').textContent}</h6>
            <form class="space-y-3">
                <input type="hidden" name="parent_id" value="${parentId}">
                <input type="hidden" name="commentable_type" value="${commentableType}">
                <input type="hidden" name="commentable_id" value="${commentableId}">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <input type="text" name="name" placeholder="Your name" required
                           class="w-full bg-white/10 border border-white/20 rounded-lg px-3 py-2 text-white placeholder-cyan-300/50 focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300 text-sm">
                    <input type="email" name="email" placeholder="Your email" required
                           class="w-full bg-white/10 border border-white/20 rounded-lg px-3 py-2 text-white placeholder-cyan-300/50 focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300 text-sm">
                </div>
                
                <textarea name="content" rows="3" placeholder="Write your reply..." required
                          class="w-full bg-white/10 border border-white/20 rounded-lg px-3 py-2 text-white placeholder-cyan-300/50 focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300 resize-none text-sm"></textarea>
                
                <div class="flex items-center justify-end gap-2">
                    <button type="button" class="cancel-reply px-4 py-2 text-sm text-cyan-300 hover:text-cyan-200 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-gradient-to-r from-cyan-500 to-purple-600 text-white font-semibold rounded-lg hover:from-cyan-600 hover:to-purple-700 transition-all duration-300 text-sm">
                        <i class="fas fa-paper-plane mr-1"></i>
                        Reply
                    </button>
                </div>
            </form>
        `;

            commentElement.appendChild(replyForm);

            // Handle reply form submission
            const form = replyForm.querySelector('form');
            form.addEventListener('submit', function (e) {
                e.preventDefault();

                const formData = new FormData(form);
                const submitBtn = form.querySelector('button[type="submit"]');

                // Debug: Log reply form data
                console.log('Reply form data being sent:');
                for (let [key, value] of formData.entries()) {
                    console.log(key, value);
                }

                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i>Replying...';

                fetch('{{ route("api.comments.store") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showNotification(data.message, 'success');
                            replyForm.remove();
                            loadComments(); // Reload to show the new reply
                        } else {
                            console.error('Reply validation errors:', data.errors);
                            let errorMsg = data.message || 'Failed to post reply';
                            if (data.errors && data.errors.content) errorMsg = data.errors.content[0];
                            showNotification(errorMsg, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('An error occurred while posting your reply', 'error');
                    })
                    .finally(() => {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = '<i class="fas fa-paper-plane mr-1"></i>Reply';
                    });
            });

            // Handle cancel
            const cancelBtn = replyForm.querySelector('.cancel-reply');
            cancelBtn.addEventListener('click', function () {
                replyForm.remove();
            });
        }

        function showNotification(message, type) {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-xl shadow-lg backdrop-blur-sm transition-all duration-300 transform translate-x-full ${type === 'success' ? 'bg-green-500/90 text-white border border-green-400/30' : 'bg-red-500/90 text-white border border-red-400/30'
                }`;
            notification.innerHTML = `
            <div class="flex items-center gap-3">
                <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
                <span>${message}</span>
            </div>
        `;

            document.body.appendChild(notification);

            // Animate in
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 100);

            // Remove after 5 seconds
            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 5000);
        }
    });
</script>