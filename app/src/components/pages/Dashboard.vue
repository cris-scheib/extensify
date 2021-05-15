<template>
  <div>
    <Layout>
      <b-container fluid>
        <b-row>
          <b-col>
            <div class="genre-chart">
              <GenreChart />
            </div>
          </b-col>
          <b-col>
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
import FrequencyChart from "../charts/FrequencyChart";
export default {
  components: { Layout, GenreChart, FrequencyChart },
};
</script>

