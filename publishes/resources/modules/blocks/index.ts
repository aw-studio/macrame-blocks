export { default as DrawerBlocks } from './DrawerBlocks.vue';
export { default as SectionBlocks } from './SectionBlocks.vue';

import { BlockCollectionResource } from "@admin/types";
import { ref } from "vue";

export const blocks = ref<BlockCollectionResource>();

