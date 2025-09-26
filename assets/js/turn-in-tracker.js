// Turn-In Tracker JavaScript
jQuery(document).ready(function($) {
    
    // Handle reset progress button
    $('.reset-progress-btn').on('click', function() {
        const shopId = $(this).data('shop-id');
        const tracker = $(this).closest('.turn-in-tracker');
        
        // Confirmation dialog
        if (!confirm('Are you sure you want to reset ALL turn-in progress for this shop? This action cannot be undone.')) {
            return;
        }
        
        // Show loading state
        $(this).prop('disabled', true).text('Resetting...');
        
        // AJAX request to reset progress
        $.ajax({
            url: turnInTracker.ajax_url,
            type: 'POST',
            data: {
                action: 'reset_turn_in_progress',
                shop_id: shopId,
                nonce: turnInTracker.nonce
            },
            success: function(response) {
                if (response.success) {
                    // Show success message
                    showMessage(tracker, 'Progress reset successfully!', 'success');
                    
                    // Reset all progress bars and text
                    tracker.find('.turn-in-item').removeClass('completed');
                    tracker.find('.progress-fill').css('width', '0%');
                    tracker.find('.progress-text').text('0 / [goal]');
                    tracker.find('.completion-badge').remove();
                    
                    // Update progress text with actual goals
                    tracker.find('.turn-in-item').each(function() {
                        const progressText = $(this).find('.progress-text');
                        const currentText = progressText.text();
                        const goalMatch = currentText.match(/\/ (\d+)/);
                        if (goalMatch) {
                            progressText.text('0 / ' + goalMatch[1]);
                        }
                    });
                    
                    setTimeout(() => {
                        location.reload(); // Reload to get fresh data
                    }, 1500);
                    
                } else {
                    showMessage(tracker, 'Failed to reset progress: ' + (response.data || 'Unknown error'), 'error');
                }
            },
            error: function() {
                showMessage(tracker, 'Network error occurred while resetting progress', 'error');
            },
            complete: function() {
                $('.reset-progress-btn').prop('disabled', false).text('Reset All Progress');
            }
        });
    });
    
    // Function to show messages
    function showMessage(container, message, type) {
        const messageDiv = $('<div class="tracker-message ' + type + '">' + message + '</div>');
        messageDiv.css({
            'padding': '10px',
            'margin': '10px 0',
            'border-radius': '4px',
            'background': type === 'success' ? '#d4edda' : '#f8d7da',
            'color': type === 'success' ? '#155724' : '#721c24',
            'border': '1px solid ' + (type === 'success' ? '#c3e6cb' : '#f5c6cb')
        });
        
        container.prepend(messageDiv);
        
        // Auto-remove after 3 seconds
        setTimeout(() => {
            messageDiv.fadeOut(500, function() {
                $(this).remove();
            });
        }, 3000);
    }
    
    // Add auto-refresh functionality (optional)
    setInterval(function() {
        // Auto-refresh every 30 seconds if user is active
        if (document.hasFocus() && $('.turn-in-tracker').length > 0) {
            // Could add auto-refresh logic here if needed
        }
    }, 30000);
    
});