<template>
    <Head title="Records"/>
    <AuthenticatedLayout>
        <template #header>
            <el-row>
                <el-col :span="22">
                    <h2 class="text-xl font-semibold leading-tight text-gray-800">
                        Records list
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
                        <th class="py-3 px-6 border-b">Категория</th>
                        <th class="py-3 px-6 border-b">Дата</th>
                        <th class="py-3 px-6 border-b">Сумма</th>
                        <th class="py-3 px-6 border-b">Итого</th>
                        <th class="py-3 px-6 border-b">Комментарий</th>
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
                            <el-select
                                v-model="filterForm.record_category_id"
                                placeholder="Категория"
                                clearable
                            >
                                <el-option
                                    v-for="category in categories"
                                    :key="category.id"
                                    :value="category.id"
                                    :label="category.name"
                                />
                            </el-select>
                        </th>
                        <th class="py-3 px-6 border-b">
                            <el-date-picker
                                v-model="filterForm.date"
                                type="date"
                                clearable
                            />
                        </th>
                        <th class="py-3 px-6 border-b">
                            <el-input
                                type="number"
                                v-model="filterForm.amount"
                                min="0"
                                clearable
                            />
                        </th>
                        <th class="py-3 px-6 border-b"></th>
                        <th class="py-3 px-6 border-b"></th>
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
                        v-for="record in records"
                        :key="record.id"
                        class="hover:bg-gray-50 transition-colors"
                    >
                        <td class="py-3 px-6 border-b w-25">{{ record.id }}</td>
                        <td class="py-3 px-6 border-b font-medium text-gray-800">{{ record.record_category.name }}</td>
                        <td class="py-3 px-6 border-b font-medium text-gray-800">{{ record.date }}</td>
                        <td class="py-3 px-6 border-b font-medium text-gray-800">{{ record.amount }}</td>
                        <td class="py-3 px-6 border-b font-medium text-gray-800">{{ record.total_amount }}</td>
                        <td class="py-3 px-6 border-b font-medium text-gray-800">{{ record.comment }}</td>
                        <td class="py-3 px-6 border-b text-gray-500">{{ record.created_at }}</td>
                        <td class="py-3 px-6 border-b">
                            <div class="flex gap-2">
                                <el-button
                                    type="primary"
                                    size="small"
                                    @click="edit(record)"
                                >
                                    Изменить
                                </el-button>
                                <el-button
                                    type="danger"
                                    size="small"
                                    @click="destroy(record.id)"
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
                <el-form v-model="record">
                    <el-row :gutter="20">
                        <el-col :span="24">
                            <el-form-item label="Дата">
                                <el-date-picker
                                    v-model="record.date"
                                    type="date"
                                    clearable
                                />
                            </el-form-item>
                        </el-col>
                        <el-col :span="12">
                            <el-form-item label="Категория">
                                <el-select
                                    v-model="record.record_category_id"
                                    placeholder="Категория"
                                    clearable
                                >
                                    <el-option
                                        v-for="category in categories"
                                        :key="category.id"
                                        :value="category.id"
                                        :label="category.name"
                                    />
                                </el-select>
                            </el-form-item>
                        </el-col>
                        <el-col :span="12">
                            <el-form-item label="Сумма" >
                                <el-input
                                    type="number"
                                    v-model="record.amount"
                                    :min="0"
                                    clearable
                                />
                            </el-form-item>
                        </el-col>
                        <el-col :span="12">
                            <el-form-item label="Комментарий">
                                <el-input
                                    type="textarea"
                                    v-model="record.comment"
                                />
                            </el-form-item>
                        </el-col>
                    </el-row>
                </el-form>
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
            records: null,
            categories: null,
            record: {
                record_category_id: '',
                status: '',
                amount: '',
                total_amount: '',
                comment: '',
                date: '',
            },
            filterForm: {
                id: '',
                record_category_id: '',
                status: '',
                amount: '',
                comment: '',
                date: '',
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
        this.debounceLoadRecords = _.debounce(this.loadRecords, 500);
    },
    watch: {
        filterForm: {
            handler: function () {
                this.debounceLoadRecords();
            },
            deep: true,
        },
    },
    mounted() {
        this.loadRecordCategoriesInventory();
        this.loadRecords();
    },
    methods: {
        loadRecords() {
            this.loading = true;
            axios.get("/api/records", {
                params: {...this.pagination, ...this.filterForm}
            })
                .then(res => {
                    this.records = JSON.parse(JSON.stringify(res.data.data));
                    console.log(this.records)
                    this.pagination = JSON.parse(JSON.stringify(res.data.pagination));
                }).catch(err => {
                this.error = "Ошибка загрузки данных"
            }).finally(fin => {
                this.loading = false;
            });
        },
        loadRecordCategoriesInventory() {
            axios.get("/api/record_category/inventory")
                .then(res => {
                    console.log(res.data)
                    this.categories = JSON.parse(JSON.stringify(res.data));
                })
        },
        create() {
            this.labels = {
                title: 'Создать запись',
            };
            this.method = 'store';
            this.drawer = true;
        },
        edit(model) {
            this.record = model;
            this.labels = {
                title: 'Редактировать запись',
            };
            this.method = 'update';
            this.drawer = true;
        },
        async save() {
            if (this.method === 'store') {
                await axios.post(
                    `/api/records`,
                    this.record
                ).then(res => {
                    this.loadRecords();
                    this.drawer = false;
                    this.record = {};
                });
            } else if (this.method === 'update') {
                await axios.patch(
                    `/api/records/${this.record.id}`,
                    this.record
                ).then(res => {
                    this.$notify({
                        type: "success",
                        message: res.message,
                        offset: 130,
                    })
                    this.drawer = false;
                    this.loadRecords();
                    this.record = {};
                });
            }
        },
        destroy(id) {
            axios.delete(`/api/records/${id}`)
                .then((res) => {
                    this.$notify({
                        title: 'Успешно',
                        type: "success",
                        offset: 130,
                        message: res.message
                    });
                    this.loadRecords();
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        currentChange(page) {
            this.pagination.page = page;
            this.loadRecords();
        },
        changeSize(page) {
            this.pagination.per_page = page;
            this.loadRecords();
        }
    }
}
</script>
