<template>
  <div
      @click="!reponse.est_validee ? (selectResponse(reponse), $emit('selectResponse', isSelected, reponse.id)) : '';"
      class="border border-dashed border-2 px-4 py-2"
      :class="{
        'bg-green-900 bg-opacity-25': reponse.est_validee,
        'bg-green-500 bg-opacity-25': isSelected,
        'bg-white': !isSelected && !reponse.est_validee
      }">
    <p class="text-base font-semibold text-red-500">Type: <span class="text-base text-gray-700 font-light">{{ getTypeLabel(reponse.type) }}</span></p>
    <p class="text-base font-semibold">Titre: <span class="text-base text-gray-700 font-light">{{ reponse.titre }}</span></p>
    <p class="text-base font-semibold">Description: <span class="text-base text-gray-700 font-light">{{ reponse.description }}</span></p>
    <p class="text-base font-semibold">Date de création: <span class="text-base text-gray-700 font-light">{{ reponse.date_creation }}</span></p>
    <p class="text-base font-semibold" v-if="reponse.est_validee">Raison de la validation: <span class="text-base text-gray-700 font-light">{{ reponse.validation_raison }}</span></p>
  </div>
</template>

<script>
import {getLabel} from '@/enum/demande_clinique/reponse/type';

export default {
  name: 'Reponse',
  props: ['reponse'],
  data() {
    return {
      isSelected: false,
    }
  },
  methods: {
    getTypeLabel: getLabel,
    selectResponse() {
      this.isSelected = !this.isSelected;
    }
  }
}
</script>