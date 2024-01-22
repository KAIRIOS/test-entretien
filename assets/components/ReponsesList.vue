<script>
import {getLabel} from "@/enum/demande_clinique/reponse/type";
import api from "@/api";

export default {
  name: "ReponsesList",
  props: {
    reponses: Array
  },
  data() {
    return {
      selectedForValidation: []
    }
  },
  methods: {
    getTypeLabel: getLabel,
    updateSelectedReponses(reponseId, checked) {
      // Hashmap could have been used too, not enough values to justify
      // We keep track of the reponse IDs to update. The IDs to be updated will be kept in selectedForValidation
      if (checked && !this.selectedForValidation.includes(reponseId)) this.selectedForValidation.push(reponseId)
      else this.selectedForValidation = this.selectedForValidation.filter(id => id !== reponseId)
    },
    envoyerValidation: async function () {
      if (!this.selectedForValidation.length) return alert('Une erreur s\'est produite, veuillez rééssayer plus tard');
      const reasonForValidation = prompt('Indiquez une note de validation:') || '* Aucun motif saisi *';

      try {
        this.loading = true;
        //await api.demande_clinique.depots.ajouterReponse(this.depot.id, this.titre, this.description, this.type);
        await api.demande_clinique.reponses.validerBatch(this.selectedForValidation, reasonForValidation);

        this.$emit('changed')
      } catch (e) {
        console.error(e);
        window.alert('Une erreur est survenue');
        this.loading = false;
      }
    }
  }
}
</script>

<template>
  <div>
    <div class="flex justify-between mb-1">
      <h2>Réponses:</h2>
      <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-2"
              :disabled="selectedForValidation.length === 0"
              @click="envoyerValidation"
      >
        Enregistrer
      </button>
    </div>


    <div>
      <div class="border border-dashed border-2 bg-white px-4 py-2"
           v-for="reponse in reponses"
           :key="reponse.id"
      >
        <p class="text-base font-semibold text-red-500">Type:
          <span class="text-base text-gray-700 font-light">{{ getTypeLabel(reponse.type) }}</span>
        </p>
        <p class="text-base font-semibold">Titre:
          <span class="text-base text-gray-700 font-light">{{ reponse.titre }}</span>
        </p>
        <p class="text-base font-semibold">Description:
          <span class="text-base text-gray-700 font-light">{{ reponse.description }}</span>
        </p>
        <p class="text-base font-semibold">Date de création:
          <span class="text-base text-gray-700 font-light">{{ reponse.date_creation }}</span>
        </p>

        <p>
          Opérations:
          <label>
            <input type="checkbox" @change="e => updateSelectedReponses(reponse.id, e.target.checked)"/>
            Approuver pour validation
          </label>
        </p>
      </div>
    </div>
  </div>
</template>

<style scoped>
button[disabled=disabled] {
  background-color: #8eb9ff;
  pointer-events: none;
}
</style>