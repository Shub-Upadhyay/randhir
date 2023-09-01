<template>
  <div>
    <page-header>
      <template #title>Integrations</template>
    </page-header>

    <b-alert show variant="light" class="mt-4">
      <font-awesome-icon icon="info-circle" fixed-width class="mr-3" />
      <span></span>
    </b-alert>

    <loading-indicator v-if="loading && !loaded" class="my-5" />
    <b-tabs v-else class="my-4">
      <b-tab title="Search Patients" active class="bg-white border border-top-0 rounded-bottom shadow-sm">
        <mirth-connect @saved="refresh" />
      </b-tab>
      <!-- <button style="position: relative; left:83.5%; " @click="goToMirth" class="btn btn-primary">Search Patient</button> -->
    </b-tabs>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import MirthConnect from "@/clients/components/Integrations/MirthConnect.vue";

export default {
  name: "ViewSettingsIntegrations",
  components: {
    MirthConnect,
  },
  data() {
    return {
      loaded: false,
    };
  },
  computed: {
    ...mapGetters({
      appName: "appName",
      integrations: "integrations/all",
      loading: "integrations/loadingAll",
    }),
  },
  mounted() {
    this.refresh();
  },
  methods: {
    async refresh() {
      await this.$store.dispatch("integrations/getAll");
      this.loaded = true;
    },
    goToMirth() {
      window.location.href = "http://localhost:8765/client/mirth";
    },
  },
};
</script>
