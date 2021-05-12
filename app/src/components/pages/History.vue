<template>
  <div>
    <Layout>
      <b-container fluid class="pb-2">
        <div class="d-flex justify-content-end mt-3">
          <b-pagination
            v-model="currentPage"
            :total-rows="rows"
            :per-page="perPage"
            aria-controls="my-table"
          ></b-pagination>
        </div>

        <b-table
          striped
          hover
          class="history-content"
          :items="history"
          :fields="fields"
        >
          <template #cell(track)="data">
            <a
              :href="
                'https://open.spotify.com/track/' + data.item.track_spotify
              "
              target="_blank"
              class="spotify-link"
              >{{ data.value }}</a
            >
          </template>
          <template #cell(artist)="data">
            <a
              :href="
                'https://open.spotify.com/artist/' + data.item.artist_spotify
              "
              target="_blank"
              class="spotify-link"
              >{{ data.value }}</a
            >
          </template>
        </b-table>
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
      history: [],
      fields: [],
      currentPage: 1,
      rows: null,
      perPage: null,
    };
  },
  watch: {
    currentPage: function () {
      this.getHistory();
    },
  },
  methods: {
    getHistory() {
      this.$api
        .get("/history?page=" + this.currentPage)
        .then((response) => {
          console.log(response.data);
          this.history = response.data.data;
          this.fields = ["date", "track", "artist"];
          this.rows = response.data.total;
          this.currentPage = response.data.current_page;
          this.perPage = response.data.per_page;
        })
        .catch(({ response }) => {
          if (response.status === 401) {
            this.$router.push("/unauthorized");
          }
        });
    },
  },
  created() {
    this.getHistory();
  },
};
</script>

<style scope>
.history-content td,
.history-content th {
  color: white;
}
.history-content .spotify-link {
  color: #1abd53;
}
.history-content .spotify-link:hover {
  text-decoration: none;
  color: #169944;
}
.page-link {
  background-color: transparent !important;
  border-color: #4e4e4e !important;
  border-radius: unset !important;
}

.page-item .page-link {
  color: white !important;
}
.page-item.active {
  background-color: white;
}
.page-item.active .page-link {
  color: #121212 !important;
  border-color: white !important;
}
</style>