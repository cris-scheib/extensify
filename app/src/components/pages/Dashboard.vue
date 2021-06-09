<template>
  <div>
    <Layout>
      <b-container fluid>
        <b-row>
          <b-col cols="6">
            <div class="genre-chart">
              <GenreChart />
            </div>
          </b-col>
          <b-col cols="6">
            <div class="genre-chart">
              <WeekGenreChart />
            </div>
          </b-col>
          <b-col class="frequency-chart-content" cols="12">
            <div class="frequency-chart">
              <FrequencyChart />
            </div>
          </b-col>
        </b-row>
      </b-container>
    </Layout>
  </div>
</template>

<script>
import Layout from "../partials/Layout";
import GenreChart from "../charts/GenreChart";
import WeekGenreChart from "../charts/WeekGenreChart";
import FrequencyChart from "../charts/FrequencyChart";
export default {
  components: { Layout, GenreChart, FrequencyChart, WeekGenreChart },
};
</script>
