<template>
  <div class="sidebar" v-bind:class="{ colapsed: colapsed }">
    <nav>
      <b-nav vertical>
        <h3 class="title">Extesify</h3>
        <b-button class="btn-sidebar" @click="colapsed = !colapsed">
          <b-icon v-if="colapsed" icon="chevron-double-right"></b-icon>
          <b-icon v-else icon="chevron-double-left"></b-icon>
        </b-button>
        <b-nav-item to="dashboard">Dashboard</b-nav-item>
        <b-nav-item to="favorite-artists">Favorite Artists</b-nav-item>
        <b-nav-item to="favorite-tracks">Favorite Tracks</b-nav-item>
        <b-nav-item to="followed-artists">Followed Artists</b-nav-item>
        <b-nav-item to="recommendations">Recommendations</b-nav-item>
        <b-nav-item to="history">History</b-nav-item>
      </b-nav>
    </nav>
  </div>
</template>

<script>
export default {
  data() {
    return {
      colapsed: false,
    };
  },
};
</script>

<style scoped>
.sidebar {
  background-color: #0a0a0a;
  width: 13rem;
  position: fixed;
  height: 100vh;
  transition: all ease-in-out 2s;
}
.nav-link {
  color: white;
  padding: 1rem 1rem;
  font-family: "Montserrat", sans-serif;
}
.title {
  color: white;
  padding: 0.5em;
  font-family: "Raleway", sans-serif;
  font-size: 1.5em;
}
.btn-sidebar {
  position: absolute;
  right: 0em;
  top: 0em;
  background-color: #121212;
  border: unset;
  height: 54px;
  border-radius: unset;
  width: 50px;
  display: flex;
  justify-content: center;
  align-items: center;
}
.sidebar.colapsed {
  left: -158px;
}
</style>