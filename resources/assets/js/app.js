
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'));
Vue.component('imprest', require('./components/createImprest.vue'));
Vue.component('surrender-imprest', require('./components/surrenderImprest.vue'));
Vue.component('edit-surrender-imprest', require('./components/editSurrenderImprest.vue'));
Vue.component('index-page', require('./components/index.vue'));
Vue.component('edit-page', require('./components/edit.vue'));

const app = new Vue({
    el: '#app'
});

$('.infolert').delay(4000).slideUp();


(function() {
    var laravel = {
        initialize: function () {
            this.methodLinks = $('a[data-method]').not('.completion');
            this.registerEvents();
        },

        registerEvents: function () {
            this.methodLinks.on('click', this.handleMethod);
        },

        handleMethod: function (e) {
            var link = $(this);
            var httpMethod = link.data('method').toUpperCase();

            if ($.inArray(httpMethod, ['PUT', 'DELETE']) === -1) {
                return;
            }

            laravel.createAlert(link);

            e.preventDefault();
        },

        submitForm: function (e) {
            e.preventDefault();
            var form = laravel.createForm($(this));
            form.submit();
        },

        createAlert: function (link) {
            var notice = $('<div class="alert alert-danger alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><p>This action is not reversible. Delete?</p><p class="confirm-buttons"><a href="' + link.attr("href") + '" class="btn btn-danger completion" data-method="delete" rel="nofollow" data-token="' + link.data("token") +'">Delete</a><button type="button" data-dismiss="alert" aria-label="Close" class="btn btn-default">Cancel</button></p></div>');
            notice.find('a[data-method].completion').on('click', this.submitForm);

            $('#alertConfirm').fadeOut(1).append(notice).fadeIn(100);
        },

        createForm: function (link) {
            var form =
                $('<form>', {
                    'method': 'POST',
                    'action': link.attr('href')
                });

            var token =
                $('<input>', {
                    'type': 'hidden',
                    'name': '_token',
                    'value': link.data('token')
                });

            var hiddenInput =
                $('<input>', {
                    'name': '_method',
                    'type': 'hidden',
                    'value': link.data('method')
                });

            return form.append(token, hiddenInput)
                .appendTo('body');
        }
    };

    laravel.initialize();
})();
