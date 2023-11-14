import api from "@/api";

export default {
	namespaced: true,
	state: {
		depots: [],
	},
	mutations: {
		SET_DEPOTS(state, depots) {
			state.depots = depots;
		},
		VALIDATE_RESPONSES(state, { depotId, validatedResponseIds }) {
			const depot = state.depots.find((d) => d.id === depotId);
			if (depot) {
				depot.reponses.forEach((response) => {
					if (validatedResponseIds.includes(response.id)) {
						response.validated = true; // Assuming you add a 'validated' field in your response entity
					}
				});
			}
		},
	},
	actions: {
		async chargerDepots({ commit }) {
			commit("SET_DEPOTS", await api.demande_clinique.depots.all());
		},
		async validateResponses({ commit }, { depotId, responseIds, comment }) {
			await api.demande_clinique.validateResponses(
				depotId,
				responseIds,
				comment
			);
			commit("VALIDATE_RESPONSES", {
				depotId,
				validatedResponseIds: responseIds,
			});
		},
	},
	getters: {
		depots: (state) => state.depots,
	},
};
