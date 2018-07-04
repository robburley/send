<template>
    <span>
        <!--active-->
        <a class="c-message "
           :class="{
               'u-bg-facebook': email.active,
               'u-bg-white': !email.active,
               'is-active': !email.read,
           }"
           @click.prevent="activateEmail"
        >
            <div class="o-media">
                <div class="o-media__body">
                    <h4 class="c-message__title"
                        :class="{
                            'u-text-white': email.active,
                            'u-text-bold': !email.read
                        }"
                    >
                       {{ email.from }}

                        <span class="c-message__title-meta"
                              :class="{
                                  'u-text-white': email.active,
                                  'u-text-bold': !email.read
                              }"
                        >
                            {{ email.subject }}
                        </span>
                    </h4>

                    <span class="c-message__time"
                          :class="{
                            'u-text-white': email.active,
                            'u-text-bold': !email.read
                          }"
                    >
                        {{ email.received | moment('from', 'now') }}
                    </span>
                </div>
            </div>

            <p class="c-message__snippet"
               :class="{
                   'u-text-white': email.active,
                    'u-text-bold': !email.read
               }"
            >
                {{ this.email.content | striphtml }}
            </p>
        </a>
    </span>
</template>

<script>
    export default {
        props: {
            email: {
                required: false,
            },
        },
        filters: {
            striphtml: function (string) {
                let div = document.createElement('div')

                div.innerHTML = string

                let text = div.textContent || div.innerText || ''

                return text
            },
        },
        methods: {
            activateEmail() {
                this.$emit('activateEmail')
            },
        },
        mounted() {
        },
    }
</script>
