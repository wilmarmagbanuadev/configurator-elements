jQuery(document).ready(function($) {
    "use strict";

    $('.row-actions .edit a, .page-title-action, .column-title .row-title, #menu-posts-blank_elements ul li a[href*="post-new.php"]').on('click', function(e) {
        e.preventDefault();
        var id = 0;
        var modal = $('#blankelements_head-foot_modal');
        var parent = $(this).parents('.column-title');

        modal.addClass('loading');
        modal.modal('show');

        if (parent.length > 0) {
            id = parent.find('.hidden').attr('id').split('_')[1];

            $.get(window.blankelements.resturl + 'my-template/get/' + id, function(data) {
                Blankelements_Template_Editor(data);
                modal.removeClass('loading');
            });
        } else {
            var data = {
                title: '',
                type: 'header',
                condition_a: 'entire_site',
                condition_singular: 'all',
                activation: '',
            };
            Blankelements_Template_Editor(data);
            modal.removeClass('loading');
        }

        modal.find('form').attr('data-blankelements-id', id);
    });

    $('.blankelements-template-modalinput-type').on('change', function() {
        var type = $(this).val();
        var inputs = $('.blankelements-template-headerfooter-option-container');

        if (type == 'section') {
            inputs.hide();
        } else {
            inputs.show();
        }
    });


    $('.blankelements-template-modalinput-condition_a').on('change', function() {
        var condition_a = $(this).val();
        var inputs = $('.blankelements-template-modalinput-condition_singular-container');

        if (condition_a == 'singular') {
            inputs.show();
        } else {
            inputs.hide();
        }
    });

    $('.blankelements-template-modalinput-condition_singular').on('change', function() {
        var condition_singular = $(this).val();
        var inputs = $('.blankelements-template-modalinput-condition_singular_id-container');

        if (condition_singular == 'selective') {
            inputs.show();
        } else {
            inputs.hide();
        }
    });


    $('.blankelements-template-save-btn-editor').on('click', function() {
        var form = $('#blankelements-template-modalinput-form');
        form.attr('data-open-editor', '1');
        form.trigger('submit');
    });

    var before_form_data = $('#blankelements-template-modalinput-form').serialize();

    $('#blankelements-template-modalinput-form').on('submit', function(e) {
        e.preventDefault();
        var modal = $('#blankelements_head-foot_modal');
        modal.addClass('loading');

        var form_data = $(this).serialize();
        var id = $(this).attr('data-blankelements-id');
        var open_editor = $(this).attr('data-open-editor');
        var admin_url = $(this).attr('data-editor-url');
        var nonce = $(this).attr('data-nonce');

        if (form_data == before_form_data) {
            // Nothing has changed
            $('.nodata_message').addClass('loaded');
            setTimeout(function() {
                $('.nodata_message').removeClass('loaded');
            }, 2000);
        }

        $.ajax({
            url: window.blankelements.resturl + 'my-template/update/' + id,
            data: form_data,
            type: 'get',
            headers: {
                'X-WP-Nonce': nonce
            },
            dataType: 'json',
            success: function(output) {
                console.log(output);
                modal.removeClass('loading');
                $('.modal_message').addClass('loaded');
                setTimeout(function() {
                    $('.modal_message').removeClass('loaded');
                }, 2000);
                // set list table data
                var row = $('#post-' + output.data.id);
                //console.log(row.length);

                if (row.length > 0) {
                    row.find('.column-type')
                        .html(output.data.type);

                    row.find('.column-status')
                        .html(output.data.type_html);

                    row.find('.column-condition')
                        .html(output.data.cond_text);

                    row.find('.row-title')
                        .html(output.data.title)
                        .attr('aria-label', output.data.title);

                    //console.log(output.data.title);
                }

                if (open_editor == '1') {
                    window.location.href = admin_url + '?post=' + output.data.id + '&action=elementor';
                } else if (id == '0') {
                    location.reload();
                }

                //$('#blankelements_head-foot_modal').hide();

                //$('.modal-backdrop').remove();
            }

        });

    });


    $('.blankelements-template-modalinput-condition_singular_id').select2({
        ajax: {
            url: window.blankelements.resturl + 'ajaxselect2/singular_list',
            dataType: 'json',
            data: function(params) {
                var query = {
                    s: params.term,
                }
                return query;
            }
        },
        cache: true,
        placeholder: "--",
        dropdownParent: $('#blankelements_headerfooter_modal_body')
            //minimumInputLength: 2,
    });

    function Blankelements_Template_Editor(data) {

        // set the form data
        $('.blankelements-template-modalinput-title').val(data.title);
        $('.blankelements-template-modalinput-condition_a').val(data.condition_a);
        $('.blankelements-template-modalinput-condition_singular').val(data.condition_singular);
        $('.blankelements-template-modalinput-condition_singular_id').val(data.condition_singular_id);
        $('.blankelements-template-modalinput-type').val(data.type);

        var activation_input = $('.blankelements-template-modalinput-activition');
        if (data.activation == 'yes') {
            activation_input.attr('checked', true);
        } else {
            activation_input.removeAttr('checked');
        }

        $('.blankelements-template-modalinput-activition, .blankelements-template-modalinput-type, .blankelements-template-modalinput-condition_a, .blankelements-template-modalinput-condition_singular')
            .trigger('change');

        var el = $('.blankelements-template-modalinput-condition_singular_id');
        $.ajax({
            url: window.blankelements.resturl + 'ajaxselect2/singular_list',
            dataType: 'json',
            data: {
                ids: String(data.condition_singular_id)
            }
        }).then(function(data) {

            if (data !== null && data.results.length > 0) {
                el.html(' ');
                $.each(data.results, function(i, v) {
                    var option = new Option(v.text, v.id, true, true);
                    el.append(option).trigger('change');
                });
                el.trigger({
                    type: 'select2:select',
                    params: {
                        data: data
                    }
                });
            }
        });
    }


    function blankelements_url_replace_param(url, paramName, paramValue) {
        if (paramValue == null) {
            paramValue = '';
        }
        var pattern = new RegExp('\\b(' + paramName + '=).*?(&|#|$)');
        if (url.search(pattern) >= 0) {
            return url.replace(pattern, '$1' + paramValue + '$2');
        }
        url = url.replace(/[?#]$/, '');
        return url + (url.indexOf('?') > 0 ? '&' : '?') + paramName + '=' + paramValue;
    }

    var tab_container = $('.wp-header-end');
    var tabs = '';
    var xs_types = {
        'all': 'All Templates',
        'header': 'Header',
        'footer': 'Footer',
    };
    var url = new URL(window.location.href);
    var s = url.searchParams.get("blankelements_type_filter");
    s = (s == null) ? 'all' : s;

    $.each(xs_types, function(k, v) {
        var url = blankelements_url_replace_param(window.location.href, 'blankelements_type_filter', k);
        var klass = (s == k) ? 'blankelements_type_filter_active nav-tab-active' : ' ';
        tabs += `
            <a href="${url}" class="${klass} blankelements_type_filter_tab_item nav-tab">${v}</a>
        `;
        tabs += "\n";
    });
    tab_container.after('<div class="blankelements_type_filter_tab_container nav-tab-wrapper">' + tabs + '</div><br/>');

    $('.modal_close_btn i').click(function() {
        $('.modal_message').removeClass('loaded');
    });

    $(document).click(function(e) {
        if (!$(e.target).closest(".dialog_content_area").length) {
            $('.modal_message').removeClass('loaded');
        }
    });

});