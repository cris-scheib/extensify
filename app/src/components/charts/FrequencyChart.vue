<template>
  <div>
    <canvas id="frequency"></canvas>
  </div>
</template>

<script>
import Chart from "chart.js";

export default {
  name: "FrequencyChart",
  data() {
    return {
      data: {
        type: "line",
        data: {
          labels: [],
          datasets: [
            {
              label: "Frequency of listening tracks",
              data: [],
              borderColor: "#1abd53",
              backgroundColor: "#101010",
              tension: 0
            },
          ],
        },
        options: {
          response: true,
          maintainAspectRatio: false,
          scales: {
            yAxes: [
              {
                display: true,
                ticks: {
                  beginAtZero: true,
                },
              },
            ],
          },
        },
      },
    };
  },
  created() {
    this.getFrequency();
  },
  methods: {
    getFrequency() {
      this.$api.get("/reports/frequency").then((response) => {
        this.data.data.labels = response.data.labels;
        this.data.data.datasets[0].data = response.data.frequency;
        const ctx = document.getElementById("frequency");
        new Chart(ctx, this.data);

      });
    },
  },
};
</script>
<style scope>
  #frequency{
    height: 45vh;
  }
</style>