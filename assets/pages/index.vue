<template>
  <div>
    <div class="mb-2">
      <h1 class="text-4xl font-bold">Bienvenue sur ma belle application</h1>
      <p class="text-xl">Listing des demandes cliniques</p>
    </div>
    <div class="flex gap-2 flex-col w-full">
      <div 
        v-for="depot in depots"
        :key="depot.id"
        class="bg-white rounded-xl shadow-sm p-4"
      >
        <p class="text-base font-semibold">Titre: <span class="text-base text-gray-700 font-light">{{ depot.titre }}</span></p>
        <p class="text-base font-semibold">Description: <span class="text-base text-gray-700 font-light">{{ depot.description }}</span></p>
        <p class="text-base font-semibold">Date de création: <span class="text-base text-gray-700 font-light">{{ depot.date_creation }}</span></p>
        <div class="my-4 p-2 border border-gray rounded-xl bg-gray-100 flex flex-col gap-2" v-if="depot.reponses.length">
          <div class="border border-dashed border-2 bg-white px-4 py-2" v-for="reponse in depot.reponses" :key="reponse.id">
            <p class="text-base font-semibold text-red-500">Type: <span class="text-base text-gray-700 font-light">{{ getTypeLabel(reponse.type) }}</span></p>
            <p class="text-base font-semibold">Titre: <span class="text-base text-gray-700 font-light">{{ reponse.titre }}</span></p>
            <p class="text-base font-semibold">Description: <span class="text-base text-gray-700 font-light">{{ reponse.description }}</span></p>
            <p class="text-base font-semibold">Validité:
              <span v-if="reponse.validated" class="bg-green-100 text-green-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Validée</span>
                <span v-else class="bg-yellow-100 text-yellow-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">En cours de traitement</span>
            </p>
            <p v-if="reponse.validated" class="text-base font-semibold">Commentaire: <span class="text-base text-gray-700 font-light">{{ reponse.validationReason }}</span></p>
            <input  :id="reponse.id" v-if="!reponse.validated" :value="reponse.id" @click="updateSelectedResponse(reponse.id)"  type="checkbox"  name="list-radio" class="w-4 h-4 text-blue-600 float-right bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
          </div>
        </div>
        <div class="flex items-center justify-center" v-else>
          <p class="text-base font-semibold">Aucune réponse</p>
        </div>
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-2" @click="$router.push(`/depots/${depot.id}`)">Répondre à la demande</button>
        <button v-if="depot.reponses.length > 0" :disabled="checked" @click="showModal()" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mt-2">Valider réponse</button>
      </div>
    </div>
    <Modal
        v-show="isModalVisible" :id-response="selectedResponses"
        @close="closeModal"
    ></Modal>
  </div>

</template>

<script>
import { mapGetters } from 'vuex';
import { getLabel } from '@/enum/demande_clinique/reponse/type';
import Modal from "@/pages/Modal.vue";

export default {
  name: 'Index',
  components: {Modal},
  computed: {
    ...mapGetters({
      depots: 'demande_clinique/depots',
    }),
  },
  data() {
    return {
      isModalVisible: false,
      checked : false,
      selectedResponses: []
    };
  },
  methods: {
    getTypeLabel: getLabel,
    showModal() {
      this.isModalVisible = true;
    },
    closeModal() {
      this.isModalVisible = false;
    },
    updateSelectedResponse(newValue) {
      this.selectedResponses = [].concat(newValue)
      return this.selectedResponses;
    }
  }
};
</script>