<template>
  <Transition>
    <div class="modal-mask">
      <div class="modal-wrapper">
        <div class="modal-container">

          <div class="modal-header">
            <slot name="header">
              <p class="text-xl">Indiquez une raison pour la validation des réponses selectionnées</p>
            </slot>
          </div>

          <div class="modal-body">
            <slot name="body">
              <textarea rows="10" v-model="reason"></textarea>
            </slot>
          </div>

          <div class="modal-footer">
            <slot name="footer">
              <button
                  class="text-white font-bold py-2 px-4 rounded mt-2"
                  @click="$emit('updateReason', reason); toggleIsLoading();"
                  :class="{
                    'hover:bg-blue-700 bg-blue-500': !isLoading,
                    'bg-blue-300 cursor-not-allowed': isLoading,
                  }"
                  :disabled="isLoading"
              >{{ isLoading ? 'En cours' : 'Valider les réponses' }}
              </button>
            </slot>
          </div>
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
export default {
  name: 'ValidationReasonModal',
  data() {
    return {
      isLoading: false,
      reason: '',
    }
  },
  methods: {
    toggleIsLoading() {
      this.isLoading = !this.isLoading;
    }
  }
}
</script>