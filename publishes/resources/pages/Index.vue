<template>
    <Admin sidebar-secondary>
        <template v-slot:sidebar-secondary>
            <SidebarSecondary>
                <template v-slot:header>
                    <div class="flex items-center justify-between w-full">
                        <span class="inline-block text-xl font-medium">
                            Blöcke
                        </span>
                        <AddBlockModal />
                    </div>
                </template>
                <template v-slot:default>
                    <SidebarSecondarySection>
                        <SidebarLink
                            v-for="block in blocks.data"
                            class="flex-1 py-1 cursor-pointer"
                            :href="`/admin/blocks/${block.id}`"
                            secondary
                            :active="isActive(block)"
                        >
                            {{ block.name }}
                        </SidebarLink>
                    </SidebarSecondarySection>
                </template>
            </SidebarSecondary>
        </template>
        <template v-slot:topbar-left>
            <slot name="topbar-left" />
        </template>
        <slot />
    </Admin>
</template>

<script setup lang="ts">
import { PropType } from 'vue';
import { Admin } from '@admin/layout';
import { Block, BlockCollectionResource } from '@admin/types';
import {
    SidebarSecondary,
    SidebarLink,
    SidebarSecondarySection,
} from '@macramejs/admin-vue3';
import AddBlockModal from './components/AddBlockModal.vue';

const props = defineProps({
    blocks: {
        type: Object as PropType<BlockCollectionResource>,
        required: true,
    },
});

const isActive = (block: Block) => {
    return window.location.pathname == `/admin/blocks/${block.id}`;
};
</script>
