<template>
  <div v-if="reponsesSelectionnees.length > 0">
    <div class="mb-2">
      <h1 class="text-2xl font-bold">Validation des réponses sélectionnées</h1>
      <p class="text-xl">Listes des réponses</p>
    </div>

    <div class="flex gap-2 flex-col w-full mb-4">
        <div v-for="reponse in reponsesSelectionnees" :key="reponse.id"
           class="px-4 py-2 bg-white rounded-xl"
        >
          <p class="text-base font-semibold text-red-500">Type: <span class="text-base text-gray-700 font-light">{{ getTypeLabel(reponse.type) }}</span></p>
          <p class="text-base font-semibold">Titre: <span class="text-base text-gray-700 font-light">{{ reponse.titre }}</span></p>
          <p class="text-base font-semibold">Description: <span class="text-base text-gray-700 font-light">{{ reponse.description }}</span></p>
          <p class="text-base font-semibold">Date de création: <span class="text-base text-gray-700 font-light">{{ reponse.date_creation }}</span></p>
        </div>
    </div>

    <form class="flex flex-col gap-2" @submit.prevent="valider">
        <p class="text-xl">Motif de validation</p>
        <textarea v-model="motif" placeholder="Description" class="border border-gray-300 rounded-lg p-2"></textarea>
        <button
            class="self-end bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
            :class="{
              'cursor-not-allowed': loading,
            }"
            :disabled="loading"
        >{{ loading ? 'En cours' : 'Valider' }}</button>
    </form>
  </div>
  <div v-else>
      <p>Il n'y a pas de réponses sélectionnées</p>
  </div>

</template>

<script>
import {mapGetters, mapActions} from "vuex";
import {getLabel} from "../../enum/demande_clinique/reponse/type";
import api from "@/api";

export default {
  name: 'Valider',
  data: function () {
    return {
      motif: '',
      loading: false
    }
  },
  computed: {
    ...mapGetters({
      reponsesSelectionnees: 'demande_clinique/reponsesSelectionnees',
    })
  },
  methods: {
    ...mapActions({
      chargerDepots: 'demande_clinique/chargerDepots',
      clearReponsesSelectionnees: 'demande_clinique/clearReponsesSelectionnees',
    }),
    getTypeLabel: getLabel,
    valider: async function() {
      if (!(this.motif)) {
        window.alert('Veuillez remplir écrire un motif.');
        return;
      }

      try {
        this.loading = true;
        await api.demande_clinique.reponses.valider(this.reponsesSelectionnees, this.motif);
        await this.chargerDepots();
        await this.clearReponsesSelectionnees();
        await this.$router.push('/');
      } catch (e) {
        console.log(e);
        window.alert('Une erreur est survenue');
        this.loading = false;
      }
    }
  }
}
</script>