<template>
    <div class="mt-4 px-4 py-2 bg-white rounded-xl">
      <h2 class="text-md font-semibold">Raison de la validation</h2>
      <form class="flex flex-col gap-2" @submit.prevent="valider">
        <textarea v-model="raisonValidation" placeholder="Raison" class="border border-gray-300 rounded-lg p-2"></textarea>
        <button 
          class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
          :class="{
            'cursor-not-allowed': loading,
          }"
          :disabled="loading"
        >{{ loading ? 'En cours' : 'Envoyer' }}</button>
      </form>
    </div>
</template>

<script>
import api from '@/api';

export default {
  name: 'valider',
  props: {
    reponseId: {
      type: Number,
      required: true,
    }
  },
  data () {
    return {
      raisonValidation: '',
      loading: false,
      type: 0,
      isValidationSent: false,
    };
  },
  methods: {
    valider: async function() {
      if (!this.raisonValidation) {
        window.alert('Veuillez remplir tous les champs');
        return;
      }

      try {
        this.loading = true;
        await api.demande_clinique.reponses.valider(this.reponseId, this.raisonValidation);
        this.$router.push('/');
      } catch (e) {
        console.error(e);
        window.alert('Une erreur est survenue');
        this.loading = false;
      }
    }
  }
}
</script>
