import axios from 'axios';

export default {
    depots: {
        all: async () => (await axios.get('/v1/demande-clinique/depots')).data,
        ajouterReponse: async (id, titre, description, type, date_creation) => (await axios.post(`/v1/demande-clinique/depots/${id}/reponses`, {titre, description, type, date_creation})),
    },
    reponses: {
        valider: async (reponses, reason) => (await axios.post(`/v1/demande-clinique/reponses/validation`, {reponses, reason})).data
    }
};