<template>
  <div>
    <Sidebar />
    <main>
      <header>
        <div class="d-flex">
          <b-dropdown id="dropdown-header" class="m-2">
            <template #button-content>
              <b-icon icon="star-fill" class="star-fill"></b-icon> {{ user }}
            </template>
            <b-dropdown-item :href="me" target="_blank">
              Account
              <b-icon icon="box-arrow-up-right" class="account-icon"></b-icon>
            </b-dropdown-item>
            <b-dropdown-item to="settings">Settings</b-dropdown-item>

            <b-dropdown-item to="logout">Logout</b-dropdown-item>
          </b-dropdown>
        </div>
      </header>

      <slot />

      <footer></footer>
    </main>
  </div>
</template>

<script>
import Sidebar from "./Sidebar.vue";
export default {
  components: { Sidebar },
  data() {
    return {
       user: localStorage.getItem("name"),
      image: localStorage.getItem("image"),
      id: localStorage.getItem("id"),
      me:
        "https://open.spotify.com/user/" +
        localStorage.getItem("id"),
    };
  },
};
</script>

<style scoped>
.btn {
  border-radius: 500px;
  padding: 0.4rem 1.5rem;
}
main {
  height: 100vh;
  margin-left: 13em;
  font-family: "Montserrat", sans-serif;
}
header {
  background-color: #181818;
}
#dropdown-header {
  margin-left: auto !important;
  margin-right: 1em !important;
}
.star-fill {
  color: #ffd700;
  width: 0.5em;
}
.account-icon {
  font-size: 1em !important;
  margin-left: 0.5em;
}
</style>