<template>
  <div>
  <Navbar />
  <div class="container">
    <div>
       <Logo />
      <h1 class="title">
        app
      </h1>
      <div class="links">
       <b-button
       v-on:click="login"
        variant="primary"
      >
      Login
      </b-button>
      </div>
    </div>
  </div>
  </div>
</template>

<script>
var querystring = require('querystring');
export default {
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

<style>
.container {
  margin: 0 auto;
  min-height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  text-align: center;
}

.title {
  font-family:
    'Quicksand',
    'Source Sans Pro',
    -apple-system,
    BlinkMacSystemFont,
    'Segoe UI',
    Roboto,
    'Helvetica Neue',
    Arial,
    sans-serif;
  display: block;
  font-weight: 300;
  font-size: 100px;
  color: #35495e;
  letter-spacing: 1px;
}

.subtitle {
  font-weight: 300;
  font-size: 42px;
  color: #526488;
  word-spacing: 5px;
  padding-bottom: 15px;
}

.links {
  padding-top: 15px;
}
</style>
