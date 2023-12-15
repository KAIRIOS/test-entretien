<template>
  <div>
    <div class="mb-2">
      <h1 class="text-4xl font-bold">Bienvenue sur ma belle application</h1>
      <p class="text-xl">Listing des demandes cliniques</p>
    </div>
    <div class="flex gap-2 flex-col w-full">
      <Depot
          v-for="depot in depots"
          :key="depot.id"
          v-bind:depot="depot"/>
    </div>
  </div>
</template>

<script>
import {mapGetters} from 'vuex';
import Depot from "../components/_depot.vue";

export default {
  name: 'Index',
  components: {Depot},
  computed: {
    ...mapGetters({
      depots: 'demande_clinique/depots',
    }),
  }
};
</script>