<template>
    <ContentBody>
        <Sections v-model="form.content" :sections="sections" />
    </ContentBody>
</template>

<script lang="ts" setup>
import { Sections, ContentBody } from '@macramejs/admin-vue3';
import { defineProps, PropType } from 'vue';
import { sections } from '../../Page/components/content/sections';
import { Block } from '@admin/types/resources';
import { BlockContentForm } from '@admin/types/forms';

const props = defineProps({
    block: {
        type: Object as PropType<Block>,
        required: true,
    },
    form: {
        type: Object as PropType<BlockContentForm>,
        required: true,
    },
});
</script>
