<script lang="ts">
import { mapActions, mapGetters } from 'vuex';
import { getLabel } from '@/enum/demande_clinique/reponse/type';
import api from '@/api';

export default {
    props: [
        "idDepot",
        "reponses",
    ],
    data() {
        return {
            checkedReponses: [],
            raisonValidationOpened: false,
            raisonValidation: {
                description: ''
            },
            loading: false,
        };
    },
    computed: {
        reponsesFiltered() {
            return this.reponses.filter(rep => rep.est_valide !== true);
        },
        isDisabled() {
            return this.checkedReponses.length <= 0;
        },
        isRaisonValidationOpen () {
            return this.raisonValidationOpened && !this.isDisabled
        }
    },
    methods: {
        getTypeLabel: getLabel,
        ...mapActions({
            openModal: 'modals/openModal',
            chargerDepots: 'demande_clinique/chargerDepots',
        }),
        openValidationModal() {
            this.raisonValidationOpened = true
        },
        validerReponses: async function() {
            if (!(this.raisonValidation && this.raisonValidation.description)) {
                window.alert('Veuillez remplir la raison de la validation');
                return;
            }

            try {
                this.loading = true;
                await api.demande_clinique.reponses.valider(this.checkedReponses, this.raisonValidation.description);
                await this.chargerDepots();
                this.raisonValidationOpened = false
                this.checkedReponses = []
                this.raisonValidation.description = "" 
                this.loading = false;
            } catch (e) {
                console.error(e);
                window.alert('Une erreur est survenue');
                this.loading = false;
            }
        }
    },
    components: {  }
}
</script>

<template>
    <div>

        <div class="my-4 p-2 border border-gray rounded-xl bg-gray-100 flex flex-col gap-2" v-if="reponsesFiltered.length">
            <div class="border border-dashed border-2 bg-white px-4 py-2 flex flex-row gap-4"  v-for="reponse in reponsesFiltered" :key="reponse.id">
                <input  type="checkbox" :id="reponse.id" :value="reponse.id" v-model="checkedReponses" @click="raisonValidationOpened = false">
                <section>
                    <p class="text-base font-semibold text-red-500">Type: <span class="text-base text-gray-700 font-light">{{ getTypeLabel(reponse.type) }}</span></p>
                    <p class="text-base font-semibold">Titre: <span class="text-base text-gray-700 font-light">{{ reponse.titre }}</span></p>
                    <p class="text-base font-semibold">Description: <span class="text-base text-gray-700 font-light">{{ reponse.description }}</span></p>
                    <p class="text-base font-semibold">Date de création: <span class="text-base text-gray-700 font-light">{{ reponse.date_creation }}</span></p>
                </section>
            </div>
        </div>
        <div class="flex items-center justify-center" v-else>
          <p class="text-base font-semibold">Aucune réponse</p>
        </div>
        <button class="border-2 border-blue-500 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-2" @click="$router.push(`/depots/${idDepot}`)" v-if="!isRaisonValidationOpen">Répondre à la demande</button>
        <button  class="border-2 border-blue-500 hover:enabled:bg-blue-200 disabled:opacity-50 text-blue-500 font-bold py-2 px-4 rounded mt-2" @click="openValidationModal" v-if="reponsesFiltered.length && !isRaisonValidationOpen" :disabled="isDisabled">Valider les réponses</button>

        <Transition name="fade">
            <form class="flex flex-col gap-2 mt-2" @submit.prevent="validerReponses" v-if="isRaisonValidationOpen">
                <textarea v-model="raisonValidation.description" placeholder="Raison de la validation" class="border border-gray-300 rounded-lg p-2"></textarea>
            
                <div>
                    <button type="button" @click.prevent="raisonValidationOpened = false; raisonValidation.description = ''" :disabled="loading" :class="{ 'cursor-not-allowed': loading,}"
                        class="bg-yellow-500 hover:bg-yellow-700 text-yellow font-bold py-2 px-4 rounded"
                    >{{ 'Annuler' }}</button>
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                        :class="{
                            'cursor-not-allowed': loading,
                        }"
                        :disabled="loading"
                    >{{ loading ? 'En cours' : 'Valider réponses' }}</button>
                    
                </div>
            </form>
        </Transition>
    </div>
</template>