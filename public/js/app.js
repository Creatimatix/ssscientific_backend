var app = {

    /**
     * This function can use to display a notification
     * @param title Specify title of the notification
     * @param message Specify message for the notification
     * @param type Type of notification. Eg.: info, success, danger, warning, primary
     * @param icon Specify the icon you need to display with notification
     * @param from Specify the location of placement. Eg.: top, bottom
     * @param align Specify the location of placement. Eg.: center, left, right
     * @param animIn Specify coming animation. [refer CSS3 animation library - animate.css]
     * @param animOut Specify going animation. [refer CSS3 animation library - animate.css]
     */
    notify: function (title, message, type, icon, from, align, animIn, animOut) {

        from = (typeof from === typeof undefined) ? 'top' : from;
        align = (typeof align === typeof undefined) ? 'right' : align;
        icon = (typeof icon === typeof undefined) ? '' : icon;
        type = (typeof type === typeof undefined) ? 'info' : type;
        animIn = (typeof animIn === typeof undefined) ? 'animated fadeIn' : animIn;
        animOut = (typeof animOut === typeof undefined) ? 'animated fadeOut' : animOut;

        var titleHtml = '';
        if (title !== '') {
            titleHtml = '<span data-growl="title"></span>: ';
        }

        $.growl({
            icon: icon,
            title: title + ' ',
            message: message,
            url: ''
        }, {
            element: 'body',
            type: type,
            allow_dismiss: true,
            placement: {
                from: from,
                align: align
            },
            offset: {
                x: 30,
                y: 30
            },
            spacing: 10,
            z_index: 999999,
            delay: 2500,
            timer: 5000,
            url_target: '_blank',
            mouse_over: false,
            animate: {
                enter: animIn,
                exit: animOut
            },
            icon_type: 'class',
            template: '<div data-growl="container" class="alert" role="alert">' +
                '<button type="button" class="close" data-growl="dismiss">' +
                '<span aria-hidden="true">&times;</span>' +
                '<span class="sr-only">Close</span>' +
                '</button>' +
                '<span data-growl="icon"></span>' +
                titleHtml +
                '<span data-growl="message"></span>' +
                '<a href="#" data-growl="url"></a>' +
                '</div>'
        });
    },
}

var messages = {
    message: {
        saved: {
            title: '',
            message: 'Data saved successfully!'
        },
        updated: {
            title: '',
            message: 'Data updated successfully!'
        },
        deleted: {
            title: '',
            message: 'Data deleted successfully!'
        },
        warning: {
            title: '',
            message: 'Data deleted successfully!'
        },
        undone: {
            title: '',
            message: 'Data recovered successfully!'
        },
        approve: {
            title: '',
            message: 'Data approved successfully!'
        },
        deny: {
            title: '',
            message: 'Data denied successfully!'
        },
        error: {
            title: '',
            message: 'Try again!',
        },
        default: {
            title: '',
            message: 'Success!',
        }
    },
    saved: function (title, msg) {
        msg = (typeof msg === typeof undefined || msg === '') ? this.message.saved.message : msg;
        title = (typeof title === typeof undefined || title === '') ? this.message.saved.title : title;
        // app.notify(title, msg, 'success');
        $.notify(msg, 'success');
    },
    updated: function (title, msg) {
        msg = (typeof msg === typeof undefined || msg === '') ? this.message.updated.message : msg;
        title = (typeof title === typeof undefined || title === '') ? this.message.updated.title : title;
        // app.notify(title, msg, 'info');
        $.notify( msg, 'info');
    },
    deleted: function (title, msg) {
        msg = (typeof msg === typeof undefined || msg === '') ? this.message.deleted.message : msg;
        title = (typeof title === typeof undefined || title === '') ? this.message.deleted.title : title;
        // app.notify(title, msg, 'warning');
        $.notify(msg, 'warning');
    },
    warning: function (title, msg) {
        msg = (typeof msg === typeof undefined || msg === '') ? this.message.warning.message : msg;
        title = (typeof title === typeof undefined || title === '') ? this.message.warning.title : title;
        // app.notify(title, msg, 'warning');
        $.notify(msg, 'warning');
    },
    undone: function (title, msg) {
        msg = (typeof msg === typeof undefined || msg === '') ? this.message.undone.message : msg;
        title = (typeof title === typeof undefined || title === '') ? this.message.undone.title : title;
        // app.notify(title, msg, 'info');
        $.notify(msg, 'info');
    },
    approve: function (title, msg) {
        msg = (typeof msg === typeof undefined || msg === '') ? this.message.approve.message : msg;
        title = (typeof title === typeof undefined || title === '') ? this.message.approve.title : title;
        // app.notify(title, msg, 'info');
        $.notify(msg, 'info');
    },
    deny: function (title, msg) {
        msg = (typeof msg === typeof undefined || msg === '') ? this.message.deny.message : msg;
        title = (typeof title === typeof undefined || title === '') ? this.message.deny.title : title;
        // app.notify(title, msg, 'info');
        $.notify(msg, 'info');
    },
    error: function (title, msg) {
        msg = (typeof msg === typeof undefined || msg === '') ? this.message.error.message : msg;
        title = (typeof title === typeof undefined || title === '') ? this.message.error.title : title;
        // app.notify(title, msg, 'danger');
         $.notify(msg, 'danger');
    },
    default: function (title, msg) {
        msg = (typeof msg === typeof undefined || msg === '') ? this.message.default.message : msg;
        title = (typeof title === typeof undefined || title === '') ? this.message.default.title : title;
        // app.notify(title, msg, 'info');
         $.notify(msg, 'info');
    },
}
