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
        <depot :depot="depot"></depot>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex';
import { getLabel } from '@/enum/demande_clinique/reponse/type';
import depot from './components/depots/depot.vue';

export default {
  name: 'Index',
  computed: {
    ...mapGetters({
      depots: 'demande_clinique/depots',
    }),
  },
  components: {
    depot,
  },
  methods: {
    getTypeLabel: getLabel,
  }
};
</script>