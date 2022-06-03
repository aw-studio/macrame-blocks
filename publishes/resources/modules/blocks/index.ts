export { default as DrawerBlocks } from './DrawerBlocks.vue';
export { default as SectionBlocks } from './SectionBlocks.vue';

import { BlockCollectionResource } from "@admin/types";
import { useIndex } from "@macramejs/macrame-vue3";

export const blocks = useIndex({
    route: `/admin/blocks/items`,
    syncUrl: true
});

