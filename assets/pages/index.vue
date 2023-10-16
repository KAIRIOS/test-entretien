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
          <div v-for="reponse in depot.reponses" :key="reponse.id"
               @click="selection.depot.id = depot.id,
                      selection.depot.reponse.id = reponse.id"

               :class="['reponse border border-dashed border-2 bg-white px-4 py-2',
                selection.depot.id == depot.id
                && selection.depot.reponse.id == reponse.id ? 'selection' :null]"
          >
            <p class="text-base font-semibold text-red-500">Type: <span class="text-base text-gray-700 font-light">{{ getTypeLabel(reponse.type) }}</span></p>
            <p class="text-base font-semibold">Titre: <span class="text-base text-gray-700 font-light">{{ reponse.titre }}</span></p>
            <p class="text-base font-semibold">Description: <span class="text-base text-gray-700 font-light">{{ reponse.description }}</span></p>
            <p class="text-base font-semibold">Date de création: <span class="text-base text-gray-700 font-light">{{ reponse.date_creation }}</span></p>
            <span v-if="reponse.validation">Validée !</span>
          </div>
        </div>

        <div class="flex items-center justify-center" v-else>
          <p class="text-base font-semibold">Aucune réponse</p>
        </div>
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-2" @click="$router.push(`/depots/${depot.id}`)">
          Répondre à la demande
        </button>


        <textarea id="w3review"
                  name="w3review"
                  rows="4"
                  cols="50"
                  placeholder="Raison de la validation ?"
                  v-if="selection.depot.id == depot.id"
        >

        </textarea>

        <button
            v-if="depot.reponses.length>0"
            :class="['bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-2',
             selection.depot.id == depot.id ? null : 'opacity-50 cursor-not-allowed']"
            @click="validationReponse()"
        >
          Valider
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex';
import { getLabel } from '@/enum/demande_clinique/reponse/type';

export default {
  name: 'Index',
  computed: {
    ...mapGetters({
      depots: 'demande_clinique/depots',
    }),
  },

  data() {
    return {
      selection : {
        depot:{
          id : null,
          reponse :{
            id : null
          }
        }
      }
    }
  },
  methods: {
    getTypeLabel: getLabel,

    validationReponse(){

      const depotSelectionId = this.selection.depot.id
      const reponseSelectionId = this.selection.depot.reponse.id

      this.depots.forEach(function(depot){
        depot.reponses.forEach(function (reponse){

          if(depot.id == depotSelectionId
              && reponse.id == reponseSelectionId){

            reponse.validation = true

          }

        })
      })

      this.$forceUpdate()


    }
  }
};
</script>

<style lang="scss" scoped>

.reponse{
  cursor: pointer;
}
.reponse.selection{
  outline: dashed #313131 3px;
}
.reponse:hover{
  outline: dashed #858585 3px;
}
textarea{
  width : 100%;
  border: solid grey 1px;
  margin-top: 30px;
}
</style>