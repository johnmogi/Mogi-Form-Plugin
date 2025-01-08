jQuery(document).ready(function($) {
    // Copy shortcode to clipboard
    $('.copy-shortcode').on('click', function(e) {
        e.preventDefault();
        
        var shortcode = $(this).data('shortcode');
        
        // Create temporary textarea
        var $temp = $('<textarea>');
        $('body').append($temp);
        $temp.val(shortcode).select();
        
        // Copy text
        document.execCommand('copy');
        
        // Remove temporary textarea
        $temp.remove();
        
        // Update button text temporarily
        var $button = $(this);
        var originalText = $button.text();
        $button.text('Copied!');
        
        setTimeout(function() {
            $button.text(originalText);
        }, 2000);
    });
    
    // Confirm form deletion
    $('.delete-form').on('click', function(e) {
        if (!confirm(mogi_form_admin.delete_confirm)) {
            e.preventDefault();
        }
    });
});
