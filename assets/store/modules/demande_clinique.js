import api from '@/api';

export default {
  namespaced: true,
  state: {
    depots: [],
    reponsesSelectionnees: []
  },
  mutations: {
    SET_DEPOTS(state, depots) {
      state.depots = depots;
    },

    TOGGLE_REPONSE(state, reponse) {
      const index = state.reponsesSelectionnees.indexOf(reponse);
      if(index > -1)
        state.reponsesSelectionnees.splice(index, 1);
      else
        state.reponsesSelectionnees.push(reponse);
    },

    RESET_SELECTION_REPONSES(state) {
      state.reponsesSelectionnees = [];
    }

  },
  actions: {
    async chargerDepots({commit}) {
      commit('SET_DEPOTS', await api.demande_clinique.depots.all());
    },
  },
  getters: {
    depots: state => state.depots,
    reponsesSelectionnees: state => state.reponsesSelectionnees
  }
};