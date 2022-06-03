<template>
    <ContentSidebar v-model:open="isOpen">
        <Drawers :sections="drawsSections" />
    </ContentSidebar>
</template>

<script lang="ts" setup>
import { Drawers, sections } from '@admin/modules/content';
import { ref } from 'vue';

// allow all sections except for `block`
let drawsSections = {};
for(let key in sections) {
    if(key != 'blocks') drawsSections[key] = true;
}

const isOpen = ref(true);
</script>
