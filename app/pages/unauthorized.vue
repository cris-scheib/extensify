<template>
  <div>
    <Navbar />
    <div class="banner">
      <div class="banner-content">
        <div class="center">
          <h1 class="banner-title">401</h1>
          <h3 class="banner-subtitle warning">
            Ops, it looks like you are not authenticated
          </h3>
        </div>
        <h3 class="banner-subtitle">
          Please try to login to the system and try again
        </h3>
        <div class="actions">
          <NuxtLink class="btn btn-primary" target="_blank" to="/login"
            >Login</NuxtLink
          >
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {};
</script>
<style>
.banner-title {
  font-size: 8em;
}
.warning {
  font-size: 2em;
  max-width: 60%;
}
.center {
  display: flex;
  justify-content: center;
  align-items: center;
}
</style>

