<script setup lang="ts">
import BreezeGuestLayout from "@/Layouts/Guest.vue";
import { Head } from "@inertiajs/inertia-vue3";
import type { Header, Item, ServerOptions } from "vue3-easy-data-table";
import { ref, watch } from "vue";

const headers: Header[] = [
    { text: "ID", value: "id" },
    { text: "Sender", value: "sender" },
    { text: "Message", value: "metadata" },
];

const items = ref<Item[]>([]);

const loading = ref(false);
const serverItemsLength = ref(0);
const serverOptions = ref<ServerOptions>({
    page: 1,
    rowsPerPage: 25,
    sortBy: "id",
    sortType: "asc",
});

const loadFromServer = async () => {
    loading.value = true;

    const resp = await axios.get(
        "http://localhost/api/notifications?page=" +
            serverOptions.value.page +
            "&limit=" +
            serverOptions.value.rowsPerPage
    );
    const { total, data } = resp.data;

    items.value = data;
    serverItemsLength.value = total;
    loading.value = false;
};

// initial load
loadFromServer();

watch(
    serverOptions,
    (value) => {
        loadFromServer();
    },
    { deep: true }
);
</script>

<template>
    <BreezeGuestLayout>
        <Head title="Notifications" />

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Notifications
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <EasyDataTable
                            v-model:server-options="serverOptions"
                            :server-items-length="serverItemsLength"
                            :headers="headers"
                            :items="items"
                            :loading="loading"
                            alternating
                            buttons-pagination
                        >
                            <template #item-metadata="item">
                                <span v-if="item.type == 'comment'">
                                    <b>{{ item.metadata.user }}</b> has
                                    commented.
                                </span>
                                <span v-if="item.type == 'joint'">
                                    <b>{{ item.metadata.user }}</b> has joint
                                    the fund formation
                                    <b>{{ item.metadata.formation }}</b
                                    >.
                                </span>
                                <span v-if="item.type == 'fund'">
                                    The formation
                                    <b>{{ item.metadata.formation }}</b> has
                                    been funded by
                                    <b>{{ item.metadata.user }}</b
                                    >.
                                </span>
                            </template>
                        </EasyDataTable>
                    </div>
                </div>
            </div>
        </div>
    </BreezeGuestLayout>
</template>

<script lang="ts">
import Vue3EasyDataTable from "vue3-easy-data-table";
import "vue3-easy-data-table/dist/style.css";
import axios from "axios";

export default {
    components: {
        EasyDataTable: Vue3EasyDataTable,
    },
};
</script>
