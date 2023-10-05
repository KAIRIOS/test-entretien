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
          <div class="border border-dashed border-2 bg-blue px-4 py-2 flex flex-row" :style="reponse.validee === false ? 'background-color: white' : 'background-color: #9ad6b1'" v-for="reponse in depot.reponses" :key="reponse.id">
            <div class="p-2">
              <input
                  :name="'reponses-'+depot.id"
                  type="checkbox"
                  :value="reponse.id"
                  v-if="reponse.validee === false"
                  @change="handleCheckboxChange(depot.id, reponse.id)"
              />
            </div>
            <div>
              <p class="text-base font-semibold text-red-500">Type: <span class="text-base text-gray-700 font-light">{{ getTypeLabel(reponse.type) }}</span></p>
              <p class="text-base font-semibold">Titre: <span class="text-base text-gray-700 font-light">{{ reponse.titre }}</span></p>
              <p class="text-base font-semibold">Description: <span class="text-base text-gray-700 font-light">{{ reponse.description }}</span></p>
              <p class="text-base font-semibold">Date de création: <span class="text-base text-gray-700 font-light">{{ reponse.date_creation }}</span></p>
            </div>
          </div>                  
          <div>
            <button v-if="shouldDisableValidation(depot.id)"
                    class="bg-white font-bold py-2 px-4 rounded mt-2"
                    @click="showModal = true"
                    disabled
            >
              Valider
            </button>
            <button v-else
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-2"
                    @click="showModal = true"
            >
              Valider
            </button>
            <div v-if="showModal" @close="showModal = false">
              <div class="modal-mask">
                <div class="modal-wrapper">
                  <div class="modal-container">
                    <div class="modal-header font-semibold">
                      <slot name="header">
                        Validation
                      </slot>
                    </div>
                    <div class="modal-body">
                      <slot name="body">
                        Voulez vous valider ces réponses ?
                      </slot>
                    </div>
                    <div class="modal-footer">
                      <slot name="footer">
                        <button class="hover:bg-blue-500 hover:text-white font-bold py-2 px-4 rounded mt-2" @click="closeModal()">Fermer</button>
                        <button class="bg-blue-500 text-white font-bold py-2 px-4 rounded mt-2" @click="validate(depot.id)">
                          Valider
                        </button>
                      </slot>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="flex items-center justify-center" v-else>
          <p class="text-base font-semibold">Aucune réponse</p>
        </div>
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-2" @click="$router.push(`/depots/${depot.id}`)">Répondre à la demande</button>
      </div>
    </div>
  </div>
</template>

<script>
import {mapActions, mapGetters} from 'vuex';
import {getLabel} from '@/enum/demande_clinique/reponse/type';

export default {
  name: 'Index',
  data: function () {
    return {
      showModal: false,
      selectedResponses: {},
    }
  },
  computed: {
    ...mapGetters({
      depots: 'demande_clinique/depots',
      success: 'reponse/success',
      errors: 'reponse/errors',
    }),
    ...mapActions({
      chargerDepots: 'demande_clinique/chargerDepots',
    }),
  },
  watch: {
    success(newSuccess, oldSuccess) {
      if (newSuccess !== oldSuccess && newSuccess) {
        this.chargerDepots();
      }
    },
  },
  methods: {
    getTypeLabel: getLabel,
    async validate(depotId) {
      if (this.selectedResponses['reponses-' + depotId] !== undefined) {
        for (let reponseId of this.selectedResponses['reponses-' + depotId]) {
          this.$store.dispatch('reponse/validate', {'id': reponseId})
        }
        this.showModal = false;
      }
    },
    closeModal() {
      this.showModal = false;
    },
    handleCheckboxChange(depotId, reponseId) {
      const checkboxName = 'reponses-' + depotId;
      const checkboxValue = reponseId;

      if (this.selectedResponses[checkboxName] === undefined) {
        this.selectedResponses[checkboxName] = [];
      }

      if (this.selectedResponses[checkboxName].includes(checkboxValue)) {
        const index = this.selectedResponses[checkboxName].indexOf(checkboxValue);
        if (index !== -1) {
          this.selectedResponses[checkboxName].splice(index, 1);
        }
      } else {
        this.selectedResponses[checkboxName].push(checkboxValue);
      }
      this.$forceUpdate();
    },
    shouldDisableValidation(depotId) {
      const checkboxName = 'reponses-' + depotId;
      return !this.selectedResponses[checkboxName] || this.selectedResponses[checkboxName].length === 0;
    },
  },
};
</script>
<style>
.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: table;
  transition: opacity 0.3s ease;
}

.modal-wrapper {
  display: table-cell;
  vertical-align: middle;
}

.modal-container {
  width: 300px;
  margin: 0px auto;
  padding: 20px 20px;
  background-color: #fff;
  border-radius: 2px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
  transition: all 0.3s ease;
  font-family: Helvetica, Arial, sans-serif;
}

.modal-header h3 {
  margin-top: 0;
  color: #42b983;
}

.modal-body {
  margin: 20px 0;
}

.modal-default-button {
  float: right;
}

/*
 * The following styles are auto-applied to elements with
 * transition="modal" when their visibility is toggled
 * by Vue.js.
 *
 * You can easily play with the modal transition by editing
 * these styles.
 */

.modal-enter {
  opacity: 0;
}

.modal-leave-active {
  opacity: 0;
}

.modal-enter .modal-container,
.modal-leave-active .modal-container {
  -webkit-transform: scale(1.1);
  transform: scale(1.1);
}
</style>