<template>
        <b-button
       v-on:click="login"
        variant="primary"
      >
      {{ title }}
      </b-button>
</template>

<script>
    let querystring = require('querystring');
export default {
  props: ['title'],
  data: function () {
    return {
      scope: "user-read-email user-read-recently-played user-read-playback-state user-top-read user-read-currently-playing user-follow-read user-library-read",
      client_id: "0c87a32019d0420191e2a23fa09bfb05",
      redirect_uri: "http://localhost:8000/authenticate",
      state: this.generateRandomString(16)
    }
  },
  methods: {
   
      login: function () {
         console.log(this.redirect_uri)
         window.location.replace("https://accounts.spotify.com/authorize?" + 
         querystring.stringify({
       response_type: 'code',
       client_id: this.client_id,
       scope: this.scope,
       redirect_uri: this.redirect_uri,
       state: this.state
       }))
    },
     generateRandomString: function(length){
    let text = '';
    let possible = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

    for (let i = 0; i < length; i++) {
      text += possible.charAt(Math.floor(Math.random() * possible.length));
    }
    return text;
  },
  async getKeys() {
    await this.$axios.$get('/api/auth/keys')
    .then(response => {
      this.redirect_uri = response.callback
      this.scope = response.scope
      this.client_id = response.client_id
      })
      .catch(error => {
        console.log(error)
      })
  
  }
}, created() {
  //  this.getKeys()
},
 
}
</script>