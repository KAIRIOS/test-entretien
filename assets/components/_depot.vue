<template>
  <div
      class="bg-white rounded-xl shadow-sm p-4"
  >
    <ValidationReason
        v-if="this.displayModal"
        @updateReason="updateReason"
    />
    <p class="text-base font-semibold">Titre: <span class="text-base text-gray-700 font-light">{{ depot.titre }}</span></p>
    <p class="text-base font-semibold">Description: <span class="text-base text-gray-700 font-light">{{ depot.description }}</span></p>
    <p class="text-base font-semibold">Date de création: <span class="text-base text-gray-700 font-light">{{ depot.date_creation }}</span></p>
    <div class="my-4 p-2 border border-gray rounded-xl bg-gray-100 flex flex-col gap-2" v-if="depot.reponses.length">
      <Reponse
          v-for="reponse in depot.reponses"
          :key="reponse.id"
          v-bind:reponse="reponse"
          @selectResponse="selectResponse"
      />
    </div>
    <div class="flex items-center justify-center" v-else>
      <p class="text-base font-semibold">Aucune réponse</p>
    </div>
    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-2" @click="$router.push(`/depots/${depot.id}`)">Répondre à la demande</button>
    <button
        v-if="depot.reponses.length > 0"
        @click="toggleModal"
        class="text-white font-bold py-2 px-4 rounded mt-2"
        :class="{
          'hover:bg-blue-700 bg-blue-500': this.selectedResponses.length > 0,
          'bg-blue-300 cursor-not-allowed': this.selectedResponses.length === 0,
        }"
        :disabled="this.selectedResponses.length === 0"
    >
      Valider les réponses sélectionnées
    </button>
  </div>
</template>

<script>
import api from "../api";
import {mapActions} from "vuex";
import Reponse from "./_response.vue";
import ValidationReason from "./_validationReasonModal.vue";

export default {
  name: 'Depot',
  components: {Reponse, ValidationReason},
  data() {
    return {
      displayModal: false,
      selectedResponses: [],
      validateButtonDisabled: true,
      validationReason: '',
    }
  },
  props: ['depot'],
  methods: {
    ...mapActions({
      chargerDepots: 'demande_clinique/chargerDepots',
    }),
    selectResponse(isSelected, id) {
      if (isSelected) {
        if (this.selectedResponses.indexOf(id) === -1) {
          this.selectedResponses.push(id);
          this.validateButtonDisabled = false;
        }
      } else {
        if (this.selectedResponses.indexOf(id) !== -1) {
          this.selectedResponses.splice(this.selectedResponses.indexOf(id), 1);
          if (this.selectedResponses.length === 0) {
            this.validateButtonDisabled = true;
          }
        }
      }
    },
    toggleModal() {
      this.displayModal = !this.displayModal;
    },
    updateReason(reason) {
      this.validationReason = reason;
      this.validateResponse()
    },
    async validateResponse() {
      try {
        await api.demande_clinique.reponses.valider(this.selectedResponses, this.validationReason);
        await this.chargerDepots();
        this.selectedResponses = []
      } catch (e) {
        console.error(e);
        alert('Erreur lors de la validation de la réponse')
      }
      this.toggleModal()
    }
  }
}
</script>