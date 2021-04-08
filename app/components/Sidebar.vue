<template>
  <nav>
    <b-nav vertical>
      <h3 class="title">Extesify</h3>
      <b-nav-item to="dashboard">Dashboard</b-nav-item>
      <b-nav-item to="artists">Artists</b-nav-item>
      <b-nav-item to="tracks">Tracks</b-nav-item>
    </b-nav>
  </nav>
</template>

<script>
export default {};
</script>

<style scoped>
.nav {
  background-color: #0a0a0a;
  width: 13rem;
  position: fixed;
  height: 100vh;
}
.nav-link {
  color: white;
  padding: 1rem 1rem;
}
.title {
  color: white;
  padding: 0.5em;
  font-family: "Raleway", sans-serif;
}
</style>