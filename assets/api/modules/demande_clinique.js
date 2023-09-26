import axios from 'axios';
import { async } from 'regenerator-runtime';

export default {
  depots: {
    all: async () => (await axios.get('/v1/demande-clinique/depots')).data,
    ajouterReponse: async (id, titre, description, type) => (await axios.post(`/v1/demande-clinique/depots/${id}/reponses`, { titre, description, type })).data,
    validerReponses: async (id, raison, reponsesValidees) => (await axios.post(`/v1/demande-clinique/depots/${id}/valider`, { raison, reponsesValidees }))
  },
  reponses: {
    creer: async (depot) => (await axios.post('/v1/demande-clinique/reponses', depot)).data,
  }
};