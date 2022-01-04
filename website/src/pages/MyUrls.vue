<template class="pt-6">
<h1 class="text-white mb-8">
<a href="#">your urls</a>
</h1>
<table class="table-auto text-base text-white mx-auto">
<tr>
  <th>tiny url</th>
  <th>url</th>
  <th>created</th>
  <th>actions</th>
</tr>

<tr v-for="url in urls" :key="urls.id" class="mt-4">
  <td @click="copy(this.parseUrl(url.token))" class="hover:bg-blue-700" style="cursor:pointer;">{{parseUrl(url.token)}}</td>
  <td @click="copy(url.url)" class="hover:bg-blue-700" style="cursor:pointer;">{{url.url}}</td>
  <td>{{parseDate(url.created_at)}}</td>
  <td><a href="#" class="text-teal-200">Update</a></td>
</tr>

</table>
</template>

<style>
td {
  @apply p-4
}
</style>

<script>
import api from '../services/API'
import axios from 'axios'
import { DateTime } from 'luxon'

export default {
  data: function() {
    return {
      urls: [],
    }
  },
  methods: {
    copy(token) {
       navigator.clipboard.writeText(token);
    },
    parseUrl(token) {
      return window.location.host + "/" + token
    },
    parseDate(date) {
      console.log(date)
      return DateTime.fromISO(date).toLocaleString()
    }
  },
  mounted: function() {
    let r = api.get('/urls')
    .catch( e => console.log(e))
    .then(r => this.urls = r.data)
    console.log(r.data)
  }
}
</script>
