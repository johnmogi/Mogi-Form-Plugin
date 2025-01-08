jQuery(document).ready(function($) {
    $('.mogi-form form').on('submit', function(e) {
        e.preventDefault();
        
        var $form = $(this);
        var $submit = $form.find('button[type="submit"]');
        
        // Disable submit button
        $submit.prop('disabled', true);
        
        // Remove any existing messages
        $('.mogi-form .message').remove();
        
        // Collect form data
        var formData = new FormData($form[0]);
        formData.append('action', 'mogi_form_submit');
        
        // Submit form via AJAX
        $.ajax({
            url: mogi_form.ajax_url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    // Show success message
                    $form.before('<div class="message success">' + response.data.message + '</div>');
                    
                    // Clear form
                    $form[0].reset();
                } else {
                    // Show error message
                    $form.before('<div class="message error">' + response.data.message + '</div>');
                }
            },
            error: function() {
                // Show generic error message
                $form.before('<div class="message error">' + mogi_form.error_message + '</div>');
            },
            complete: function() {
                // Re-enable submit button
                $submit.prop('disabled', false);
            }
        });
    });
});
