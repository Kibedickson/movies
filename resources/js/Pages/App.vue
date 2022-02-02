<template>
    <Nav></Nav>
    <main>
        <slot></slot>
    </main>
</template>
<script>
import Nav from '../Components/Nav.vue'
import { defineComponent } from 'vue'

export default defineComponent({
    components: {
        Nav
    },
    setup() {

        return {

        }
    }
})

</script>
