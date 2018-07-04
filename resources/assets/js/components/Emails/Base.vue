<style>
    .outer {
        position: relative;
        display: inline-block;
        width: 100%;
    }

    .inner {
        color: #606f7b;
        right: 0;
        top: 0;
        bottom: 0;
        position: absolute;
        pointer-events: none;
        padding-left: .5rem;
        padding-right: .5rem;
        -webkit-box-align: center;
        align-items: center;
        display: -webkit-box;
        display: flex;
    }

    .icon {
        width: 1rem;
        fill: currentColor;
        height: 1rem;
    }

    .select-style {
        width: 100%;
        box-shadow: 0 2px 4px 0 rgba(0, 0, 0, .1);
        padding-right: 2rem;
        padding-left: 1rem;
        padding-right: 1rem;
        padding-top: .5rem;
        padding-bottom: .5rem;
        display: block;
        border-width: 1px;
        border-radius: .25rem;
        border-color: #dae1e7;
        background-color: #fff;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }

    .c-messages > div > span {
        display: block !important;
    }
</style>

<template>
    <div class="div">
        <modal name="move-email-modal"
               :adaptive="true"
               height="auto"
               classes="u-bg-white u-pv-small u-ph-small"
               :pivotY="0.2"
        >
            <div class="col-xs-12">
                <div class="c-field">
                    <label class="c-field__label">Folder</label>
                    <div class="c-select">
                        <div class="outer">
                            <select v-model="selected_folder" class="select-style">
                                <option value="0" selected>
                                    Inbox
                                </option>

                                <option v-for="folder in folders" v-bind:value="folder.id">
                                    {{ folder.name }}
                                </option>
                            </select>

                            <div class="inner">
                                <svg class="icon" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 20 20">
                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 u-mt-small">
                <button class="c-btn c-btn--info c-btn--fullwidth"
                        @click.prevent="processMoveEmail"
                >
                    Move
                </button>
            </div>
        </modal>

        <div class="row">
            <div class="col-lg-4 u-p-zero u-border-right">
                <email-search v-model="search"></email-search>

                <div class="c-messages">
                    <transition-group v-on:enter="slideFadeIn"
                                      v-on:leave="fadeSlideOut"
                                      tag="div"
                    >
                        <email-snippet v-for="email in orderBy(filterBy(emails, search), 'received', -1)"
                                       :key="email.id"
                                       :email="email"
                                       @activateEmail="activateEmail(email)"
                        ></email-snippet>
                    </transition-group>
                </div>
            </div>

            <div class="col-lg-8 u-p-zero">
                <div class="row u-mv-small">
                    <div class="col-sm-12">
                        <email-control :email="selected"
                                       :showControls="!creating"
                                       @createEmail="createEmail"
                                       @replyToEmail="replyToEmail"
                                       @replyAllToEmail="replyAllToEmail"
                                       @forwardEmail="forwardEmail"
                                       @moveEmail="moveEmail"
                                       @deleteEmail="deleteEmail"
                                       @restoreEmail="restoreEmail"
                        ></email-control>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <email-create v-if="creating"
                                      :to="new_email.to"
                                      :cc="new_email.cc"
                                      :subject="new_email.subject"
                                      :content="new_email.content"
                                      @cancelEmail="creating = false"
                                      @emailSent="emailSent"
                        ></email-create>

                        <email-item :email="selected"
                                    v-else
                        ></email-item>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            fetch_url: {
                required: true,
            },
            update_url: {
                required: true,
            },
            current_folder: {
                required: true,
            },
        },
        data() {
            return {
                selected_folder: 0,
                folders: [],
                creating: false,
                selected: {},
                search: '',
                new_email: {
                    to: '',
                    cc: '',
                    subject: '',
                    content: '',
                    default_content: '<br><br> <hr> <br>',
                },
                emails: [],
            }
        },
        methods: {
            emailSent() {
                this.new_email.to = ''
                this.new_email.cc = ''
                this.new_email.subject = ''
                this.new_email.content = ''
            },
            activateEmail(email) {
                _.each(this.emails, function (email) {
                    email.active = 0
                })

                if (email.type === 'inbound') {
                    window.axios.post('/api/emails/' + email.id, {
                        read: 1,
                    }).then(function (response) {
                        email.read = 1
                    })
                }

                email.active = 1

                this.selected = email

                this.creating = false
            },
            createEmail() {
                this.emailSent()

                this.creating = true
            },
            replyToEmail() {
                this.new_email.to = this.selected.from
                this.new_email.cc = ''
                this.new_email.subject = 'Re: ' + this.selected.subject
                this.new_email.content = this.new_email.default_content + this.selected.content

                this.creating = true
            },
            replyAllToEmail() {
                this.new_email.to = window.collect([this.selected.from, this.selected.to]).unique().implode(', ')
                this.new_email.cc = this.selected.cc
                this.new_email.subject = 'Re: ' + this.selected.subject
                this.new_email.content = this.new_email.default_content + this.selected.content

                this.creating = true
            },
            forwardEmail() {
                this.new_email.to = ''
                this.new_email.cc = ''
                this.new_email.subject = 'FW: ' + this.selected.subject
                this.new_email.content = this.new_email.default_content + this.selected.content

                this.creating = true
            },
            moveEmail() {
                let self = this

                window.axios.get('/api/folders')
                    .then(function (response) {
                        self.folders = response.data.data

                        self.$modal.show('move-email-modal')
                    })
            },
            processMoveEmail() {
                let self = this

                if (this.selected_folder != this.current_folder) {
                    window.axios.post('/api/emails/' + this.selected.id, {
                        folder_id: this.selected_folder,
                    }).then(function (response) {
                        self.removeSelectedEmailFromDom()
                    })
                }

                this.$modal.hide('move-email-modal')
            },
            deleteEmail() {
                let self = this

                window.axios.delete('/api/emails/' + this.selected.id + '/delete')
                    .then(function (response) {
                        self.removeSelectedEmailFromDom()
                    })
            },
            restoreEmail() {
                let self = this

                window.axios.post('/api/emails/' + this.selected.id, {
                    deleted_at: null,
                }).then(function (response) {
                    self.removeSelectedEmailFromDom()
                })
            },
            removeSelectedEmailFromDom() {
                let index = this.emails.indexOf(this.selected)

                this.emails.splice(index, 1)

                this.selected = {}
            },
            updateEmails() {
                let self = this

                window.axios.get(self.update_url)
                    .then(function (response) {
                        self.emails = collect(self.emails)
                            .merge(response.data.data)
                            .unique('id')
                            .toArray()
                    })
            },
        },
        mounted() {
            let self = this

            window.axios.get(this.fetch_url)
                .then(function (response) {
                    self.emails = response.data.data
                })

            setInterval(function () {
                self.updateEmails()
            }, 10000)
        },
    }
</script>
