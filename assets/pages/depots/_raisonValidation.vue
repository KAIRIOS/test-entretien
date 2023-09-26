<template>
	<div v-if="depot">
		<div class="mb-2">
			<h1 class="text-4xl font-bold">{{ depot.titre }}</h1>
			<p class="text-xl">{{ depot.description }}</p>
		</div>
		<div class="mt-4 px-4 py-2 bg-white rounded-xl">
			<h2 class="text-md font-semibold">Validation des réponses</h2>
			<form class="flex flex-col gap-2"
				@submit.prevent="creer">

				<textarea v-model="raison"
					placeholder="Raisons"
					class="border border-gray-300 rounded-lg p-2"></textarea>

				<button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
					:class="{
						'cursor-not-allowed': loading,
					}"
					:disabled="loading">{{ loading ? 'En cours' : 'Valider' }}</button>
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
import { getAll, getLabel } from '@/enum/demande_clinique/reponse/type';

export default {
	name: 'Validation',
	data: function () {
		return {
			raison: '',
			reponsesValidees: [],
			loading: false,
			type: 0,
		};
	},
	computed: {
		...mapGetters({
			depots: 'demande_clinique/depots',
		}),
		id: function () {
			return parseInt(this.$route.params.id);
		},
		depot: function () {
			return this.depots.find((depot) => depot.id === this.id);
		},
	},
	created() {
		const reponsesValideesParam = this.$route.query.reponsesValidees;
		if (reponsesValideesParam) {
			this.reponsesValidees = JSON.parse(reponsesValideesParam);
		}
	},

	methods: {
		...mapActions({
			chargerDepots: 'demande_clinique/chargerDepots',
		}),
		getTypes: getAll,
		getTypeLabel: getLabel,
		creer: async function () {
			if (!(this.raison)) {
				window.alert('Veuillez remplir tous les champs');
				return;
			}

			try {
				this.loading = true;
				await api.demande_clinique.depots.validerReponses(this.depot.id, this.raison, JSON.stringify(this.reponsesValidees));
				await this.chargerDepots();
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
  