import axios from 'axios';

export default {
  depots: {
    all: async () => (await axios.get('/v1/demande-clinique/depots')).data,
    unmoderated: async () => (await axios.get('/v1/demande-clinique/depots/unmoderated')).data,
    ajouterReponse: async (id, titre, description, type) => (await axios.post(`/v1/demande-clinique/depots/${id}/reponses`, {titre, description, type})).data,
  },
  reponses: {
    creer: async (depot) => (await axios.post('/v1/demande-clinique/reponses', depot)).data,
    validerBatch: async (ids, reason) => (await axios.patch('/v1/demande-clinique/reponse/validate-batch', {ids, reason})).data,
  }
};