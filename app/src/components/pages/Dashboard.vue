<template>
  <div>
    <Layout>
      <div class="genre-chart" >
        <GenreChart />
      </div>
    </Layout>
  </div>
</template>

<script>
import Layout from "../partials/Layout";
import GenreChart from "../charts/GenreChart";
export default {
  components: { Layout, GenreChart },
};
</script>
<style escope>
  .genre-chart{
    max-width: 50%;
  }
</style>

