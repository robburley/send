<template>
    <div class="u-p-small u-border-bottom u-border-right">
        <div class="c-field has-icon-right">
            <input class="c-input"
                   type="text"
                   placeholder="Search"
                   :value="search"
                   @input="updateValue($event.target.value)"
            >

            <span class="c-field__icon">
                <i class="fa fa-search"></i>
            </span>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['search'],
        methods: {
            updateValue(value) {
                this.$emit('input', value)
            },
        },
        mounted() {
        },
    }
</script>
