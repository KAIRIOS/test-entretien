import axios from 'axios';

/** @typedef {object} Depot
 * @property {number} id
 * @property {string} date_creation
 * @property {string} titre
 * @property {string} description
 * @property {Reponse[]} reponses
 */

/** @typedef {object} Reponse
 * @property {number} id
 * @property {string} date_creation
 * @property {string} titre
 * @property {string} description
 * @property {number} depot
 * @property {number} type
 * @property {boolean} isValide
 */

export default {
  depots: {
    /** @return Depot[] **/
    all: async () => (await axios.get('/v1/demande-clinique/depots')).data,
    ajouterReponse: async (id, titre, description, type) => (await axios.post(`/v1/demande-clinique/depots/${id}/reponses`, {titre, description, type})).data,
  },
  reponses: {
    creer: async (depot) => (await axios.post('/v1/demande-clinique/reponses', depot)).data,
  },
  reponseValidation: {
    /**
     * @param creerReponseValidation
     * @return {Promise<axios.AxiosResponse<string>>}
     */
    creer: (creerReponseValidation) => axios.post(`/v1/reponse_validation/creer`, creerReponseValidation)
  },
};

