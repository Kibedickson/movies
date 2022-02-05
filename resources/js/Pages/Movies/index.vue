<template>
  <app-layout>
    <div class="container mx-auto px-4 pt-16">
      <div class="popular-movies">
        <h2 class="uppercase tracking-wider text-orange-500 text-lg font-semibold">Popular Movies</h2>

        <div v-if="!loading" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
          <template v-for="(movie, index) in popularMovies" :key="index">
            <MoviesCard :movie="movie"></MoviesCard>
          </template>
        </div>
        <div v-else class="flex items-center justify-center py-24">
          <pulse-loader :loading="loading" :size="size"></pulse-loader>
        </div>
      </div>
      <div class="now-playing-movies py-24">
        <h2 class="uppercase tracking-wider text-orange-500 text-lg font-semibold">Now Playing</h2>
        <div v-if="!loading" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
          <template v-for="(movie, index) in nowPlayingMovies" :key="index">
            <MoviesCard :movie="movie"></MoviesCard>
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
const MoviesCard = defineAsyncComponent(() => import('@/Components/MoviesCard'))
const PulseLoader = defineAsyncComponent(() => import('vue-spinner/src/PulseLoader.vue'))

export default defineComponent({
  components: {
    AppLayout, MoviesCard, PulseLoader
  },

  setup() {
    const popularMovies = ref([])
    const nowPlayingMovies = ref([])
    const loading = ref(true)

    const size = ref('40px')

    onMounted(() => {
      axios.get('/api/movies')
          .then(response => {
            loading.value = false
            popularMovies.value = response.data.popularMovies
            nowPlayingMovies.value = response.data.nowPlayingMovies
          })
          .catch(error => {
            loading.value = false
            console.log(error.response)
          })
    })

    return {
      popularMovies,
      nowPlayingMovies,
      loading,
      size,
    }
  }
})
</script>
