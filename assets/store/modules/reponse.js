import api from '@/api';

const state = {
    success: false,
    errors: [],
};

const getters = {
    success: state => state.success,
    errors: state => state.errors,
};

const actions = {
    validate ({ commit }, values) {
        commit('resetState');
        return api.demande_clinique.reponses.validate(values)
            .then(responseStatus => {
                if (responseStatus === 200) {
                    commit('success', true)
                }
                else {
                    commit('addError', response);
                }
            })
            .catch((error) => {
                commit('addError', error.response)
            });
    },
    reset ({ commit }) {
        commit('resetState')
    },
};

const mutations = {
    success(state, success) {
        state.success = success
    },
    addError(state, error) {
        state.errors.push(error)
    },
    resetState(state) {
        state.success = false;
        state.errors = []
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}