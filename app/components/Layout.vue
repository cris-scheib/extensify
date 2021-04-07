<template>
    <div>
    <Sidebar />
    <main>
      <header>
          <div class="d-flex">
            <b-dropdown id="dropdown-header" :text="user" class="m-md-2">
                <b-dropdown-item>Account <b-icon icon="box-arrow-up-right"></b-icon></b-dropdown-item>
                <b-dropdown-item>Logout</b-dropdown-item>
            </b-dropdown>
            </div>
      </header>
      
        <slot />
     
      <footer></footer>
      </main>
    </div>
</template>

<script>
import Sidebar from './Sidebar.vue'
export default {
  components: { Sidebar },
  data() {
      return {
          user:  this.$auth.$storage.getUniversal('name'),
          image: this.$auth.$storage.getUniversal('image'),
          id: this.$auth.$storage.getUniversal('id')
      }
  },

}
</script>

<style scoped>

main{
        height: 100vh;
    margin-left: 13em;
}
header{
    background-color: #181818;
}
#dropdown-header{    
    margin-left: auto !important;
    margin-right: 1em !important;
}

</style>