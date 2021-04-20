<template>
  <div></div>
</template>

<script>
export default {
  methods: {
    logout() {
      this.$api
        .get("/auth/logout")
        .then(() => {
          localStorage.clear();
          this.$router.push("/unauthorized");
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  created() {
    this.logout();
  },
};
</script>