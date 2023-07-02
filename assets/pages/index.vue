<template>
  <div>
    <div class="mb-2">
      <h1 class="text-4xl font-bold">Bienvenue sur ma belle application</h1>
      <p class="text-xl">Listing des demandes cliniques</p>
    </div>
    <div class="flex gap-2 flex-col w-full">
      <div class="flex justify-end">
          <button
            @click="$router.push(`/reponses/valider`)"
            :disabled="reponsesSelectionnees.length === 0"
            :class="[
              reponsesSelectionnees.length > 0 ? 'bg-green-500 hover:bg-green-700 cursor-pointer' : 'bg-gray-200 cursor-not-allowed',
              'text-white font-bold py-2 px-4 rounded mt-2'
            ]"
          >
            Valider les réponses
          </button>
      </div>
      <div
        v-for="depot in depots"
        :key="depot.id"
        class="bg-white rounded-xl shadow-sm p-4"
      >
        <p class="text-base font-semibold">Titre: <span class="text-base text-gray-700 font-light">{{ depot.titre }}</span></p>
        <p class="text-base font-semibold">Description: <span class="text-base text-gray-700 font-light">{{ depot.description }}</span></p>
        <p class="text-base font-semibold">Date de création: <span class="text-base text-gray-700 font-light">{{ depot.date_creation }}</span></p>
        <div class="my-4 p-2 border border-gray rounded-xl bg-gray-200 flex flex-col gap-2" v-if="depot.reponses.length">
          <div :class="[
              reponsesSelectionnees.includes(reponse) ? 'border-green-500' : 'border-dashed',
              reponse.type === VALIDEE() ? 'bg-gray-100 cursor-not-allowed' : 'bg-white hover:border-gray-400 hover:cursor-pointer',
              'border border-2 rounded-lg px-4 py-2 ']"
             v-for="reponse in depot.reponses"
             :key="reponse.id"
             @click="selectionnerReponse(reponse)"
          >
            <p :class="[reponse.type === VALIDEE() ? 'text-green-500' : 'text-red-500','text-base font-semibold']">Type: <span class="text-base text-gray-700 font-light">{{ getTypeLabel(reponse.type) }}</span></p>
            <p class="text-base font-semibold">Titre: <span class="text-base text-gray-700 font-light">{{ reponse.titre }}</span></p>
            <p class="text-base font-semibold">Description: <span class="text-base text-gray-700 font-light">{{ reponse.description }}</span></p>
            <p class="text-base font-semibold">Date de création: <span class="text-base text-gray-700 font-light">{{ reponse.date_creation }}</span></p>
            <p class="text-base font-semibold" v-if="reponse.motif_validation">Motif de validation: <span class="text-base text-gray-700 font-light">{{ reponse.motif_validation }}</span></p>
          </div>
        </div>
        <div class="flex items-center justify-center" v-else>
          <p class="text-base font-semibold">Aucune réponse</p>
        </div>
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-2" @click="$router.push(`/depots/${depot.id}`)">Répondre à la demande</button>
      </div>
    </div>
  </div>
</template>

<script>
import {mapActions, mapGetters} from 'vuex';
import { getLabel } from '@/enum/demande_clinique/reponse/type';
import {VALIDEE} from "../enum/demande_clinique/reponse/type";

export default {
  name: 'Index',
  computed: {
    ...mapGetters({
      depots: 'demande_clinique/depots',
      reponsesSelectionnees: 'demande_clinique/reponsesSelectionnees',
    })
  },
  methods: {
    VALIDEE() {
        return VALIDEE
    },
    getTypeLabel: getLabel,
    ...mapActions({
        selectionnerReponse: 'demande_clinique/selectionnerReponse',
    })
  }
};
</script>