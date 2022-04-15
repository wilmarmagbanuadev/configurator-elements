(function($) {
    "use strict";
 
    $('a[href*="https://configurator.wpconfigurator.com/support"]').each(function() {
       $(this).attr('target','_blank');
    });
    //check body if have class  
    if ($("body").hasClass("toplevel_page_configurator-template-kits-blocks")) {
        $('body').addClass('blank_panel');
    }
    $(document).ready(function() {
        $('#blankelements_vertical_tabs ul li a.blank_tab_link').click(function(e) {

            $('#blankelements_vertical_tabs ul li.attr-active').removeClass('attr-active');

            var tagid = $(this).attr('href');

            var $parent = $(this).parent();
            $parent.addClass('attr-active');
            e.preventDefault();

            $('#blankelements-tab-contents .attr-tab-pane').removeClass('attr-active');

            $(tagid).addClass('attr-active');


        });
    });

    jQuery(document).ready(function($) {
        $('#toplevel_page_blankelementspro ul.wp-submenu li:last-child a').attr('target', '_blank');
    });

    $('#settings-page-form').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var btn = form.find('.settings-form-submit-btn');
        var formdata = form.serialize();
        var formurl = form.attr('action');
        form.addClass('is-loading');

        $.ajax({
            type: "POST",
            url: formurl,
            data: form.serialize(), // serializes the form's elements.
            success: function(data) {
                form.removeClass('is-loading');
                $('.settings_message').addClass('loaded');

                setTimeout(function() {
                    $('.settings_message').removeClass('loaded');
                }, 2000);
            }
        });

    });


})(jQuery);