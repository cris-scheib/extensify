<template>
  <div>
    <Layout>
      <b-container fluid class="pb-2 settings">
        <div class="d-flex justify-content-end mt-4 mb-4">
          <h4 class="title">Settings</h4>
          <b-button @click="synchronize" type="button" variant="primary"
            >Save</b-button
          >
        </div>
        <p>
          You can configure the synchronization and data cycles that will be
          brought from Spotify
        </p>
        <b-form v-if="loaded">
          <div class="d-flex">
            <label class="mt-4" for="input-0">
              {{ settings[0].name }} <br />
              <small>
                Time cycle that the application will take to synchronize the
                data with Spotify
              </small>
            </label>
            <b-form-select
              id="input-0"
              class="mt-4"
              :options="periods"
              v-model="settings[0].value"
            ></b-form-select>
          </div>

          <div class="d-flex">
            <label class="mt-4" for="input-1">
              {{ settings[1].name }} <br />
              <small>
                Value deliver to spotify that will identify the period to be
                evaluated for rating of favorites artists
              </small>
            </label>
            <b-form-select
              id="input-1"
              class="mt-4"
              :options="terms"
              v-model="settings[1].value"
            ></b-form-select>
          </div>

          <div class="d-flex">
            <label class="mt-4" for="input-2">
              {{ settings[2].name }} <br />
              <small>
                Value deliver to spotify that will identify the period to be
                evaluated for rating of favorite tracks
              </small>
            </label>
            <b-form-select
              id="input-2"
              class="mt-4"
              :options="terms"
              v-model="settings[2].value"
            ></b-form-select>
          </div>
        </b-form>
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
      loaded: false,
      settings: [],
      terms: [
        { text: "Short term", value: 0 },
        { text: "Medium term", value: 1 },
        { text: "Long term", value: 2 },
      ],
      periods: [
        { text: "10 minutes", value: 10 },
        { text: "30 minutes", value: 30 },
        { text: "1 hour", value: 60 },
        { text: "3 hours", value: 180 },
        { text: "8 hours", value: 480 },
        { text: "24 hours", value: 1440 },
      ],
    };
  },
  methods: {
    getSettings() {
      this.$api
        .get("/settings")
        .then((response) => {
          this.settings = response.data;
          this.loaded = true;
        })
        .catch(({ response }) => {
          if (response.status === 401) {
            this.$router.push("/unauthorized");
          }
        });
    },
    synchronize() {
      this.$api
        .post("/settings", { settings: this.settings })
        .then(() => {
          this.makeToast("Setting updated with success");
        })
        .catch(() => {
          this.makeToast("Error updating the settings");
        });
    },
    makeToast(message) {
      this.$bvToast.toast(message, {
        title: message.split(" ")[0] === "Error" ? "Error" : "Success",
        variant: "secondary",
        solid: true,
      });
    },
  },
  created() {
    this.getSettings();
  },
};
</script>

<style scope>
.settings .title {
  font-family: "Raleway", sans-serif;
  font-size: 1.5em;
  color: white;
  margin-right: auto;
}

.settings small {
  font-size: 100%;
  font-weight: 100;
}

.settings .custom-select {
  max-width: 14em;
  margin-left: auto;
  color: #d0d0d0;
}
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
.b-toast-secondary .toast-header {
  background-color: #2c2c2c !important;
  color: white !important;
}

.b-toast-secondary .toast {
  border: unset;
}

.b-toast-secondary .toast .toast-body {
  background-color: #2c2c2c;
  color: white;
}
</style>