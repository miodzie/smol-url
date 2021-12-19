<template>
  <div 
    class="flex flex-col max-w-xl p-4 m-auto space-y-4">
    <span 
      class="font-mono text-red-50 bg-red-400 p-1.5"
      v-if="hasError">{{ error }}</span>
    <input 
      @keyup.enter="createURL"
      placeholder="https://example.com"
      class="border border-gray-200  bg-gray-100 shadow-sm
      font-mono focus:outline-green-200 focus:bg-white "
      v-model="url" />
    <button 
      @click="createURL"
      :disabled="creating"
      type="button" 
      class="p-3 bg-green-500 hover:bg-green-600 active:bg-green-400 text-white
      font-mono  border-black shadow-lg
        disabled:opacity-50
      ">
      {{ buttonText }}
    </button>
  </div>
  <span class="text-sm p-0 font-light font-mono text-gray-200">or cmd+v/ctrl+v</span>
</template>

<script>
import api from '../services/API.js'

export default {
  data: function() {
    return {
      creating: false,
      url: '',
      error: '',
    };
  },
  mounted: function() {
    document.addEventListener('paste', (event) => {
      if(event.target.type == 'text') {
        return
      }
      this.url = event.clipboardData.getData('Text')
      if (this.url.length != 0) {
        this.createURL()
      }
    })
  },
  computed: {
    hasError() {
      return this.error.length > 0
    },
    buttonText() {
      return this.creating ? '...' : 'create'
    }
  },
  methods: {
    createURL() {
      this.error = '';
      this.creating = true
      let data = {
        url: this.url,
      }
      api.post('tiny-url', data).then(r => {
        console.log(r)
      })
      .catch(e => {
          this.error = "someting brokedez oops" 
          console.log(e)
        })
      .finally(() => {
        setTimeout(() => this.creating = false, 1500)
      })
    }
  }
}
</script>

