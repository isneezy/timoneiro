<template>
  <select :name="name" :multiple="multiple">
    <option v-if="!multiple" placeholder>{{ placeholder }}</option>
    <slot/>
  </select>
</template>

<script>
  import Choices from 'choices.js'
  export default {
    name: 'FormSelect',
    props: {
      multiple: { type: Boolean, default: false },
      placeholder: { default: null, type: String },
      name: { required: true, type: String }
    },
    mounted() {
      new Choices(this.$el, {
        placeholderValue: this.placeholder,
        removeItemButton: true,
        noResultsText: 'No results found',
        noChoicesText: 'No choices to choose from',
        itemSelectText: 'Press to select',
        addItemText: 'Press Enter to add "${value}"'
      })
    }
  }
</script>