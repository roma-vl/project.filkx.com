<script setup>
  import { ref } from 'vue'

  const props = defineProps({
    modelValue: {
      type: Array,
      default: () => [],
    },
  })

  const emit = defineEmits(['update:modelValue'])

  const input = ref('')

  const addTag = () => {
    const trimmed = input.value.trim()
    if (trimmed && !props.modelValue.includes(trimmed)) {
      emit('update:modelValue', [...props.modelValue, trimmed])
      input.value = ''
    }
  }

  const removeTag = index => {
    const updated = [...props.modelValue]
    updated.splice(index, 1)
    emit('update:modelValue', updated)
  }
</script>

<template>
  <div
    class="flex flex-wrap items-center border dark:border-gray-800 rounded p-2 min-h-[44px] focus-within:ring-2 dark:bg-gray-800"
    @click="$refs.realInput.focus()"
  >
    <span
      v-for="(tag, index) in modelValue"
      :key="index"
      class="bg-blue-200 text-blue-800 dark:text-blue-900 dark:bg-blue-400 px-2 py-1 rounded flex items-center mr-2 mb-1"
    >
      {{ tag }}
      <button class="ml-1 text-red-600 font-bold" @click.stop="removeTag(index)">×</button>
    </span>

    <input
      ref="realInput"
      v-model="input"
      :placeholder="$t('Type an option and Enter')"
      class="flex-grow min-w-[150px] border-none outline-none dark:bg-gray-900"
      @keydown.enter.prevent="addTag"
      @keydown.delete="input === '' && modelValue.length && removeTag(modelValue.length - 1)"
    />

    <input type="hidden" name="variants" :value="JSON.stringify(modelValue)" />
  </div>
</template>
