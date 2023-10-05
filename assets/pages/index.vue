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
          <div
              class="border border-dashed border-2 px-4 py-2"
              v-for="reponse in depot.reponses"
              :key="reponse.id"
              :class="isReponseSelected(reponse) ? 'bg-blue-200' : 'bg-white'"
              @click="selectReponse(reponse)"
          >
            <p class="text-base font-semibold text-red-500">Type: <span class="text-base text-gray-700 font-light">{{ getTypeLabel(reponse.type) }}</span></p>
            <p class="text-base font-semibold">Titre: <span class="text-base text-gray-700 font-light">{{ reponse.titre }}</span></p>
            <p class="text-base font-semibold">Description: <span class="text-base text-gray-700 font-light">{{ reponse.description }}</span></p>
            <p class="text-base font-semibold">Date de création: <span class="text-base text-gray-700 font-light">{{ reponse.date_creation }}</span></p>
            <p class="text-base font-semibold">
              Statut:
              <span
                class="text-base"
                :class="isReponseValidated(reponse) ? 'text-green-700 font-medium' : 'text-gray-700 font-light'"
              >
                {{ getStatusLabel(reponse.status) }}
              </span>
            </p>
          </div>
        </div>
        <div class="flex items-center justify-center" v-else>
          <p class="text-base font-semibold">Aucune réponse</p>
        </div>
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-2" @click="$router.push(`/depots/${depot.id}`)">Répondre à la demande</button>
      </div>
    </div>
    <div
        class="bg-gray-200 border-2 border-gray-400 w-full sticky bottom-6 p-2 rounded-md"
        v-show="isValidationPossible()"
    >
      <input class="border border-gray-300 py-2 px-4 rounded w-full m-1" placeholder="Motif (optionel)" v-model="comment"/>
      <button
        class="bg-green-700 hover:bg-green-500 text-white font-bold py-2 px-4 rounded w-full m-1"
        :disabled="false === isValidationPossible()"
        @click="validateSelectedReponses()"
      >
        Valider les réponses séléctionnées
      </button>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { mapGetters } from 'vuex';
import { getLabel as getTypeLabel } from '@/enum/demande_clinique/reponse/type';
import { getLabel as getStatusLabel } from '@/enum/demande_clinique/reponse/status';

export default {
  name: 'Index',
  data() {
    return {
      selectedReponses: [],
      comment: '',
      isValidationRequestSent: false
    }
  },
  computed: {
    ...mapGetters({
      depots: 'demande_clinique/depots',
    }),
  },
  methods: {
    getTypeLabel,
    getStatusLabel,

    isReponseSelected(reponse) {
      return this.selectedReponses.includes(reponse.id);
    },

    isReponseValidated(reponse) {
      return reponse.status === 'validated';
    },

    isReponseSelectable(reponse) {
      return reponse.status === 'waiting';
    },

    isSelectedReponsesEmpty() {
      return this.selectedReponses.length < 1;
    },

    isValidationPossible() {
      return false === this.isValidationRequestSent && false === this.isSelectedReponsesEmpty();
    },

    selectReponse(reponse) {
      if (false === this.isReponseSelectable(reponse)) {
        return;
      }

      if (false === this.isReponseSelected(reponse)) {
        this.selectedReponses.push(reponse.id);
      } else {
        this.selectedReponses = this.selectedReponses.filter((value) => value !== reponse.id);
      }
    },

    async validateSelectedReponses() {
      if (false === this.isValidationPossible()) {
        return;
      }

      this.isValidationRequestSent = true;

      await axios.put('/v1/demande-clinique/reponses/valider', {
        reponseIds: this.selectedReponses,
        comment: this.comment
      });

      this.$router.go(0);
    }
  }
};
</script>
