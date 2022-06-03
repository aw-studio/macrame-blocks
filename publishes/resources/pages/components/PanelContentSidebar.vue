<template>
    <ContentSidebar v-model:open="isOpen">
        <DrawerSection title="Text Components">
            <Cabinet>
                <DrawerTextFull :draws="SectionTextFull" />
                <DrawerTextImage :draws="SectionTextImage" />
                <DrawerInfoBox :draws="SectionInfoBox" />
            </Cabinet>
        </DrawerSection>
        <DrawerSection title="Image Components">
            <Cabinet>
                <DrawerImageFull :draws="SectionImageFull" />
                <DrawerGallery :draws="SectionGallery" />
            </Cabinet>
        </DrawerSection>
        <DrawerSection title="Sections">
            <Cabinet>
                <DrawerCards :draws="SectionCards" />
                <DrawerLogoWall :draws="SectionLogoWall" />
                <DrawerAccordion :draws="SectionAccordion" />
            </Cabinet>
        </DrawerSection>
        <DrawerSection title="Carousels">
            <Cabinet>
                <DrawerCarousel :draws="SectionCarousel" />
            </Cabinet>
        </DrawerSection>
    </ContentSidebar>
</template>

<script lang="ts" setup>
import {
    SectionTextFull,
    SectionCarousel,
    SectionTextImage,
    SectionInfoBox,
    SectionImageFull,
    SectionGallery,
    SectionCards,
    SectionAccordion,
    SectionLogoWall,
} from '../../Page/components/content/sections';

import {
    DrawerTextFull,
    DrawerCarousel,
    DrawerTextImage,
    DrawerInfoBox,
    DrawerImageFull,
    DrawerGallery,
    DrawerCards,
    DrawerAccordion,
    DrawerLogoWall,
} from '../../Page/components/content/drawers';
import { DrawerSection, ContentSidebar } from '@macramejs/admin-vue3';
import { Cabinet } from '@macramejs/macrame-vue3';
import { ref } from 'vue';

const isOpen = ref(true);
</script>
