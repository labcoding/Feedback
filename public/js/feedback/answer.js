$(function () {
    'use strict';

    var Answer = {
        el: '.answer-feedback-form',

        initialize: function() {
            var _this = this;

            $(this.el).closest('.modal-content').find('.send-answer').on('click', function () {
                _this.save(this);
            });
        },

        save: function(e) {
            this.clearErrors();

            var form = $(e).closest('.modal-content').find(this.el);
            var data = $(form).serializeArray();

            if(data.length) {
                var _this = this;
                var url = form.attr('action');

                $.ajax({
                    url: url,
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
                if (type == 'text' || type == 'password' || tag == 'textarea')
                    this.value = '';
                else if (type == 'checkbox' || type == 'radio')
                    this.checked = false;
                else if (tag == 'select') {
                    this.selectedIndex = 0;
                }
            });
        },

        success: function(data, el) {
            //$(this.el).closest('.modal').modal('hide');
            location.reload();
        }
    };

    Answer.initialize();
});
