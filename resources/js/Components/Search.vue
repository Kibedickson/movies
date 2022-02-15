<template>
  <div class="relative mt-3 md:mt-0" @click.away="isOpen = false">
    <input
        v-model="search"
        type="text"
        class="bg-gray-800 text-sm rounded-full w-64 px-4 pl-8 py-1 focus:outline-none focus:shadow-outline"
        placeholder="Search (Press '/' to focus)"
        ref="searchInput"
        @keydown="submit"
    >
    <div class="absolute top-0">
      <svg class="fill-current w-4 text-gray-500 mt-2 ml-2" viewBox="0 0 24 24">
        <path class="heroicon-ui"
              d="M16.32 14.9l5.39 5.4a1 1 0 01-1.42 1.4l-5.38-5.38a8 8 0 111.41-1.41zM10 16a6 6 0 100-12 6 6 0 000 12z"/>
      </svg>
    </div>

    <div v-if="loading" class="spinner top-0 right-0 mr-4 mt-3"></div>

    <div
        v-if="search.length > 3 && !loading"
        class="z-50 absolute bg-gray-800 text-sm rounded-md w-64 mt-4 transition ease-in-out duration-150"
        v-show="isOpen"
    >
      <ul v-if="results.length > 0">
        <li v-for="(result, index) in results" :key="index" class="border-b border-gray-700">
          <a
              :href="result.title ? route('movies.show', result.id) : route('tvs.show', result.id)"
              class="block hover:bg-gray-700 px-3 py-3 flex items-center transition ease-in-out duration-150"
          >
            <img v-if="result.poster_path" :src="`https://image.tmdb.org/t/p/w92/${ result.poster_path }`"
                 alt="title" class="w-8">
            <img v-else src="https://via.placeholder.com/50x75" alt="poster" class="w-8">
            <span class="ml-4">{{ result.title ? result.title : result.name }}</span>
          </a>
        </li>

      </ul>
      <div v-else class="px-3 py-3">No results for "{{ search }}"</div>
    </div>
  </div>
</template>

<script>
import {defineComponent, ref} from 'vue'
import _ from 'lodash'

export default defineComponent({
  setup() {
    const search = ref('')

    const results = ref([])

    const isOpen = ref(false)

    const loading = ref(false)

    const searchInput = ref()

    const events = (e) => {
      if (e.key === "/") {
        e.preventDefault()
        searchInput.value.focus();
      }
      if (e.key === "Escape") {
        e.preventDefault()
        isOpen.value = false
      }
    }

    return {
      search, results, isOpen, searchInput, loading, events
    }
  },
  methods: {
    submit: _.debounce(function () {
      if (this.search.length > 3) {
        this.loading = true
        axios.post(`/api/search?search=${this.search}`)
            .then(response => {
              this.results = response.data
              this.loading = false
              this.isOpen = true
            })
            .catch(error => {
              this.loading = false
              console.log(error)
            })
      }
    }, 600)
  },

  created() {
    document.addEventListener('keydown', (e) => this.events(e))
  },
  destroyed() {
    document.removeEventListener('keydown', (e) => this.events(e))
  }
})
</script>