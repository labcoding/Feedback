$(function () {
    'use strict';

    var Feedback = {
        el: '.feedback-form',
        url: '/feedback/create',

        initialize: function() {
            var _this = this;

            $(this.el).find('#send').click(function () {
                _this.save(this);
            });
        },

        save: function(e) {
            this.clearErrors();

            var form = $(e).closest(this.el).closest('form');
            var data = $(form).serializeArray();

            if(data.length) {
                var _this = this;

                $.ajax({
                    url: this.url,
                    type: 'POST',
                    data: data,
                    success: function (response) {
                        _this.clearForm(form);
                        _this.success(response.responseJSON, $(_this.el));
                    },
                    error: function (response) {
                        if(response.responseJSON != undefined) {
                            _this.errors(response.responseJSON.errors);
                        } else {
                            alert('Error');
                        }
                    }
                });
            }
        },

        success: function(data, el) {
            $('#feedback-sent').removeClass('hidden');
        },

        errors: function (errors) {
            var _this = this;

            $.each(errors, function(attr, values) {
                var el = $(_this.el).find('[name=' + attr + ']');

                el.parent().addClass('has-error');

                var messages = '<div class="help-block">';
                $.each(values, function(key, error) {
                    messages += '<p>' + error + '</p>';
                });
                messages += '</div>';

                $(messages).insertAfter(el);
            });
        },

        clearErrors: function() {
            $(this.el).find('.help-block').remove();
            $(this.el).find('.has-error').removeClass('has-error');
        },

        clearForm: function(form) {
            var _this = this;
            return form.each(function() {
                var type = this.type, tag = this.tagName.toLowerCase();
                if (tag == 'form')
                    return _this.clearForm($(':input', this));
                if (type == 'text' || tag == 'textarea')
                    this.value = '';
                else if (type == 'checkbox' || type == 'radio')
                    this.checked = false;
                else if (tag == 'select') {
                    this.selectedIndex = 0;
                }
            });
        }
    };

    Feedback.initialize();
});
