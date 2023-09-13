<template>
  <transition name="modal-fade">
    <div class="modal-backdrop">
      <div class="modal"
           role="dialog"
           aria-labelledby="modalTitle"
           aria-describedby="modalDescription"
      >
        <div class="relative w-full max-w-2xl max-h-full">
          <!-- Modal content -->
          <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
              <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
               Validation réponse
              </h3>
              <button @click="close" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="defaultModal">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close modal</span>
              </button>
            </div>
            <!-- Modal body -->
            <div class="p-6 space-y-6">

              <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Commentaire</label>
              <textarea id="message" v-model="message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your thoughts here..."></textarea>

            </div>
            <!-- Modal footer -->
            <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
              <button data-modal-hide="defaultModal" @click="validerReponse" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Valider</button>
              <button data-modal-hide="defaultModal" @click="close" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Annuler</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
import api from "@/api";
import {mapActions} from "vuex";

export default {
  name: 'Modal',
  data() {
    return {
      message: "",
    };
  },
  props: {
    idResponse: {
      type: Array,
    },
  },
  methods: {
    ...mapActions({
      chargerDepots: 'demande_clinique/chargerDepots',
    }),
    close() {
      this.$emit('close');
    },
    validerReponse: async function() {
      if (!(this.message)) {
        window.alert('Veuillez remplir un commentaire');
        return;
      }

      try {
        this.loading = true;
        await api.demande_clinique.reponses.valider(this.$props.idResponse[0],this.message);
        await this.chargerDepots();
        this.$router.push('/');
        this.message=""
        this.close()
      } catch (e) {
        console.error(e);
        window.alert('Une erreur est survenue');
        this.loading = false;
      }
    }
  },
};
</script>
