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
        <p class="text-base font-semibold">Titre: <span class="text-base text-gray-700 font-light">{{ depot.titre }}</span></p>
        <p class="text-base font-semibold">Description: <span class="text-base text-gray-700 font-light">{{ depot.description }}</span></p>
        <p class="text-base font-semibold">Date de création: <span class="text-base text-gray-700 font-light">{{ depot.date_creation }}</span></p>
        <div class="my-4 p-2 border border-gray rounded-xl bg-gray-100 flex flex-col gap-2" v-if="depot.reponses.length">
          <div class="border border-dashed border-2 bg-white px-4 py-2" v-for="reponse in depot.reponses" :key="reponse.id">
            <p class="text-base font-semibold text-red-500">Type: <span class="text-base text-gray-700 font-light">{{ getTypeLabel(reponse.type) }}</span></p>
            <p class="text-base font-semibold">Titre: <span class="text-base text-gray-700 font-light">{{ reponse.titre }}</span></p>
            <p class="text-base font-semibold">Description: <span class="text-base text-gray-700 font-light">{{ reponse.description }}</span></p>
            <p class="text-base font-semibold">Date de création: <span class="text-base text-gray-700 font-light">{{ reponse.date_creation }}</span></p>
            <input type="checkbox" @change="handleCheckboxChange(reponse)" />
          </div>
        </div>
        <div class="flex items-center justify-center" v-else>
          <p class="text-base font-semibold">Aucune réponse</p>
        </div>
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-2" @click="$router.push(`/depots/${depot.id}`)">Répondre à la demande</button>
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-2 disabled:opacity-50 disabled:cursor-not-allowed" @click="$router.push(`/reponses/valider/${depot.id}`)" v-if="depot.reponses.length" :disabled="isValidButtonDisabled(depot.id)">Valider la sélection</button>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapMutations } from 'vuex';
import { getLabel } from '@/enum/demande_clinique/reponse/type';

export default {
  name: 'Index',

  created() {
    this.$store.commit('demande_clinique/RESET_SELECTION_REPONSES');
  },

  computed: {
    ...mapGetters({
      depots: 'demande_clinique/depots',
      reponsesSelectionnees: 'demande_clinique/reponsesSelectionnees'
    }),
  },
  methods: {
    getTypeLabel: getLabel,
    ...mapMutations({
      toggleSelection: 'demande_clinique/TOGGLE_REPONSE',
    }),

    handleCheckboxChange(reponse) {
      this.toggleSelection(reponse)
    },

    isValidButtonDisabled(depotId) {
      return !this.reponsesSelectionnees.filter(reponse => reponse.depot == depotId).length;
    }
  }
};
</script>