<template>
    <div class="o-page__sidebar js-page-sidebar border-top-blue">
        <div class="c-sidebar c-sidebar--light">
            <a class="c-sidebar__brand" href="#">
                <img class="c-sidebar__brand-img" src="/img/logo.png" alt="Logo"> Send
            </a>

            <h4 class="c-sidebar__title">Email

                <a class="u-pl-small">
                    <i class="fa fa-plus u-mr-xsmall" title="Add Folder" @click="showModal"></i>
                </a>
            </h4>

            <ul class="c-sidebar__list">
                <li class="c-sidebar__item">
                    <a class="c-sidebar__link"
                       href="/"
                       :class="{'is-active': current == 'emails'}"
                    >
                        <i class="fa fa-envelope u-mr-xsmall"></i>

                        Inbox
                    </a>
                </li>

                <transition-group v-on:enter="slideFadeIn" v-on:leave="fadeSlideOut">
                    <li class="c-sidebar__item" v-for="folder in orderBy(folders, 'name')" :key="folder.id">
                        <a class="c-sidebar__link"
                           :href="'/emails/' + folder.slug"
                           :class="{'is-active': current == 'emails/' + folder.slug}"
                        >
                            <i class="fa fa-envelope u-mr-xsmall u-pl-medium"></i>

                            {{ folder.name }} <span></span>
                        </a>
                    </li>
                </transition-group>

                <li class="c-sidebar__item">
                    <a class="c-sidebar__link"
                       href="/emails/sent"
                       :class="{'is-active': current == 'emails/sent'}"
                    >
                        <i class="fa fa-paper-plane u-mr-xsmall"></i>

                        Sent
                    </a>
                </li>

                <li class="c-sidebar__item">
                    <a class="c-sidebar__link"
                       href="/emails/trash"
                       :class="{'is-active': current == 'emails/trash'}"
                    >
                        <i class="fa fa-trash u-mr-xsmall"></i>

                        Trash
                    </a>
                </li>

                <li class="c-sidebar__item">
                    <a class="c-sidebar__link" href="/calendar">
                        <i class="fa fa-calendar u-mr-xsmall"></i>

                        Calendar
                    </a>
                </li>

                <li class="c-sidebar__item">
                    <a class="c-sidebar__link" href="/logout">
                        <i class="fa fa-sign-in u-mr-xsmall"></i>

                        Sign out
                    </a>
                </li>
            </ul>
        </div><!-- // .c-sidebar -->

        <modal name="addFolder"
               :adaptive="true"
               height="auto"
               classes="u-bg-white u-pv-small u-ph-small"
               :pivotY="0.2"
        >
            <form @submit.prevent="saveFolder">
                <div class="row">
                    <div class="col-sm-12 u-text-center">
                        Add Folder
                    </div>

                    <div class="col-sm-12 u-text-center u-pt-small">
                        <input class="c-input" v-model="newFolderName" placeholder="Folder Name" autofocus>
                    </div>

                    <div class="col-sm-12 u-text-center u-pt-small">
                        <button type="submit" class="c-btn c-btn--success c-btn--fullwidth">
                            <i class="fa fa-check u-mr-xsmall"></i> Save
                        </button>
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
            </form>
        </modal>
    </div><!-- // .o-page__sidebar -->
</template>

<script>
    export default {
        props: {
            user: {
                required: true,
            },
            current: {
                required: true,
            },
        },
        methods: {
            showModal() {
                this.$modal.show('addFolder')
            },
            saveFolder() {
                let self = this

                window.axios.post('/api/folders', {
                    'name': this.newFolderName,
                })
                    .then(function (response) {
                        self.folders = response.data.data

                        self.$modal.hide('addFolder')

                        self.newFolderName = ''
                    })
                    .catch(function (error) {
                        if (error.response && error.response.data) {
                            self.errors = error.response.data.errors
                        }
                    })
            },
            getFolders() {
                let self = this

                window.axios.get('/api/folders')
                    .then(function (response) {
                        self.folders = response.data.data
                    })
            },
        },
        data() {
            return {
                folders: [],
                newFolderName: '',
                errors: false,
            }
        },
        mounted() {
            this.getFolders()
        },
    }
</script>
