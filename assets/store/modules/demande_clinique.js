import api from '@/api';
import {VALIDEE} from "../../enum/demande_clinique/reponse/type";

export default {
  namespaced: true,
  state: {
    depots: [],
    reponsesSelctionnees: []
  },
  mutations: {
    SET_DEPOTS(state, depots) {
      state.depots = depots;
    },
    ADD_REPONSE_SELECTIONNEES(state, reponse) {
      if(reponse.type !== VALIDEE) {
        if(state.reponsesSelctionnees.includes(reponse)) {
          // On déselectionne la réponse
          state.reponsesSelctionnees.splice(state.reponsesSelctionnees.indexOf(reponse), 1);
        } else {
          state.reponsesSelctionnees.push(reponse)
        }
      }
    },
    CLEAR_REPONSES_SELECTIONNES(state) {
      state.reponsesSelctionnees = [];
    }
  },
  actions: {
    async chargerDepots({commit}) {
      commit('SET_DEPOTS', await api.demande_clinique.depots.all());
    },
    selectionnerReponse({commit}, reponse) {
      commit('ADD_REPONSE_SELECTIONNEES', reponse);
    },
    clearReponsesSelectionnees({commit}) {
      commit('CLEAR_REPONSES_SELECTIONNES');
    }
  },
  getters: {
    depots: state => state.depots,
    reponsesSelectionnees: state => state.reponsesSelctionnees,
  }
};