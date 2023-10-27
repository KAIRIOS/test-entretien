import api from '@/api';



export default {
  namespaced: true,
  state: {
    /** @var {Depot[]} depots **/
    depots: [],
  },
  mutations: {
    SET_DEPOTS(state, depots) {
      state.depots = depots;
    }
  },
  actions: {
    async chargerDepots({commit}) {
      commit('SET_DEPOTS', await api.demande_clinique.depots.all());
    },

  },
  getters: {
    /** @return Depot[] **/
    depots: state => state.depots,
  }
};