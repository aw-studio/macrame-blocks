<template>
    <slot name="button" :open="() => (isOpen = true)">
        <ButtonRound white sm @click="isOpen = true">
            <IconPlus class="w-4 h-4" />
        </ButtonRound>
    </slot>
    <Modal lg v-model:open="isOpen" title="New Block">
        <form @submit.prevent="submit">
            <div class="space-y-3">
                <Input label="Name" v-model="form.name" />
            </div>
            <input type="submit" class="hidden" />
        </form>
        <template v-slot:footer>
            <Button @click="submit"> Save </Button>
        </template>
    </Modal>
</template>

<script lang="ts" setup>
import { defineEmits, ref } from 'vue';
import {
    Modal,
    Input,
    ButtonRound,
    Button,
    IconPlus,
} from '@macramejs/admin-vue3';
import { useForm } from '@macramejs/macrame-vue3';
import { Block } from '@admin/types/resources';
import { Inertia } from '@inertiajs/inertia';

const isOpen = ref<boolean>(false);

const emit = defineEmits(['blockAdded', 'close']);

const form = useForm({
    route: `/admin/blocks`,
    data: {
        name: '',
    },
    method: 'post',
    onSuccess(response) {
        emit('blockAdded', this);
        isOpen.value = false;
        form.reset();

        // Visit the recently created block, to refresh the Block/Show component
        // when currently already on a block.
        Inertia.visit(`/admin/blocks/${response.props.block.data.id}`, {
            only: ['block'],
        });
    },
});

const submit = function () {
    form.submit();
};
</script>
