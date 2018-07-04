<template>
    <div class="u-height-100 u-flex u-align-items-center" style="padding-bottom:1px;">


        <a class="c-btn c-btn--secondary clickable u-ml-medium"
           v-tooltip.top-center="'New Email'"
           @click.prevent="createEmail"
        >
            <i class="u-opacity-heavy fa fa-pencil-square-o"></i>
        </a>

        <div class="u-ml-auto u-mr-medium">
            <div class="c-btn-group u-ml-auto" v-if="email.id && showControls">
                <a class="c-btn c-btn--secondary clickable"
                   v-tooltip.top-center="'Reply'"
                   @click.prevent="replyToEmail"
                >
                    <i class="u-opacity-heavy fa fa-mail-reply"></i>
                </a>

                <a class="c-btn c-btn--secondary clickable"
                   v-tooltip.top-center="'Reply All'"
                   @click.prevent="replyAllToEmail"
                >
                    <i class="u-opacity-heavy fa fa-mail-reply-all"></i>
                </a>

                <a class="c-btn c-btn--secondary clickable"
                   v-tooltip.top-center="'Forward'"
                   @click.prevent="forwardEmail"
                >
                    <i class="u-opacity-heavy fa fa-mail-forward"></i>
                </a>

                <a class="c-btn c-btn--secondary clickable"
                   v-tooltip.top-center="'Move'"
                   @click.prevent="moveEmail"
                   v-if="!email.deleted && email.type === 'inbound'"
                >
                    <i class="u-opacity-heavy fa fa-arrows"></i>
                </a>

                <a class="c-btn c-btn--secondary clickable"
                   v-tooltip.top-center="'Delete'"
                   @click.prevent="deleteEmail"
                   v-if="!email.deleted && email.type === 'inbound'"
                >
                    <i class="u-opacity-heavy fa fa-trash-o"></i>
                </a>

                <a class="c-btn c-btn--secondary clickable"
                   v-tooltip.top-center="'Restore'"
                   @click.prevent="restoreEmail"
                   v-if="email.deleted && email.type === 'inbound'"
                >
                    <i class="u-opacity-heavy fa fa-refresh"></i>
                </a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            email: {
                required: false,
            },
            showControls: {
                required: true,
            },
        },
        data() {
            return {}
        },
        methods: {
            createEmail: function () {
                this.$emit('createEmail')
            },
            replyToEmail: function () {
                this.$emit('replyToEmail')
            },
            replyAllToEmail: function () {
                this.$emit('replyAllToEmail')
            },
            forwardEmail: function () {
                this.$emit('forwardEmail')
            },
            moveEmail: function () {
                this.$emit('moveEmail')
            },
            deleteEmail: function () {
                this.$emit('deleteEmail')
            },
            restoreEmail: function () {
                this.$emit('restoreEmail')
            },
        },
        mounted() {
        },
    }
</script>
