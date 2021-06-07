<template>
  <div>
    <canvas id="week"></canvas>
  </div>
</template>

<script>
import Chart from "chart.js";

export default {
  name: "FrequencyChart",
  data() {
    return {
      data: {
        type: "pie",
        data: {
          labels: [],
          datasets: [
            {
              label: "Genres listened this week",
              data: [],
              borderColor: "transparent",
              backgroundColor: "#101010",
              tension: 0,
            },
          ],
        },
        options: {
          responsive: true,
          plugins: {
            legend: {
              position: "top",
            },
            title: {
              display: true,
              text: "Genres listened this week",
            },
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
      this.$api.get("/reports/week-genres").then((response) => {
        this.data.data.labels = response.data.labels;
        this.data.data.datasets[0].data = response.data.frequency;
        this.data.data.datasets[0].backgroundColor = [
          "#155d2e",
          "#448c5d",
          "#1ABD53",
          "#292929",
          "#155d2e",
          "#448c5d",
          "#1ABD53",
          "#292929",
        ];
        const ctx = document.getElementById("week");
        new Chart(ctx, this.data);
      });
    },
  },
};
</script>