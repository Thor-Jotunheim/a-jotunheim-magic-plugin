/**
 * Wiki JavaScript functionality
 */
(function($) {
    'use strict';
    
    $(document).ready(function() {
        // Handle wiki form submission
        $('#jotunheim-wiki-form').on('submit', function(e) {
            e.preventDefault();
            
            var form = $(this);
            var messageContainer = $('#jotunheim-wiki-message');
            var submitButton = form.find('button[type="submit"]');
            
            // Disable submit button and show loading state
            submitButton.prop('disabled', true).text('Saving...');
            
            $.ajax({
                url: jotunheimWiki.ajaxUrl,
                type: 'POST',
                data: form.serialize(),
                success: function(response) {
                    if (response.success) {
                        // Redirect to the wiki page
                        window.location.href = response.data.permalink + '?message=success';
                    } else {
                        // Show error message
                        messageContainer.removeClass('success').addClass('error')
                            .text(response.data).show();
                    }
                },
                error: function() {
                    // Show generic error message
                    messageContainer.removeClass('success').addClass('error')
                        .text('An error occurred while saving. Please try again.').show();
                },
                complete: function() {
                    // Reset button state
                    submitButton.prop('disabled', false).text('Save Changes');
                }
            });
        });
        
        // Handle delete button click
        $('.button-delete').on('click', function() {
            var postId = $(this).data('post-id');
            $('#confirm-delete').data('post-id', postId);
            $('#delete-wiki-modal').show();
        });
        
        // Handle cancel delete
        $('#cancel-delete').on('click', function() {
            $('#delete-wiki-modal').hide();
        });
        
        // Handle confirm delete
        $('#confirm-delete').on('click', function() {
            var postId = $(this).data('post-id');
            var button = $(this);
            
            // Disable button and show loading state
            button.prop('disabled', true).text('Deleting...');
            
            $.ajax({
                url: jotunheimWiki.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'jotunheim_delete_wiki_page',
                    nonce: jotunheimWiki.nonce,
                    post_id: postId
                },
                success: function(response) {
                    if (response.success) {
                        // Redirect to wiki index
                        window.location.href = response.data.redirect + '?message=success';
                    } else {
                        // Show error message
                        alert(response.data);
                        $('#delete-wiki-modal').hide();
                    }
                },
                error: function() {
                    // Show generic error message
                    alert('An error occurred while deleting. Please try again.');
                    $('#delete-wiki-modal').hide();
                },
                complete: function() {
                    // Reset button state
                    button.prop('disabled', false).text('Delete');
                }
            });
        });
        
        // Close modal when clicking outside
        $(window).on('click', function(e) {
            if ($(e.target).is('.jotunheim-wiki-modal')) {
                $('.jotunheim-wiki-modal').hide();
            }
        });
    });
})(jQuery);
