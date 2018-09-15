<template>
    <div :class="classes" role="alert">
        {{ this.message.body }}
    </div>
</template>

<script>
export default {
    props: ['message'],
    computed: {
        classes() {
            return ['alert', `alert-${this.message.type}`]
        }
    }
}
</script>
