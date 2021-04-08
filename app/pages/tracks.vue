<template>
  <div>
    <Layout>
      <b-container fluid>
        <div
          cols="12"
          sm="6"
          lg="4"
          xl="3"
          v-for="track in tracks"
          :key="track.id"
        >
          <b-card
            :img-src="track.artist.image"
            :img-alt="track.artist.name"
            img-left
            class="mb-3"
          >
            <div>
              <h3>{{ track.name }}</h3>
              <p class="artist-track">{{ track.artist.name }}</p>
            </div>
          </b-card>
        </div>
      </b-container>
    </Layout>
  </div>
</template>

<script>
export default {
  middleware: ["authenticated"],
  data() {
    return {
      tracks: [],
    };
  },
  methods: {
    async getTracks() {
      await this.$axios
        .$get("/tracks")
        .then((response) => {
          this.tracks = response;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  created() {
    this.getTracks();
  },
};
</script>

<style scope>
.card-img-left {
  max-height: 6em;
}
.card {
  color: white;
  font-family: "Raleway", sans-serif;
  font-size: 1.3em;
}
.artist-track {
  color: #1abd53;
  font-size: 0.9em;
  font-weight: 300;
}
</style>