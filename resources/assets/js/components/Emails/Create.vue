<template>
    <div class="c-chat">
        <div class="c-chat__body u-bg-white">
            <div class="c-chat__message o-media u-height-100">
                <div class="o-media__body">
                    <form @submit.prevent="sendEmail" enctype="multipart/form-data" ref="emailForm">
                        <div class="row">
                            <div class="col-sm-8">
                                <h4 class="">New Email</h4>
                            </div>

                            <div class="col-sm-4 u-text-right">
                                <button class="c-close u-color-danger" type="button" @click.prevent="cancelEmail">
                                    ×
                                </button>
                            </div>
                        </div>

                        <div class="row u-pt-small">
                            <div class="col-lg-2">
                                <div class="c-field">
                                    <label class="c-field__label" style="padding-top:8px;" for="to">
                                        To:
                                    </label>
                                </div>
                            </div>

                            <div class="col-lg-10">
                                <div class="c-field">
                                    <input class="c-input" type="text"
                                           placeholder="example@example.org, example2@example.org"
                                           v-model="email.to"
                                           name="to"
                                    >
                                </div>
                            </div>
                        </div>

                        <div class="row u-pt-small">
                            <div class="col-lg-2">
                                <div class="c-field">
                                    <label class="c-field__label" style="padding-top:8px;" for="cc">
                                        Cc:
                                    </label>
                                </div>
                            </div>

                            <div class="col-lg-10">
                                <div class="c-field">
                                    <input class="c-input" type="text"
                                           placeholder="example@example.org, example2@example.org"
                                           v-model="email.cc"
                                           name="cc"
                                    >
                                </div>
                            </div>
                        </div>

                        <div class="row u-pt-small">
                            <div class="col-lg-2">
                                <div class="c-field">
                                    <label class="c-field__label"
                                           style="padding-top:8px;"
                                           for="subject">
                                        Subject:
                                    </label>
                                </div>
                            </div>

                            <div class="col-lg-10">
                                <div class="c-field">
                                    <input class="c-input"
                                           type="text"
                                           v-model="email.subject"
                                           name="subject"
                                    >
                                </div>
                            </div>
                        </div>

                        <div class="row u-pt-small">
                            <div class="col-lg-2">
                                <div class="c-field">
                                    <label class="c-field__label"
                                           style="padding-top:8px;"
                                           for="subject">
                                        Attachments
                                    </label>
                                </div>
                            </div>

                            <div class="col-lg-10">
                                <div class="c-field">
                                    <input class="c-input"
                                           type="file"
                                           multiple
                                           name="files[]"
                                           ref="attachments"
                                    >
                                </div>
                            </div>
                        </div>

                        <div class="row u-pt-small">
                            <div class="col-sm-12">
                                <div class="c-field">
                                    <vue-html5-editor :content="email.content"
                                                      :height="400"
                                                      :auto-height="true"
                                                      @change="updateEmailContent"
                                    ></vue-html5-editor>

                                    <input type="hidden"
                                           name="content"
                                           v-model="email.content"
                                    >
                                </div>
                            </div>
                        </div>

                        <div id="messages">
                            <div class="row u-pt-small" v-if="sent">
                                <div class="col-sm-12">
                                    <div class="c-alert c-alert--success alert">
                                        <i class="c-alert__icon fa fa-check"></i>

                                        Email Sent

                                        <button class="c-close"
                                                @click.prevent="clearSent"
                                        >
                                            x
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="row u-pt-small" v-if="errors">
                                <div class="col-sm-12">
                                    <div class="u-bg-danger u-text-white u-p-small u-border-rounded">
                                        <div class="u-flex u-width-100" v-for="[error, index] in errors">
                                            <div class="">
                                                - {{ error }} <br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row u-pt-small u-mb-small">
                            <div class="col-sm-12">
                                <button
                                        type="submit"
                                        class="c-btn c-btn--success pull-right"
                                >
                                    <i class="fa fa-envelope-o u-mr-xsmall"></i>

                                    Send
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            to: {
                required: false,
            },
            cc: {
                required: false,
            },
            subject: {
                required: false,
            },
            content: {
                required: false,
            },

        },
        components: {},
        methods: {
            clearSent() {
                this.sent = false
            },
            cancelEmail() {
                this.$emit('cancelEmail')
            },
            updateEmailContent(value) {
                this.email.content = value
            },
            resetForm() {
                this.email = {
                    to: '',
                    cc: '',
                    subject: '',
                    content: '',
                    attachments: null,
                    attachment_count: 0,
                }

                this.$refs.attachments.value = null

                this.$refs.attachments.reset()
            },
            sendEmail() {
                let self = this

                self.errors = false

                window.axios.post('/api/outbound-emails', new FormData(self.$refs.emailForm))
                    .then(function (response) {
                        self.sent = true

                        self.resetForm()
                    })
                    .catch(function (error) {
                        if (error.response && error.response.data) {
                            self.clearSent()

                            self.errors = error.response.data.errors
                        }
                    })
            },
        },
        data() {
            return {
                sent: false,
                errors: false,
                editorOptions: {
                    toolbar: {
                        buttons: ['bold', 'italic', 'underline', 'anchor', 'h2', 'h3', 'quote'],
                    },
                },
                email: {
                    to: this.to,
                    cc: this.cc,
                    subject: this.subject,
                    content: this.content,
                },
            }
        },
        mounted() {
        },
    }
</script>
