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

        <div v-if="depot.validation == null && depot.reponses.length">
          <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-2" v-bind:class="{ 'disabled-button': isValidationDisabled(depot) }" @click="validerDepot(depot)" :disabled="isValidationDisabled(depot)">Valider</button>
        </div>
        <div v-if="depot.validation !== null">
        <p class="text-base font-semibold"> Raison de la validation: <span class="text-base text-gray-700 font-light">{{ depot.validation.raison }}</span></p>
        </div>


        <div class="my-4 p-2 border border-gray rounded-xl bg-gray-100 flex flex-col gap-2" v-if="depot.reponses.length">
          <div class="border border-dashed border-2 bg-white px-4 py-2" v-for="reponse in depot.reponses" :key="reponse.id" @click="isSelectable(depot) ? toggleResponseSelection(depot, reponse) : null" v-bind:class="{ pointer: isSelectable(depot), selected: isSelected( reponse) || isResponseValid(depot, reponse) }">
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
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex';
import { getLabel } from '@/enum/demande_clinique/reponse/type';

export default {
  name: 'Index',
  computed: {
    ...mapGetters({
      depots: 'demande_clinique/depots',
      validation: 'demande_clinique/validation',
    }),
    reponsesValidees : function () {
      return this.$route.params.reponsesValidees;
    },
  },
  methods: {
    getTypeLabel: getLabel,
    isSelectable(depot) {
      console.log(depot.validation == null );
      return depot.validation === null;
    },

    toggleResponseSelection(depot, response) {

        if (this.currentDepotId !== depot.id) {
          this.selectedResponses = [];
          this.currentDepotId = depot.id;
        }

        const index = this.selectedResponses.indexOf(response.id);

        if (index === -1) {
          this.selectedResponses.push(response.id);
        } else {
          this.selectedResponses.splice(index, 1);
        }
    },

    isSelected(response) {
        return this.selectedResponses.includes(response.id);
    },

    isValidationDisabled(depot) {
      return (
        this.selectedResponses.length === 0 || this.currentDepotId !== depot.id 
      );
    },

    validerDepot(depot) {
      this.$router.push({
        path: `/validations/${depot.id}`,
        query: { reponsesValidees: JSON.stringify(this.selectedResponses) }
      });
    },

    isResponseValid(depot, reponse) {
      console.log('isResponseValid' , depot.validation);
      if (depot.validation && depot.validation.reponses) {
        return depot.validation.reponses.find(r => r.id === reponse.id) !== undefined;
      }
      console.log('is Pas response Valide');
      return false;
    },
  },
  data() {
  return {
    selectedResponses: [],
    currentDepotId: null,
  };
  },
};
</script>

<style scoped>
  .pointer{
    cursor: pointer;
  }

  .selected{
    background-color:  #abebc6 ;
  }

  .disabled-button {
    background-color: gray;
    cursor: not-allowed;
  }
</style>