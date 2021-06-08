<template>
  <div>
    <Layout>
      <b-container fluid class="pb-2">
        <div class="d-flex justify-content-end mt-3">
          <div class="mr-auto">
            <b-button
              v-b-modal.modal
              class="btn-filter"
              v-b-tooltip.hover.bottom
              title="Filter"
            >
              <b-icon icon="funnel-fill"></b-icon>
            </b-button>
            <b-button
              @click="exportPDF"
              class="btn-filter"
              v-b-tooltip.hover.bottom
              title="Export PDF"
            >
              <b-icon icon="box-arrow-up-right"></b-icon>
            </b-button>
            <b-button
              @click="downloadCSV"
              class="btn-filter"
              v-b-tooltip.hover.bottom
              title="Dowload CSV"
            >
              <b-icon icon="box-arrow-down"></b-icon>
            </b-button>
          </div>
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
        <b-modal id="modal" title="History Filter" @ok="getHistory">
          <b-row>
            <b-col>
              <b-form-datepicker
                id="start-datepicker"
                v-model="start"
                locale="en"
                class="mb-2"
                placeholder="Select a start date"
              ></b-form-datepicker>
            </b-col>
            <b-col>
              <b-form-datepicker
                id="end-datepicker"
                v-model="end"
                class="mb-2"
                locale="en"
                placeholder="Select a end date"
              ></b-form-datepicker>
            </b-col>
          </b-row>
        </b-modal>
      </b-container>
    </Layout>
  </div>
</template>

<script>
import Layout from "../partials/Layout";
import { jsPDF } from "jspdf";
import "jspdf-autotable";

export default {
  components: { Layout },
  data() {
    return {
      history: [],
      fields: [],
      currentPage: 1,
      export: [],
      rows: null,
      perPage: null,
      start: null,
      end: null,
    };
  },
  watch: {
    currentPage: function () {
      this.getHistory();
    },
  },
  methods: {
    exportPDF() {
      const doc = new jsPDF();

      let body = [];

      for (let data of this.export) {
        body.push([data.date, data.track, data.artist]);
      }
      doc.text("History", 15, 10);
      doc.autoTable({
        head: [["Date", "Track", "Artist"]],
        body: body,
      });
      doc.output("dataurlnewwindow");
    },
    getHistory() {
      const url =
        "/history?page=" +
        this.currentPage +
        (this.start === null ? "" : "&start=" + this.start) +
        (this.end === null ? "" : "&end=" + this.end);
      this.$api
        .get(url)
        .then((response) => {
          this.history = response.data.history.data;
          this.fields = ["date", "track", "artist"];
          this.rows = response.data.history.total;
          this.currentPage = response.data.history.current_page;
          this.perPage = response.data.history.per_page;
          this.export = response.data.export;
        })
        .catch(({ response }) => {
          if (response !== undefined) {
            if (response.status === 401) {
              this.$router.push("/unauthorized");
            }
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
  margin-bottom: 3px;
}
.page-item.active .page-link {
  color: #121212 !important;
  border-color: white !important;
}
</style>