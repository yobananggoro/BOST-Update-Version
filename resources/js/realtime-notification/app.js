import "./bootstrap";

import Vue from "vue";
import VueSnotify from "vue-snotify";
import "vue-snotify/styles/material.css";

Vue.use(VueSnotify, {
    timeout: 5000,
    showProgressBar: true,
    closeOnClick: true,
    pauseOnHover: true
});

import HasNotification from "./components/HasNotification";

const app = new Vue({
    el: ".wrapper",
    data: {
        user: {},
        count: 0,
        label: "",
        notifications: [],
        hasNotification: false,
        notify: ""
    },
    components: { HasNotification },
    methods: {
        getUser() {
            window.axios
                .get("api/user")
                .then(res => {
                    this.user = res.data;
                    this.fetchNotifications();

                    if (window.Laravel.pushNotif) {
                        this.listenChannel();
                    }
                })
                .catch(e => {
                    console.log(e);
                });
        },
        fetchNotifications() {
            window.axios
                .get("api/fetchNotifications")
                .then(res => {
                    this.count = res.data.count;
                    this.label = res.data.label;
                    this.notify = res.data.notify;
                    this.notifications = res.data.notifications;
                    this.hasNotification = res.data.hasNotifications;
                    if (this.count > 0) {
                        this.notifyUser(this.notify);
                    }
                })
                .catch(e => {
                    console.log(e);
                });
        },
        listenChannel() {
            window.Echo.private(`pushNotification.${this.user.id}`).listen(
                "PushNotificationEvent",
                e => {
                    this.fetchNotifications();
                }
            );
        },
        notifyUser(message) {
            this.$snotify.info(message);
        }
    },
    created() {
        this.getUser();
    }
});
