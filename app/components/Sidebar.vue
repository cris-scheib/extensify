<template>
     <nav>
        <b-nav vertical>
        <b-nav-item to="dashboard">Dashboard</b-nav-item>
        </b-nav>

       </nav>
</template>

<script>
export default {

}
</script>

<style scoped>
nav {
  height: 100vh;
  display: flex;
  position: absolute;
  top: 0;
  left: 0;
}
.nav {
      background-color: #0a0a0a;
    width: 13rem;
}
.nav-link {
  color: white;
  padding: 1rem 1rem;
}
</style>