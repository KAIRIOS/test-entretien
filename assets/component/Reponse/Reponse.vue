<script>
import { getLabel } from '@/enum/demande_clinique/reponse/type';
export default {
  name: "Reponse",
  props: {
    /** @type {Reponse} reponse **/
    reponse: {
      type: Object,
      default: null,
    },
    onCheck: {
      type: Function,
      default: null,
    }
  },
  methods: {
    getTypeLabel: getLabel,
    hasValidation: (reponse) => !!reponse.reponse_validation,
    onCheckboxChange: function (e) {
      this.onCheck(e.target.checked, this.reponse.id);
    }
  }
}
</script>

<template>
<div class="reponse">
  <p class="text-red-500">Type: <span>{{ getTypeLabel(reponse.type) }}</span></p>
  <p>Titre: <span>{{ reponse.titre }}</span></p>
  <p>Description: <span>{{ reponse.description }}</span></p>
  <p>Date de création: <span>{{ reponse.date_creation }}</span></p>
  <p>Validé le:
    <span v-if="hasValidation(reponse)">{{ reponse.reponse_validation.date_creation }}</span>
    <span v-else>Non validé</span>
  </p>
  <p v-if="hasValidation(reponse)">Message de validation: <span>{{ reponse.reponse_validation.description }}</span></p>
  <div class="flex justify-end items-center cursor-pointer" v-if="!hasValidation(reponse)">
    <label :for="reponse.id + 'validation-checkbox'" class="mr-2">Selectionner</label>
    <input type="checkbox" :id="reponse.id + 'validation-checkbox'"  @change="onCheckboxChange">
  </div>
</div>
</template>

<style scoped>
.reponse {
  @apply border border-dashed border-2 bg-white px-4 py-2
}

.reponse > p {
  @apply text-base font-semibold
}

.reponse > p > span {
  @apply text-base text-gray-700 font-light
}
</style>