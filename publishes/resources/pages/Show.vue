<template>
    <BaseLayout v-bind="$attrs">
        <TabGroup :default-index="tabs.indexOf(tab)">
            <TabList>
                <Tab :href="`/admin/blocks/${block.data.id}`">Struktur</Tab>
            </TabList>
            <TabPanels>
                <TabPanel>
                    <Content>
                        <PanelContentBody
                            :form="contentForm"
                            :block="block.data"
                        />
                        <PanelContentSidebar />
                    </Content>
                </TabPanel>
            </TabPanels>
        </TabGroup>
        <template v-slot:topbar-left>
            <span>{{ contentForm.name }}</span>
        </template>
    </BaseLayout>
</template>

<script setup lang="ts">
import { PropType, onBeforeUnmount, onBeforeMount } from 'vue';
import { useForm } from '@macramejs/macrame-vue3';
import { TabGroup, TabList, Tab, Content } from '@macramejs/admin-vue3';
import { TabPanels, TabPanel } from '@headlessui/vue';
import BaseLayout from './Index.vue';
import { saveQueue } from '@admin/modules/save-queue';
import { BlockResource, LinkOption } from '@admin/types/resources';
import { BlockContent } from '@admin/types/forms';
import PanelContentBody from './components/PanelContentBody.vue';
import PanelContentSidebar from './components/PanelContentSidebar.vue';
import { linkOptions as GlobalLinkOptions } from '@admin/modules/links';

const tabs = ['content', 'meta', 'settings'];

const props = defineProps({
    block: {
        type: Object as PropType<BlockResource>,
        required: true,
    },
    tab: {
        type: String,
        required: false,
        default: 'content',
    },
    linkOptions: {
        required: true,
        type: Array as PropType<LinkOption[]>,
    },
});

onBeforeMount(() => {
    GlobalLinkOptions.value = props.linkOptions;
});

const contentFormQueueKey = `block.${props.block.data.id}.content`;
const contentForm = useForm<BlockContent>({
    route: `/admin/blocks/${props.block.data.id}`,
    method: 'put',
    data: {
        name: props.block.data.name,
        content: props.block.data.content || [],
    },
    onDirty: form =>
        saveQueue.add(contentFormQueueKey, async () => form.submit()),
    onClean: () => saveQueue.remove(contentFormQueueKey),
});

onBeforeUnmount(() => {
    if (contentForm.isDirty) {
        if (confirm('Do you want to save your unchanged changes?')) {
            saveQueue.save();
        }
    }
});
</script>
