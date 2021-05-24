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
              <div @click="followUnfollow(artist)" class="follow-action">
                <b-icon
                  icon="heart-fill"
                  :class="artist.follow ? 'heart-icon' : 'heart-icon-follow'"
                  tabindex="0"
                  v-b-tooltip.hover
                  :title="artist.follow ? 'Unfollow' : 'Follow'"
                ></b-icon>
              </div>
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
import Layout from "../partials/Layout";
export default {
  components: { Layout },
  data() {
    return {
      artists: [],
    };
  },
  methods: {
    getArtists() {
      this.$api
        .get("/followed/artists")
        .then((response) => {
          this.artists = response.data;
        })
        .catch(({ response }) => {
          console.log(response);
        });
    },
    followUnfollow(artist) {
      this.$api
        .post(artist.follow ? "/followed/unfollow" : "/followed/follow", {
          artist: artist.spotify_id,
        })
        .then(() => {
          const index = this.artists.findIndex((x) => x.id === artist.id);
          this.artists[index].follow = !this.artists[index].follow;
        })
        .catch(({ response }) => {
          console.log(response);
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
  border: unset !important;
  margin: 1em 0;
  background-color: unset;
}
.card a:hover {
  text-decoration: none;
}
.card-body {
  background-color: #191919;
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
  font-size: 1.25em;
}
.follow-action {
  position: absolute;
  top: 0.8em;
  right: 0.8em;
  cursor: pointer;
}
.heart-icon:focus,
.heart-icon-follow:focus,
.follow-action:focus {
  outline: unset;
}
.heart-icon,
.heart-icon-follow:hover {
  color: #1abd53;
}
.heart-icon:hover,
.heart-icon-follow {
  color: #1b3d27;
}
</style>
