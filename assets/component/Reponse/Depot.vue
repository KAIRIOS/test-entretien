<script>
import Button from "../Shared/Button.vue";
import Reponse from "./Reponse.vue";
import api from '@/api';
import {creerReponseValidation} from "../../Model/ReponseValidation";
import Modale from "../Shared/Modale.vue";
import {mapActions} from "vuex";

/** @typedef {Module}
 * @property {Depot[]} computed.depots
 */
export default {
  name: "Depot",
  components: {Modale, Reponse, Button},
  props: {
    depot: {
      default: () => {},
      type: Object
    },
  },
  data: () => {
    return {
      /** @type {CreerReponseValidation} creerReponseValidation **/
      creerReponseValidation: creerReponseValidation(),
      modale: {
        content: '',
        show: false
      }
    }
  },
  methods: {
    ...mapActions({
      chargerDepots: 'demande_clinique/chargerDepots',
    }),
    /**
     * @param e
     */
    onFormSubmit: function () {
      this.modale.show = true
      api.demande_clinique.reponseValidation.creer(this.creerReponseValidation)
        .then(() => {
          this.modale.content = "Votre demande a bien été pris en compte"
          this.chargerDepots();
          this.creerReponseValidation = creerReponseValidation()
        }).catch(() => {
          this.modale.content = "Votre demande a échoué"
        })
    },
    /**
     * @param {boolean} checked
     * @param {number} idReponse
     */
    onCheck: function (checked, idReponse) {
      const indexToRemove = this.creerReponseValidation.idReponses.indexOf(idReponse);
      if (checked && indexToRemove === -1) {
        this.creerReponseValidation.idReponses.push(idReponse);
        return;
      }

      if (!checked && indexToRemove !== -1) {
        this.creerReponseValidation.idReponses.splice(indexToRemove, 1);
      }
    }
  }
}
</script>

<template>
  <div
      class="bg-white rounded-xl shadow-sm p-4"
  >
    <p class="text-base font-semibold">Titre: <span class="text-base text-gray-700 font-light">{{ depot.titre }}</span></p>
    <p class="text-base font-semibold">Description: <span class="text-base text-gray-700 font-light">{{ depot.description }}</span></p>
    <p class="text-base font-semibold">Date de création: <span class="text-base text-gray-700 font-light">{{ depot.date_creation }}</span></p>
    <div class="my-4 p-2 border border-gray rounded-xl bg-gray-100 flex flex-col gap-2" v-if="depot.reponses.length">
      <div class="border border-dashed border-2 bg-white px-4 py-2" v-for="reponse in depot.reponses" :key="reponse.id">
        <Reponse :reponse="reponse" :on-check="onCheck"></Reponse>
      </div>
    </div>
    <div class="flex items-center justify-center" v-else>
      <p class="text-base font-semibold">Aucune réponse</p>
    </div>
    <div v-if="creerReponseValidation.idReponses.length" class="max-w-md mx-auto bg-white rounded-md shadow-md p-6">
      <form @submit.prevent="onFormSubmit">
        <div class="mb-4">
          <label for="message" class="block text-gray-700 font-bold mb-2">Message:</label>
          <textarea v-model="creerReponseValidation.description" id="message" name="message" class="w-full border border-gray-400 p-2 rounded-md" rows="4" maxlength="255" required></textarea>
        </div>
        <div class="text-center">
          <Button label="Envoyer votre validation" type="submit" ></Button>
        </div>
      </form>
    </div>
    <Button label="Répondre à la demande" :on-click="() => $router.push(`/depots/${depot.id}`)" ></Button>
    <Modale title="Votre demande de validation" :content="modale.content" :show-modal="modale.show"></Modale>
  </div>
</template>

<style scoped>

</style>