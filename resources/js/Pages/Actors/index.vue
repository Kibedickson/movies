<template>
  <app-layout>
    <div class="container mx-auto px-4 pt-16">
      <div class="popular-actors">
        <h2 class="uppercase tracking-wider text-orange-500 text-lg font-semibold">Popular Actors</h2>

        <div v-if="!loading" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-8">
          <template v-for="(actor, index) in popularActors" :key="index">
            <div class="actor mt-8">
              <a :href="route('actors.show', actor.id)">
                <img :src="actor.profile_path" :alt="actor.name"
                     class="hover:opacity-75 transition ease-in-out duration-150">
              </a>
              <div class="mt-2">
                <a :href="route('actors.show', actor.id)" class="text-lg hover:text-gray-300">{{ actor.name }}</a>
                <div class="text-sm truncate text-gray-400">{{ actor.known_for }}</div>
              </div>
            </div>
          </template>
        </div>
        <div v-else class="flex items-center justify-center py-24">
          <pulse-loader :loading="loading" :size="size"></pulse-loader>
        </div>
      </div>
      <div class="flex justify-between my-16">
        <button @click="previousActors" class="px-4 py-2 bg-green-400 rounded-md text-base font-semi-bold hover:bg-green-500" v-if="previous">Previous</button>
        <div v-else></div>

        <button @click="nextActors" class="px-4 py-2 bg-green-400 rounded-md text-base font-semi-bold hover:bg-green-500" v-if="next">Next</button>
        <div v-else></div>

      </div>
    </div>
  </app-layout>
</template>

<script>
import {defineAsyncComponent, defineComponent, onMounted, ref} from 'vue'

const AppLayout = defineAsyncComponent(() => import('@/Pages/App'))
const PulseLoader = defineAsyncComponent(() => import('vue-spinner/src/PulseLoader.vue'))

export default defineComponent({
  components: {
    AppLayout, PulseLoader
  },

  setup() {
    const popularActors = ref([])
    const previous = ref(null)
    const next = ref(null)
    const loading = ref(true)
    const size = ref('40px')

    const fetchActors = () => {
      axios.get('api/actors')
          .then(response => {
            loading.value = false
            popularActors.value = response.data.actors
            previous.value = response.data.previous
            next.value = response.data.next
          })
          .catch(error => {
            loading.value = false
            console.log(error.response)
          })
    }

    const previousActors = () => {
      axios.get('api/actors/page/'+ previous.value)
          .then(response => {
            loading.value = false
            popularActors.value = response.data.actors
            previous.value = response.data.previous
            next.value = response.data.next
          })
          .catch(error => {
            loading.value = false
            console.log(error.response)
          })
    }

    const nextActors = () => {
      axios.get('api/actors/page/'+ next.value)
          .then(response => {
            loading.value = false
            popularActors.value = response.data.actors
            previous.value = response.data.previous
            next.value = response.data.next
          })
          .catch(error => {
            loading.value = false
            console.log(error.response)
          })
    }

    onMounted(() => {
      fetchActors()
    })

    return {
      popularActors, loading, size, previous, next, previousActors, nextActors
    }
  }
})
</script>
