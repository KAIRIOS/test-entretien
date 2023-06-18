<template>
    <div v-if="depot">
      <div class="mb-2">
        <h1 class="text-4xl font-bold">Validation des réponses sélectionnées pour le {{ depot.titre }}</h1>
        <p class="text-xl">Veuillez justifier votre validation</p>
      </div>
      <div class="mt-4 px-4 py-2 bg-white rounded-xl">
      <h2 class="text-md font-semibold">Justification</h2>
      <form class="flex flex-col gap-2" @submit.prevent="valider">
        <input type="text" v-model="justification" placeholder="Justifier la validation" class="border border-gray-300 rounded-lg p-2">
        <button 
          class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
          :class="{
            'cursor-not-allowed': loading,
          }"
          :disabled="loading"
        >{{ loading ? 'En cours' : 'Valider' }}</button>
      </form>
    </div>
    </div>
    <div v-else>
      <p>Le dépot n'existe pas</p>
    </div> 
</template>

  <script>
import { mapActions, mapGetters } from 'vuex';
import api from '@/api';

export default {
  name: 'Depot',

  created() {
    if(!this.reponsesSelectionnees.filter(reponse => reponse.depot === this.depot.id).length)
        this.$router.push('/');
  },

  data: function () {
    return {
      loading: false,
      justification: ''
    };
  },
  computed: {
    ...mapGetters({
      depots: 'demande_clinique/depots',
      reponsesSelectionnees: 'demande_clinique/reponsesSelectionnees'
    }),
    id: function () {
      return parseInt(this.$route.params.id);
    },
    depot: function () {
      return this.depots.find((depot) => depot.id === this.id);
    },
  },
  methods: {
    ...mapActions({
      chargerDepots: 'demande_clinique/chargerDepots',
    }),

    valider: async function () {
        if(!this.justification) {
            window.alert('La justification ne peut pas être vide');
            return;
        } 
        
        try {
            this.loading = true;
            await api.demande_clinique.reponses.valider(this.reponsesSelectionnees.filter(reponse => reponse.depot === this.depot.id).map(reponse => reponse.id), this.justification);
            await this.chargerDepots();
            this.$router.push('/');
        } catch(e) {
            console.error(e);
            window.alert('Une erreur est survenue');
            this.loading = false;
        }
    }
  }
}
</script>