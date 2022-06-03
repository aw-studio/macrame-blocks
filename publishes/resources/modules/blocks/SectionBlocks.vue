<template>
    <BaseSection>
        <template v-slot:title>
            <DrawerBlocks preview />
        </template>
        <Card>
            <Select
                label="Block"
                v-model="model.block"
                :options="blocks.data"
                label-key="name"
                value-key="id"
            />
        </Card>
    </BaseSection>
</template>
<script setup lang="ts">
import { Card, Section as BaseSection, Select } from '@macramejs/admin-vue3';
import DrawerBlocks from './DrawerBlocks.vue';
import { defineProps, watch, defineEmits, reactive } from 'vue';

import { blocks } from './index';

const emit = defineEmits(['update:modelValue']);

const props = defineProps({
    modelValue: {
        type: Object,
        required: true,
        default: () => ({
            block: null,
        }),
    },
});

const model = reactive(props.modelValue);

watch(
    () => model,
    () => emit('update:modelValue', model),
    { deep: true }
);
</script>
