<template>
<div>
  <b-navbar toggleable="lg" type="dark">
    <b-navbar-brand to="/" class="position-absolute">Extensify</b-navbar-brand>
    <b-navbar-nav class="m-auto">
        <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>
            
        <b-nav-item to="/">Home</b-nav-item>
        <b-nav-item to="/contact">Contato</b-nav-item>
        <b-nav-item to="/about">About</b-nav-item>
        <b-nav-item to="/documentation">Documentation</b-nav-item>
        
    </b-navbar-nav>
  </b-navbar>
</div>
</template>

<style>
.navbar{
    background-color: transparent;
    z-index: 1;
}
</style>
