<template>
  <div>
    <Layout>
      <b-container fluid>
        <b-row>
          <b-col
            cols="12"
            sm="6"
            lg="4"
            xl="3"
            v-for="artist in artists"
            :key="artist.id"
          >
            <b-card>
              <b-link
                :href="'https://open.spotify.com/artist/' + artist.spotify_id"
                target="_blank"
              >
                <div class="card-image">
                  <b-img
                    :src="artist.image"
                    class="img-cover"
                    :alt="artist.name"
                  ></b-img>
                </div>
                <h4 class="artist-title">
                  {{ artist.name }}
                </h4>
              </b-link>
            </b-card>
          </b-col>
        </b-row>
      </b-container>
    </Layout>
  </div>
</template>

<script>
export default {
  middleware: ["authenticated"],
  data() {
    return {
      artists: [],
    };
  },
  methods: {
    async getArtists() {
      await this.$axios
        .$get("/artists", {
          token: this.$auth.$storage.getUniversal("token"),
        })
        .then((response) => {
          this.artists = response;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  created() {
    this.getArtists();
  },
};
</script>
<style scope>
.card {
  border: unset;
  margin: 1em 0;
  background-color: unset;
}
.card a:hover {
  text-decoration: none;
}
.card-body {
  background-color: #191919;
  border-radius: 4px;
}
.card-image {
  border-radius: 100%;
  overflow: hidden;
  width: 8em;
  height: 8em;
  margin: auto;
}
.img-cover {
  width: 100%;
  height: 100%;
  object-fit: cover;
}
.artist-title {
  text-align: center;
  color: white;
  font-family: "Raleway", sans-serif;
  margin: 1em 0;
  font-size: 1.3em;
}
</style>
