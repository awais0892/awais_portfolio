{{-- Rating Section Component --}}
<div class="rating-section" data-rateable-type="{{ $rateableType }}" data-rateable-id="{{ $rateableId }}">
    <!-- Rating Header -->
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-2xl font-bold text-white flex items-center gap-2">
            <i class="fas fa-star text-yellow-400"></i>
            Ratings & Reviews
        </h3>
    </div>

    <!-- Rating Stats -->
    <div id="rating-stats" class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Overall Rating -->
            <div class="text-center">
                <div class="text-4xl font-bold text-white mb-2">
                    <span id="average-rating">0.0</span>
                </div>
                <div id="stars-display" class="text-2xl mb-2">
                    <i class="far fa-star text-gray-400"></i>
                    <i class="far fa-star text-gray-400"></i>
                    <i class="far fa-star text-gray-400"></i>
                    <i class="far fa-star text-gray-400"></i>
                    <i class="far fa-star text-gray-400"></i>
                </div>
                <p class="text-cyan-300/70">
                    <span id="total-ratings">0</span> rating<span id="total-ratings-plural">s</span>
                </p>
            </div>

            <!-- Rating Distribution -->
            <div class="space-y-2">
                <h4 class="text-lg font-semibold text-white mb-4">Rating Distribution</h4>
                <div id="rating-distribution" class="space-y-2">
                    <!-- Distribution bars will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Rating Form -->
    <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6 mb-8">
        <h4 class="text-lg font-semibold text-white mb-4">Rate This Item</h4>
        <form id="rating-form" class="space-y-4">
            @csrf
            <input type="hidden" name="rateable_type" value="{{ $rateableType }}">
            <input type="hidden" name="rateable_id" value="{{ $rateableId }}">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="rating_name" class="block text-sm font-medium text-cyan-300 mb-2">Name *</label>
                    <input type="text" id="rating_name" name="name" required
                           class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-cyan-300/50 focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300">
                </div>
                <div>
                    <label for="rating_email" class="block text-sm font-medium text-cyan-300 mb-2">Email *</label>
                    <input type="email" id="rating_email" name="email" required
                           class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-cyan-300/50 focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300">
                </div>
            </div>
            
            <!-- Star Rating -->
            <div>
                <label class="block text-sm font-medium text-cyan-300 mb-2">Rating *</label>
                <div class="flex items-center gap-2">
                    <div id="star-rating" class="flex items-center gap-1">
                        <i class="far fa-star text-3xl text-gray-400 cursor-pointer hover:text-yellow-400 transition-colors" data-rating="1"></i>
                        <i class="far fa-star text-3xl text-gray-400 cursor-pointer hover:text-yellow-400 transition-colors" data-rating="2"></i>
                        <i class="far fa-star text-3xl text-gray-400 cursor-pointer hover:text-yellow-400 transition-colors" data-rating="3"></i>
                        <i class="far fa-star text-3xl text-gray-400 cursor-pointer hover:text-yellow-400 transition-colors" data-rating="4"></i>
                        <i class="far fa-star text-3xl text-gray-400 cursor-pointer hover:text-yellow-400 transition-colors" data-rating="5"></i>
                    </div>
                    <span id="rating-text" class="text-cyan-300/70 ml-3">Click to rate</span>
                </div>
                <input type="hidden" name="rating" id="rating_value" value="0" required>
            </div>
            
            <div>
                <label for="rating_review" class="block text-sm font-medium text-cyan-300 mb-2">Review (Optional)</label>
                <textarea id="rating_review" name="review" rows="4"
                          class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-cyan-300/50 focus:ring-2 focus:ring-cyan-400 focus:border-transparent backdrop-blur-sm transition-all duration-300 resize-none"
                          placeholder="Share your detailed review..."></textarea>
            </div>
            
            <div class="flex items-center justify-between">
                <div class="text-sm text-cyan-300/70">
                    <i class="fas fa-info-circle mr-1"></i>
                    Ratings are moderated and will appear after approval
                </div>
                <button type="submit" 
                        class="px-6 py-3 bg-gradient-to-r from-yellow-500 to-orange-600 text-white font-semibold rounded-xl hover:from-yellow-600 hover:to-orange-700 transition-all duration-300 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed">
                    <i class="fas fa-star mr-2"></i>
                    Submit Rating
                </button>
            </div>
        </form>
    </div>

    <!-- Ratings List -->
    <div id="ratings-list" class="space-y-6">
        <!-- Ratings will be loaded here via AJAX -->
        <div class="text-center py-8">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-yellow-400 mx-auto mb-4"></div>
            <p class="text-cyan-300/70">Loading ratings...</p>
        </div>
    </div>

    <!-- Load More Button -->
    <div id="load-more-ratings-container" class="text-center mt-8 hidden">
        <button id="load-more-ratings" 
                class="px-6 py-3 bg-white/10 text-white font-semibold rounded-xl hover:bg-white/20 transition-all duration-300">
            <i class="fas fa-chevron-down mr-2"></i>
            Load More Reviews
        </button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ratingSection = document.querySelector('.rating-section');
    const ratingForm = document.getElementById('rating-form');
    const ratingsList = document.getElementById('ratings-list');
    const loadMoreBtn = document.getElementById('load-more-ratings');
    const loadMoreContainer = document.getElementById('load-more-ratings-container');
    
    const rateableType = ratingSection.dataset.rateableType;
    const rateableId = ratingSection.dataset.rateableId;
    
    let currentPage = 1;
    let isLoading = false;
    let hasMoreRatings = true;
    let selectedRating = 0;

    // Load ratings and stats on page load
    loadRatings();
    loadRatingStats();

    // Star rating interaction
    const stars = document.querySelectorAll('#star-rating i');
    const ratingValue = document.getElementById('rating_value');
    const ratingText = document.getElementById('rating_text');
    
    if (stars.length > 0) {
        stars.forEach((star, index) => {
            star.addEventListener('click', function() {
                selectedRating = index + 1;
                updateStarDisplay();
                if (ratingValue) {
                    ratingValue.value = selectedRating;
                }
            });
            
            star.addEventListener('mouseenter', function() {
                highlightStars(index + 1);
            });
        });
        
        const starRatingContainer = document.getElementById('star-rating');
        if (starRatingContainer) {
            starRatingContainer.addEventListener('mouseleave', function() {
                updateStarDisplay();
            });
        }
    }

    function updateStarDisplay() {
        stars.forEach((star, index) => {
            if (index < selectedRating) {
                star.className = 'fas fa-star text-3xl text-yellow-400 cursor-pointer transition-colors';
            } else {
                star.className = 'far fa-star text-3xl text-gray-400 cursor-pointer hover:text-yellow-400 transition-colors';
            }
        });
        
        const ratingTexts = ['', 'Poor', 'Fair', 'Good', 'Very Good', 'Excellent'];
        if (ratingText) {
            ratingText.textContent = selectedRating > 0 ? ratingTexts[selectedRating] : 'Click to rate';
        }
    }

    function highlightStars(rating) {
        stars.forEach((star, index) => {
            if (index < rating) {
                star.className = 'fas fa-star text-3xl text-yellow-400 cursor-pointer transition-colors';
            } else {
                star.className = 'far fa-star text-3xl text-gray-400 cursor-pointer hover:text-yellow-400 transition-colors';
            }
        });
    }

    // Rating form submission
    ratingForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (isLoading) return;
        if (selectedRating === 0) {
            showNotification('Please select a rating', 'error');
            return;
        }
        
        const formData = new FormData(ratingForm);
        const submitBtn = ratingForm.querySelector('button[type="submit"]');
        
        // Debug: Log form data
        console.log('Form data being sent:');
        for (let [key, value] of formData.entries()) {
            console.log(key, value);
        }
        
        // Disable form
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Submitting...';
        
        fetch('{{ route("api.ratings.store") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            console.log('Response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            if (data.success) {
                // Show success message
                showNotification(data.message, 'success');
                
                // Reset form
                ratingForm.reset();
                selectedRating = 0;
                updateStarDisplay();
                
                // Reload ratings and stats
                loadRatings();
                loadRatingStats();
            } else {
                showNotification(data.message || 'Failed to submit rating', 'error');
                if (data.errors) {
                    console.error('Validation errors:', data.errors);
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('An error occurred while submitting your rating', 'error');
        })
        .finally(() => {
            // Re-enable form
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-star mr-2"></i>Submit Rating';
        });
    });

    // Load more ratings
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function() {
            if (!isLoading && hasMoreRatings) {
                currentPage++;
                loadRatings();
            }
        });
    }

    function loadRatings() {
        if (isLoading) return;
        
        isLoading = true;
        
        fetch(`{{ route("api.ratings.index") }}?rateable_type=${rateableType}&rateable_id=${rateableId}&page=${currentPage}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (currentPage === 1) {
                    ratingsList.innerHTML = '';
                }
                
                if (data.ratings.length > 0) {
                    data.ratings.forEach(rating => {
                        ratingsList.appendChild(createRatingElement(rating));
                    });
                } else if (currentPage === 1) {
                    ratingsList.innerHTML = `
                        <div class="text-center py-8">
                            <div class="text-4xl text-yellow-400/50 mb-4">
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <h4 class="text-lg font-semibold text-white mb-2">No Ratings Yet</h4>
                            <p class="text-cyan-200/80">Be the first to rate this item!</p>
                        </div>
                    `;
                }
                
                // Show/hide load more button
                hasMoreRatings = data.ratings.length >= 10; // Assuming 10 ratings per page
                if (hasMoreRatings && data.ratings.length > 0) {
                    loadMoreContainer.classList.remove('hidden');
                } else {
                    loadMoreContainer.classList.add('hidden');
                }
            }
        })
        .catch(error => {
            console.error('Error loading ratings:', error);
            if (currentPage === 1) {
                ratingsList.innerHTML = `
                    <div class="text-center py-8">
                        <div class="text-4xl text-red-400/50 mb-4">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <h4 class="text-lg font-semibold text-white mb-2">Error Loading Ratings</h4>
                        <p class="text-cyan-200/80">Please try refreshing the page</p>
                    </div>
                `;
            }
        })
        .finally(() => {
            isLoading = false;
        });
    }

    function loadRatingStats() {
        fetch(`{{ route("api.ratings.stats") }}?rateable_type=${rateableType}&rateable_id=${rateableId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const stats = data.stats;
                
                // Update average rating
                document.getElementById('average-rating').textContent = stats.average_rating;
                document.getElementById('total-ratings').textContent = stats.total_ratings;
                document.getElementById('total-ratings-plural').textContent = stats.total_ratings !== 1 ? 's' : '';
                
                // Update stars display
                document.getElementById('stars-display').innerHTML = stats.stars_html;
                
                // Update distribution
                const distributionContainer = document.getElementById('rating-distribution');
                distributionContainer.innerHTML = '';
                
                for (let i = 5; i >= 1; i--) {
                    const count = stats.distribution[i] || 0;
                    const percentage = stats.total_ratings > 0 ? (count / stats.total_ratings) * 100 : 0;
                    
                    const distributionItem = document.createElement('div');
                    distributionItem.className = 'flex items-center gap-3';
                    distributionItem.innerHTML = `
                        <div class="flex items-center gap-1 w-16">
                            <span class="text-sm text-cyan-300">${i}</span>
                            <i class="fas fa-star text-yellow-400 text-xs"></i>
                        </div>
                        <div class="flex-1 bg-white/10 rounded-full h-2">
                            <div class="bg-gradient-to-r from-yellow-500 to-orange-500 h-2 rounded-full transition-all duration-500" 
                                 style="width: ${percentage}%"></div>
                        </div>
                        <span class="text-sm text-cyan-300/70 w-8">${count}</span>
                    `;
                    distributionContainer.appendChild(distributionItem);
                }
            }
        })
        .catch(error => {
            console.error('Error loading rating stats:', error);
        });
    }

    function createRatingElement(rating) {
        const ratingDiv = document.createElement('div');
        ratingDiv.className = 'rating-item bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl p-6';
        ratingDiv.innerHTML = `
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 bg-gradient-to-r from-yellow-500 to-orange-600 rounded-full flex items-center justify-center text-white font-semibold text-sm">
                    ${rating.initials}
                </div>
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2">
                        <h5 class="font-semibold text-white">${rating.name}</h5>
                        <div class="flex items-center gap-1">
                            ${rating.stars_html}
                        </div>
                        <span class="text-sm text-cyan-300/70">${rating.formatted_date}</span>
                    </div>
                    ${rating.review ? `<p class="text-cyan-200/90 leading-relaxed">${rating.review}</p>` : ''}
                </div>
            </div>
        `;
        
        return ratingDiv;
    }

    function showNotification(message, type) {
        // Create notification element
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
