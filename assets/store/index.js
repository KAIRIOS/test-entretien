import Vuex from 'vuex';
import Vue from 'vue';
import demande_clinique from './modules/demande_clinique';
import reponse from './modules/reponse';

Vue.use(Vuex);

export default new Vuex.Store({
  namespaced: true,
  modules: {
    demande_clinique,
    reponse
  }
})
