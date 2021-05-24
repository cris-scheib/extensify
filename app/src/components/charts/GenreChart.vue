<template>
  <div>
    <canvas id="genre"></canvas>
  </div>
</template>

<script>
import Chart from "chart.js";

export default {
  name: "GenreChart",
  data() {
    return {
      data: {
        type: "radar",
        data: {
          labels: [],
          datasets: [
            {
              label: "My Favorite Genres by Artists",
              data: [],
              fill: true,
              backgroundColor: "#1abd5370",
              borderColor: "#1abd53",
              pointBackgroundColor: "#1abd53",
              pointBorderColor: "#fff",
              pointHoverBackgroundColor: "#fff",
              pointHoverBorderColor: "#1abd53",
            },
            {
              label: "My Favorite Genres by Tracks",
              data: [],
              fill: true,
              backgroundColor: "#fff70",
              borderColor: "#fff",
              pointBackgroundColor: "#fff",
              pointBorderColor: "#fff",
              pointHoverBackgroundColor: "#fff",
              pointHoverBorderColor: "#fff",
            },
          ],
        },
        options: {
          responsive: true,
          scale: {
            ticks: {
              beginAtZero: true,
              min: 0,
              stepSize: 1,
              display: false,
            },
          },
        },
      },
    };
  },
  created() {
    this.getFavoriteGenres();
  },
  methods: {
    getFavoriteGenres() {
      this.$api.get("/reports/favorite-genres").then((response) => {
        this.data.data.labels = response.data.genre;
        this.data.data.datasets[0].data = response.data.tracks;
         this.data.data.datasets[1].data = response.data.artists;
        const ctx = document.getElementById("genre");
        new Chart(ctx, this.data);
      });
    },
  },
};
</script>