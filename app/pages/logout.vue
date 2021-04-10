<template></template>

<script>
export default {
  methods: {
    async setToken() {
      await this.$axios
        .$post("/logout")
        .then((response) => {
          this.$auth.$storage.setUniversal("token", null);
          this.$auth.$storage.setUniversal("name", null);
          this.$auth.$storage.setUniversal("image", null);
          this.$auth.$storage.setUniversal("id", null);
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  created() {
    this.setToken();
    this.$router.push("/");
  },
};
</script>