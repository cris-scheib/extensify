<template>
  <div>
    <Layout>
      <b-container fluid class="pb-2">
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
              <b-link
                :href="'https://open.spotify.com/track/' + track.spotify_id"
                target="_blank"
              >
                <h3 class="text-white">{{ track.name }}</h3>
              </b-link>
              <b-link
                :href="
                  'https://open.spotify.com/artist/' + track.artist.spotify_id
                "
                target="_blank"
              >
                <p class="artist-track">{{ track.artist.name }}</p>
              </b-link>
              <b-badge
                v-for="genre in track.artist.genres"
                :key="genre.id"
                variant="dark"
                >{{ genre.name }}</b-badge
              >
            </div>
          </b-card>
        </div>
      </b-container>
    </Layout>
  </div>
</template>

<script>import Layout from "../partials/Layout";
export default {
  components: { Layout },
  data() {
    return {
      tracks: [],
    };
  },
  methods: {
    getTracks() {
      this.$api
        .get("/tracks")
        .then((response) => {
          this.tracks = response.data;
        })
        .catch(({ response }) => {
          if (response.status === 401) {
            this.$router.push("/unauthorized");
          }
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
  max-height: 9em;
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
.badge.badge-dark {
  background-color: #138a3d;
  padding: 0.3rem 0.5rem;
  border-radius: 1rem;
  margin: 0 0.2rem;
}
</style>