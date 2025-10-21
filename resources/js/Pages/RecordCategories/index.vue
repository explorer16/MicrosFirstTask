<template>
    <Head title="Categories"/>
    <AuthenticatedLayout>
        <template #header>
            <el-row>
                <el-col :span="22">
                    <h2 class="text-xl font-semibold leading-tight text-gray-800">
                        Categories list
                    </h2>
                </el-col>
                <el-col :span="2">
                    <el-button
                        type="primary"
                        size="large"
                        @click="create"
                    >
                        Создать
                    </el-button>
                </el-col>
            </el-row>
        </template>
        <div class="py-8 px-6">
            <div class="overflow-x-auto bg-white shadow-md rounded-xl">
                <table class="min-w-full border-collapse" v-loading="loading">
                    <thead>
                        <tr class="bg-gray-100 text-left text-gray-700 uppercase text-sm">
                            <th class="py-3 px-6 border-b">ID</th>
                            <th class="py-3 px-6 border-b">Название</th>
                            <th class="py-3 px-6 border-b">Тип</th>
                            <th class="py-3 px-6 border-b">Дата создания</th>
                            <th class="py-3 px-6 border-b">Действия</th>
                        </tr>
                        <tr class="bg-gray-100 text-left text-gray-700 uppercase text-sm">
                            <th class="py-3 px-6 border-b">
                                <el-input
                                    placeholder="ID"
                                    v-model="filterForm.id"
                                />
                            </th>
                            <th class="py-3 px-6 border-b">
                                <el-input
                                    placeholder="Название"
                                    v-model="filterForm.name"
                                    clearable
                                />
                            </th>
                            <th class="py-3 px-6 border-b">
                                <el-select
                                    v-model="filterForm.type"
                                    placeholder="Тип"
                                    clearable
                                >
                                    <el-option
                                        label="Приход"
                                        value="incoming"
                                    />
                                    <el-option
                                        label="Расход"
                                        value="outgoing"
                                    />
                                </el-select>
                            </th>
                            <th class="py-3 px-6 border-b">
                                <el-date-picker
                                    v-model="filterForm.created_at"
                                    type="datetime"
                                    clearable
                                />
                            </th>
                            <th class="py-3 px-6 border-b"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="category in categories"
                            :key="category.id"
                            class="hover:bg-gray-50 transition-colors"
                        >
                            <td class="py-3 px-6 border-b w-25">{{ category.id }}</td>
                            <td class="py-3 px-6 border-b font-medium text-gray-800">{{ category.name }}</td>
                            <td
                                class="py-3 px-6 border-b"
                                :class="category.type === 'incoming' ? 'text-green-600' : 'text-red-600'"
                            >
                                {{ translateType(category.type) }}
                            </td>
                            <td class="py-3 px-6 border-b text-gray-500">{{ category.created_at }}</td>
                            <td class="py-3 px-6 border-b">
                                <div class="flex gap-2">
                                    <el-button
                                        type="primary"
                                        size="small"
                                        @click="edit(category)"
                                    >
                                        Изменить
                                    </el-button>
                                    <el-button
                                        type="danger"
                                        size="small"
                                        @click="destroy(category.id)"
                                    >
                                        Удалить
                                    </el-button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <el-pagination
                class="m-2"
                :page-size="pagination.per_page"
                :total="pagination.total"
                :current-page="pagination.page"
                :page-sizes="page_sizes"
                background
                layout="sizes, prev, pager, next"
                @size-change="changeSize"
                @current-change="currentChange"
                @prev-click="currentChange"
                @next-click="currentChange"
            />
        </div>

        <el-drawer
            v-model="drawer"
            size="40%"
            direction="rtl"
        >
            <template #header>
                <h3 class="text-lg font-semibold">{{ labels.title }}</h3>
                <el-button
                    class="mr-2"
                    type="primary"
                    size="small"
                    @click="save()"
                >Сохранить</el-button>
            </template>
            <div class="p-4">
                <el-row :gutter="20">
                    <el-col :span="12">
                        <el-input
                            v-model="category.name"
                            placeholder="Название"
                        ></el-input>
                    </el-col>
                    <el-col :span="12">
                        <el-select
                            v-model="category.type"
                            placeholder="Тип"
                        >
                            <el-option
                                label="Приход"
                                value="incoming"
                            />
                            <el-option
                                label="Расход"
                                value="outgoing"
                            />
                        </el-select>
                    </el-col>
                </el-row>
            </div>
        </el-drawer>

    </AuthenticatedLayout>
</template>
<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import axios from "axios";
import _ from 'lodash';
export default {
    components: {AuthenticatedLayout, Head},
    data() {
        return {
            categories: null,
            category: {
                name: '',
                type: '',
            },
            filterForm: {
                id: '',
                name: '',
                type: '',
                created_at: '',
            },
            pagination: {
                page: 1,
                per_page: 5,
                total: 0,
            },
            loading: true,
            error: null,
            drawer: false,
            labels: {},
            method: '',
            page_sizes: [5,10,20,30],
        }
    },
    created() {
        this.debounceLoadCategories = _.debounce(this.loadCategories, 500);
    },
    watch: {
        filterForm: {
            handler: function (val) {
                this.debounceLoadCategories();
            },
            deep: true,
        },
    },
    mounted() {
        this.loadCategories();
    },
    methods: {
        loadCategories() {
            this.loading = true;
            axios.get("/api/record_categories", {
                params: {...this.pagination, ...this.filterForm}
            })
                .then(res => {
                    this.categories = JSON.parse(JSON.stringify(res.data.data));
                    this.pagination = JSON.parse(JSON.stringify(res.data.pagination));
                }).catch(err => {
                this.error = "Ошибка загрузки данных"
            }).finally(fin => {
                this.loading = false;
            });
        },
        translateType(type) {
            const translates = {
                'incoming': 'Приход',
                'outgoing': 'Расход'
            }

            return translates[type];
        },
        create() {
            this.labels = {
                title: 'Создать категорию',
            };
            this.method = 'store';
            this.drawer = true;
        },
        edit(model) {
            this.category = model;
            this.labels = {
                title: 'Редактировать категорию',
            };
            this.method = 'update';
            this.drawer = true;
        },
        async save() {
            if (this.method === 'store') {
                await axios.post(
                    `/api/record_categories`,
                    this.category
                ).then(res => {
                    this.loadCategories();
                    this.drawer = false;
                    this.category = {};
                });
            } else if (this.method === 'update') {
                await axios.patch(
                    `/api/record_categories/${this.category.id}`,
                    this.category
                ).then(res => {
                    this.$notify({
                        type: "success",
                        message: res.message,
                        offset: 130,
                    })
                    this.drawer = false;
                    this.loadCategories();
                    this.category = {};
                });
            }
        },
        destroy(id) {
            axios.delete(`/api/record_categories/${id}`)
                .then((res) => {
                    this.$notify({
                        title: 'Успешно',
                        type: "success",
                        offset: 130,
                        message: res.message
                    });
                    this.loadCategories();
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        currentChange(page) {
            this.pagination.page = page;
            this.loadCategories();
        },
        changeSize(page) {
            this.pagination.per_page = page;
            this.loadCategories();
        }
    }
}
</script>
