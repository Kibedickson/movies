<template>
  <app-layout>
    <div class="container mx-auto px-4 pt-16">
      <div class="popular-movies">
        <h2 class="uppercase tracking-wider text-orange-500 text-lg font-semibold">Popular Movies</h2>

        <div v-if="!loading" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
          <template v-for="(tv, index) in popularTvs" :key="index">
            <TvsCard :tv="tv"></TvsCard>
          </template>
        </div>
        <div v-else class="flex items-center justify-center py-24">
          <pulse-loader :loading="loading" :size="size"></pulse-loader>
        </div>
      </div>
      <div class="now-playing-movies py-24">
        <h2 class="uppercase tracking-wider text-orange-500 text-lg font-semibold">Now Playing</h2>
        <div v-if="!loading" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
          <template v-for="(tv, index) in topRatedTvs" :key="index">
            <TvsCard :tv="tv"></TvsCard>
          </template>
        </div>
        <div v-else class="flex items-center justify-center py-24">
          <pulse-loader :loading="loading" :size="size"></pulse-loader>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import {defineAsyncComponent, defineComponent, onMounted, ref} from 'vue'

const AppLayout = defineAsyncComponent(() => import('@/Pages/App'))
const TvsCard = defineAsyncComponent(() => import('@/Components/TvsCard'))
const PulseLoader = defineAsyncComponent(() => import('vue-spinner/src/PulseLoader.vue'))

export default defineComponent({
  components: {
    AppLayout, TvsCard, PulseLoader
  },

  setup() {
    const popularTvs = ref([])
    const topRatedTvs = ref([])
    const loading = ref(true)

    const size = ref('40px')

    onMounted(() => {
      axios.get('/api/tvs')
          .then(response => {
            loading.value = false
            console.log(response.data)
            popularTvs.value = response.data.popularTvs
            topRatedTvs.value = response.data.topRatedTvs
          })
          .catch(error => {
            loading.value = false
            console.log(error.response)
          })
    })

    return {
      popularTvs,
      topRatedTvs,
      loading,
      size,
    }
  }
})
</script>
