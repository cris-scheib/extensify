<template>
  <div></div>
</template>

<script>
const querystring = require("querystring");
export default {
  methods: {
    getToken() {
      this.$api
        .post("/auth/", {
          code: this.$route.query.code,
        })
        .then((response) => {
          localStorage.setItem("user", response.data.user);
          localStorage.setItem("name", response.data.name);
          localStorage.setItem("id", response.data.id);
          localStorage.setItem("image", response.data.image);
          localStorage.setItem("product", response.data.product);
          this.$router.push("/dashboard");
        })
        .catch(() => {
          this.$router.push("/unauthorized");
        });
    },
  },
  created() {
    if (this.$route.query.code === undefined) {
      let state = "";
      const possible =
        "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

      for (let i = 0; i < 16; i++) {
        state += possible.charAt(Math.floor(Math.random() * possible.length));
      }

      window.location.href =
        "https://accounts.spotify.com/authorize?" +
        querystring.stringify({
          response_type: "code",
          client_id: process.env.VUE_APP_CLIENT_ID,
          scope: process.env.VUE_APP_SCOPE,
          redirect_uri: process.env.VUE_APP_REDIRECT_URI,
          state: state,
        });
    }
    if (this.$route.query.code != undefined && this.$route.query.code != null) {
      this.getToken();
    }
  },
};
</script>