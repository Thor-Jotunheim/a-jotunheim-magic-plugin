/**
 * Enhanced Icon Import JavaScript
 * Handles the AJAX-powered icon import interface
 */

jQuery(document).ready(function($) {
    'use strict';

    const EnhancedIconImport = {
        importId: null,
        isRunning: false,
        batchSize: 5,
        
        init: function() {
            this.bindEvents();
        },

        bindEvents: function() {
            $('#start-import-btn').on('click', this.startImport.bind(this));
            $('#stop-import-btn').on('click', this.stopImport.bind(this));
            $('#reset-failed-btn').on('click', this.resetFailedItems.bind(this));
        },

        startImport: function(e) {
            e.preventDefault();
            
            if (this.isRunning) {
                return;
            }
            
            const $startBtn = $('#start-import-btn');
            const $stopBtn = $('#stop-import-btn');
            
            // Show loading state
            $startBtn.prop('disabled', true).html('🔄 Starting...');
            
            $.ajax({
                url: enhanced_icon_import_config.ajax_url,
                type: 'POST',
                data: {
                    action: 'enhanced_icon_import_start',
                    nonce: enhanced_icon_import_config.nonce
                },
                success: function(response) {
                    if (response.success) {
                        if (response.data.started) {
                            EnhancedIconImport.importId = response.data.import_id;
                            EnhancedIconImport.isRunning = true;
                            
                            // Update UI
                            $startBtn.hide();
                            $stopBtn.show();
                            $('#import-status').show();
                            $('#progress-total').text(response.data.total);
                            $('#results-container').empty();
                            
                            EnhancedIconImport.showMessage(response.data.message, 'info');
                            
                            // Start processing
                            EnhancedIconImport.processBatch();
                        } else {
                            EnhancedIconImport.showMessage(response.data.message, 'warning');
                        }
                    } else {
                        EnhancedIconImport.showMessage('Error starting import: ' + response.data, 'error');
                    }
                },
                error: function() {
                    EnhancedIconImport.showMessage('Network error starting import', 'error');
                },
                complete: function() {
                    $startBtn.prop('disabled', false).html('🚀 Start Enhanced Import');
                }
            });
        },

        processBatch: function() {
            if (!this.isRunning || !this.importId) {
                return;
            }
            
            $.ajax({
                url: enhanced_icon_import_config.ajax_url,
                type: 'POST',
                data: {
                    action: 'enhanced_icon_import_batch',
                    nonce: enhanced_icon_import_config.nonce,
                    import_id: this.importId,
                    batch_size: this.batchSize
                },
                success: function(response) {
                    if (response.success) {
                        const data = response.data;
                        
                        // Update progress
                        EnhancedIconImport.updateProgress(data.status);
                        
                        // Add batch results
                        if (data.results) {
                            EnhancedIconImport.displayBatchResults(data.results);
                        }
                        
                        if (data.completed) {
                            // Import finished
                            EnhancedIconImport.completeImport(data.message);
                        } else {
                            // Continue with next batch after a short delay
                            setTimeout(function() {
                                EnhancedIconImport.processBatch();
                            }, 500);
                        }
                    } else {
                        EnhancedIconImport.showMessage('Error processing batch: ' + response.data, 'error');
                        EnhancedIconImport.stopImport();
                    }
                },
                error: function() {
                    EnhancedIconImport.showMessage('Network error processing batch', 'error');
                    EnhancedIconImport.stopImport();
                }
            });
        },

        updateProgress: function(status) {
            const processed = status.processed;
            const total = status.total;
            const errors = status.errors;
            const percent = total > 0 ? Math.round((processed / total) * 100) : 0;
            
            $('#progress-processed').text(processed);
            $('#progress-total').text(total);
            $('#progress-percent').text(percent + '%');
            $('#progress-errors-count').text(errors);
            
            $('.progress-fill').css('width', percent + '%');
        },

        displayBatchResults: function(results) {
            const $container = $('#results-container');
            
            results.forEach(function(result) {
                const className = result.success ? 'success' : 'error';
                const icon = result.success ? '✅' : '❌';
                const message = result.success 
                    ? `${result.name} (ID: ${result.id}) - ${result.file}`
                    : `${result.name} (ID: ${result.id}) - Error: ${result.error}`;
                
                const $item = $('<div>')
                    .addClass('result-item')
                    .addClass(className)
                    .html(`${icon} ${message}`);
                
                $container.append($item);
            });
            
            // Auto-scroll to bottom
            $container.scrollTop($container[0].scrollHeight);
        },

        stopImport: function() {
            this.isProcessing = false;
            $('#start-import-btn').prop('disabled', false);
            $('#stop-import-btn').prop('disabled', true);
            this.updateUI('Import stopped by user.');
        },

        resetFailedItems: function() {
            if (confirm('Are you sure you want to reset all failed items? This will allow them to be retried on the next import.')) {
                $.ajax({
                    url: eiAjax.ajaxUrl,
                    type: 'POST',
                    data: {
                        action: 'ei_reset_failed_items',
                        nonce: eiAjax.nonce
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#import-results').html('<div class="notice notice-success"><p>Failed items have been reset. You can now retry the import.</p></div>');
                        } else {
                            $('#import-results').html('<div class="notice notice-error"><p>Error: ' + response.data + '</p></div>');
                        }
                    },
                    error: function() {
                        $('#import-results').html('<div class="notice notice-error"><p>Failed to reset items. Please try again.</p></div>');
                    }
                });
            }
        },

        completeImport: function(message) {
            this.isRunning = false;
            this.importId = null;
            
            $('#start-import-btn').show();
            $('#stop-import-btn').hide();
            
            this.showMessage(message, 'success');
        },

        showMessage: function(message, type) {
            // Remove existing messages
            $('.import-message').remove();
            
            // Create message element
            let messageClass = 'notice-info';
            if (type === 'success') messageClass = 'notice-success';
            if (type === 'error') messageClass = 'notice-error';
            if (type === 'warning') messageClass = 'notice-warning';
            
            const messageHtml = `
                <div class="notice ${messageClass} import-message" style="margin: 15px 0;">
                    <p>${message}</p>
                </div>
            `;
            
            // Insert message at the top
            $('.enhanced-icon-import').prepend(messageHtml);
            
            // Auto-hide success/info messages after 5 seconds
            if (type === 'success' || type === 'info') {
                setTimeout(function() {
                    $('.import-message').fadeOut(function() {
                        $(this).remove();
                    });
                }, 5000);
            }
        }
    };

    // Initialize
    EnhancedIconImport.init();
});