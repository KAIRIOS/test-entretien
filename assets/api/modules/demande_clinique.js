import axios from 'axios';

export default {
  depots: {
    all: async () => (await axios.get('/v1/demande-clinique/depots')).data,
    ajouterReponse: async (id, titre, description, type) => (await axios.post(`/v1/demande-clinique/depots/${id}/reponses`, {titre, description, type})).data,
  },
  reponses: {
    valider: async(reponses, motif) => (await axios.post('/v1/demande-clinique/reponses/valider', {reponses, motif})).data,
  }
};