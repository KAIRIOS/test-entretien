<template>
  <div>
    <div class="mb-2">
      <h1 class="text-4xl font-bold">Bienvenue sur ma belle application</h1>
      <p class="text-xl">Listing des demandes cliniques</p>
    </div>
    <div class="flex gap-2 flex-col w-full">

      <div 
        v-for="depot in depots"
        :key="depot.id"
        class="bg-white rounded-xl shadow-sm p-4"
      >
        <Depot :depot="depot"></Depot>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex';
import Button from "../component/Shared/Button.vue";
import Reponse from "../component/Reponse/Reponse.vue";
import Depot from "../component/Reponse/Depot.vue";


/** @typedef {Module}
 * @property {Depot[]} computed.depots
 */
export default {
  name: 'Index',
  components: {Depot, Reponse, Button},
  computed: {
    ...mapGetters({
      depots: 'demande_clinique/depots',
    }),
  }
};
</script>