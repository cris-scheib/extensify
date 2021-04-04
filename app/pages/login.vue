<template>
 
</template>

<script>
let querystring = require('querystring');
export default {
  middleware: ['authorize'],
  methods: {
    async getToken() {
     await this.$axios.$post('/auth', {
           code: this.$route.query.code
         })
    .then(response => {
      this.$auth.$storage.setUniversal('token', response.token)
      this.$auth.$storage.setUniversal('name', response.name)
      this.$auth.$storage.setUniversal('image', response.image)
      this.$auth.$storage.setUniversal('id', response.id)
      
      })
      .catch(error => {
        console.log(error)
      })
    }
  },
  created() {
     if(this.$route.query.code != undefined && this.$route.query.code != null){
        this.getToken()
     }
     this.$router.push("/dashboard")
  },
}

 
</script>