<template>
    <div class="c-chat">
        <div class="c-chat__body">
            <div class="c-chat__message o-media u-height-100 u-bg-white">
                <div class="o-media__body" v-if="email.id">
                    <h4 class="c-chat__message-author u-mb-zero">
                        {{ email.from }}
                    </h4>

                    <span class="c-chat__message-time">{{ email.received | moment('DD/MM/YYYY HH:mm') }}</span>

                    <p class="">
                        To: <span class="u-text-mute u-pr-small">{{ email.to }}</span>
                        <span v-if="email.cc">Cc: <span class="u-text-mute">{{ email.cc }}</span></span>
                    </p>


                    <a class="c-chat__message-time" v-for="attachment in email.attachments" :key="attachment.id">
                        <i class="fa fa-file"></i>
                        {{ attachment.name }}
                    </a>


                    <span class="c-divider u-mv-small"></span>

                    <div class="c-chat__message-content" v-html="email.content"></div>
                </div>

                <div class="u-flex u-justify-center u-align-items-center u-height-100" v-else>
                    ...
                </div>
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
        },
        mounted() {
        },
    }
</script>
