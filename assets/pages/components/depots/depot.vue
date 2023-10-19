<template>
  <div class="bg-white rounded-xl shadow-sm p-4">
    <p class="text-base font-semibold">Titre: <span class="text-base text-gray-700 font-light">{{ depot.titre }}</span></p>
    <p class="text-base font-semibold">Description: <span class="text-base text-gray-700 font-light">{{ depot.description }}</span></p>
    <p class="text-base font-semibold">Date de création: <span class="text-base text-gray-700 font-light">{{ depot.date_creation }}</span></p>
    <div class="my-4 p-2 border border-gray rounded-xl bg-gray-100 flex flex-col gap-2" v-if="depot.reponses.length">
      <div :class="{ selected: selectedReponseId === reponse.id }" class="border border-dashed border-2 bg-white px-4 py-2" v-for="reponse in depot.reponses.filter(reponse => reponse.raison_validation === null)" :key="reponse.id" @click="selectedReponseId = reponse.id">
        <p class="text-base font-semibold text-red-500">Type: <span class="text-base text-gray-700 font-light">{{ getTypeLabel(reponse.type) }}</span></p>
        <p class="text-base font-semibold">Titre: <span class="text-base text-gray-700 font-light">{{ reponse.titre }}</span></p>
        <p class="text-base font-semibold">Description: <span class="text-base text-gray-700 font-light">{{ reponse.description }}</span></p>
        <p class="text-base font-semibold">Date de création: <span class="text-base text-gray-700 font-light">{{ reponse.date_creation }}</span></p>
      </div>
    </div>
    <div class="flex items-center justify-center" v-else>
      <p class="text-base font-semibold">Aucune réponse</p>
    </div>
    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-2" @click="$router.push(`/depots/${depot.id}`)">Répondre à la demande</button>
    <valider v-if="formIsShown && depot.reponses.length > 0 && selectedReponseId !== null" :reponseId="selectedReponseId"></valider>
    <button v-else-if="depot.reponses.length > 0 && selectedReponseId !== null" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mt-2" @click="formIsShown = true">Valider</button>
  </div>
</template>

<script>
import { getLabel } from '@/enum/demande_clinique/reponse/type';
import valider from '../reponses/valider.vue';

export default {
  name: 'depot',
  props: {
    depot: {
      type: Object,
      required: true,
    },
    selected: {
      type: Boolean,
      default: false,
    }
  },
  data() {
    return {
      selectedReponseId: null,
      formIsShown: false,
    }
  },
  components: {
    valider,
  },
  computed: {
    isValidated() {
      return this.depot.reponses.filter(reponse => reponse.raison_validation !== null).length > 0
    },
  },
  methods: {
    getTypeLabel: getLabel,
  }
};
</script>