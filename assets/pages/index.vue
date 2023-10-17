<template>
  <div>
    <div class="mb-2">
      <h1 class="text-4xl font-bold">Bienvenue sur ma belle application</h1>
      <p class="text-xl">Listing des demandes cliniques</p>
    </div>
    <div class="mb-2.5 items-end">
      <button type="button" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded mt-2 items-end ml-auto" v-if="selectedResponses.length" @click="showModal()">Valider</button>
    </div>
    <div class="flex gap-2 flex-col w-full">
      <div v-for="depot in depots" :key="depot.id" class="bg-white rounded-xl shadow-sm p-4">

        <p class="text-base font-semibold">Titre: <span class="text-base text-gray-700 font-light">{{ depot.titre }}</span></p>
        <p class="text-base font-semibold">Description: <span class="text-base text-gray-700 font-light">{{ depot.description }}</span></p>
        <p class="text-base font-semibold">Date de création: <span class="text-base text-gray-700 font-light">{{ depot.date_creation }}</span></p>
        <div v-if="depot.reponses.length">
          <div class="my-4 p-2 border border-gray rounded-xl bg-gray-100 flex flex-col gap-2"  v-for="reponse in depot.reponses" v-if="reponse.validated_at === null">
            <div class="selectable border border-dashed border-2 px-4 py-2" :key="reponse.id" @click="toggleSelection(reponse.id)" :class="selected(reponse.id) ? 'bg-yellow-100' : 'bg-white'">
              <p class="text-base font-semibold text-red-500">Type: <span class="text-base text-gray-700 font-light">{{ getTypeLabel(reponse.type) }}</span></p>
              <p class="text-base font-semibold">Titre: <span class="text-base text-gray-700 font-light">{{ reponse.titre }}</span></p>
              <p class="text-base font-semibold">Description: <span class="text-base text-gray-700 font-light">{{ reponse.description }}</span></p>
              <p class="text-base font-semibold">Date de création: <span class="text-base text-gray-700 font-light">{{ reponse.date_creation }}</span></p>
            </div>
          </div>
        </div>

        <div class="flex items-center justify-center" v-else>
          <p class="text-base font-semibold">Aucune réponse</p>
        </div>
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-2" @click="$router.push(`/depots/${depot.id}`)">Répondre à la demande</button>
      </div>
      <Modal v-show="isModalVisible" @close="closeModal" :selectedResponses="selectedResponses"/>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex';
import { getLabel } from '@/enum/demande_clinique/reponse/type';
import Modal from "@/pages/modal.vue";

export default {
  name: 'Index',
  computed: {
    ...mapGetters({
      depots: 'demande_clinique/depots',
    })
  },
  components: {
    Modal,
  },
  data() {
    return {
      isModalVisible: false,
      isSelected: false,
      selectedResponses: [],
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

    toggleSelection(reponse_id) {
      if (!this.selectedResponses.includes(reponse_id)){
        this.selectedResponses.push(reponse_id)
      }else {
        this.selectedResponses = this.selectedResponses.filter((e, i) => e !== reponse_id)
      }

      this.isSelected = !this.isSelected;
    },

    selected(reponse_id) {
      return this.selectedResponses.includes(reponse_id);

    }
  }
};
</script>
<style scoped>
.selectable {
  cursor: pointer;
  padding: 10px;
  border: 1px solid #ccc;
  transition: background-color 0.3s;
}

.selected {
  background-color: #007bff;
  color: white;
}
</style>