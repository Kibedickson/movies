<template>
    <Nav></Nav>
    <main>
        <slot></slot>
    </main>
</template>
<script>
import { defineComponent, defineAsyncComponent } from 'vue'
const Nav = defineAsyncComponent(() => import("@/Components/Nav"))

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
