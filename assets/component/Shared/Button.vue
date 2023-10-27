<script>
export default {
  name: "Button",
  props: {
    label: String,
    onClick: {
      default: () => {},
      type: Function
    },
    show: false
  }
}
</script>

<template>
  <button

      class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-2"
      @click="onClick()">
        {{label}}
  </button>
</template>

<style scoped>

</style>