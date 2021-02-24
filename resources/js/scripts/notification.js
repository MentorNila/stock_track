import Vue from "https://cdn.jsdelivr.net/npm/vue@2.6.11/dist/vue.esm.browser.js"
let list = [];

window.user.user.notifications.map(function(value, key) {
    list.push(value);
});

new Vue({
    el:'.notification',

    data: {
        message: 'My new notification',
        notifications: list,
    },

    methods: {

    }
});

$('.mark-all-as-read, .mark-all-as-read-button').on('click', function () {
    markNotificationAsRead();
    $('.notification .notification-item').each(function (index, item) {
        $(this).removeClass('read-notification')
    })
})

$('.mark-all-as-read-button').on('click', function () {
    markNotificationAsRead();
    $('ul.notifications-list li').each(function (index, item) {
        $(this).find('.list-title').addClass('text-bold-500');
    })
})

$(document).ready(function () {
    $('.mark-as-read').on('click', function () {
        $(this).addClass('mark-as-read').attr('data-original-title', 'Mark as Unread').children('i').removeClass('text-light-primary').addClass('text-light-secondary');
        $('.readable-mark-icon.mark-as-read').siblings('.list-left').find('.list-title').addClass('text-bold-500');
        markNotificationAsRead($(this).data('id'))
    });

    $('.mark-as-unread').on('click', function () {
        $(this).addClass('mark-as-read').attr('data-original-title', 'Mark as Unread').children('i').removeClass('text-light-primary').addClass('text-light-secondary');
        $('.readable-mark-icon.mark-as-read').siblings('.list-left').find('.list-title').addClass('text-bold-500');
        markNotificationAsRead($(this).data('id'))
    });

    // Default mark-as-read shown
    // $('.readable-mark-icon.mark-as-read').siblings('.list-left').find('.list-title').addClass('text-bold-500');
});

function markNotificationAsRead(notificationId = null) {
    $.ajax({
        type: 'GET',
        data: {
            id: notificationId
        },
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: '/notification/mark-notification-as-read',
        success: function (response) {}
    });
}

