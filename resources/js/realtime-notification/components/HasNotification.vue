<template>
    <span>
        <a href="javascript:void(0);" class="nav-link" data-toggle="dropdown">
            <i class="fas fa-bell"></i>&nbsp;
            <span
                class="badge badge-danger navbar-badge"
                v-if="this.$parent.hasNotification"
                >{{ this.$parent.count }}</span
            >
        </a>

        <div
            class="dropdown-menu dropdown-menu-lg dropdown-menu-right dropdown-notifications"
        >
            <a class="dropdown-item">{{ this.$parent.label }}</a>
            <div class="dropdown-divider"></div>
            <span
                v-for="notification in this.$parent.notifications"
                :key="notification.id"
            >
                <a
                    :href="notification.link"
                    class="dropdown-item"
                    @click.prevent="markAsRead(notification.id, $event)"
                >
                    <div class="media">
                        <div class="media-body">
                            <p class="dropdown-item-title">
                                {{ notification.message }}
                            </p>
                            <p class="text-right">
                                <small
                                    ><i class="fas fa-calendar"></i
                                    > {{ notification.time }}</small
                                >
                            </p>
                        </div>
                    </div>
                </a>
                <div class="dropdown-divider"></div>
            </span>
            <a
                href="/notifikasi"
                class="dropdown-item dropdown-footer"
                rel="content"
                >Lihat semua notifikasi</a
            >
        </div>
    </span>
</template>

<script>
export default {
    methods: {
        markAsRead(id, e) {
            window.axios.post("api/markAsReadNotification", { id: id });
            location.href = e.currentTarget.getAttribute("href");
        }
    }
};
</script>
