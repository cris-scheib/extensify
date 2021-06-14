<template>
<div class="fixed-navbar">
  <b-navbar toggleable="lg" type="dark">
    <b-navbar-brand to="/" class="">Extensify</b-navbar-brand>

    <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

    <b-collapse id="nav-collapse" is-nav>
      <b-navbar-nav class="m-auto">
       <!-- <b-nav-item to="/">Home</b-nav-item> -->
        <!-- <b-nav-item to="/about">About</b-nav-item> -->
        <!-- <b-nav-item to="/documentation">Documentation</b-nav-item> -->
      </b-navbar-nav>

      <!-- Right aligned nav items -->
      
    </b-collapse>
  </b-navbar>
</div>

</template>

<style>

.fixed-navbar{
    background-color: transparent;
    z-index: 1;
     position: fixed;
    width: 100%;
}
</style>
