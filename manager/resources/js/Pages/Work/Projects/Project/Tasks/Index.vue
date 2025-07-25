<script setup>
  import { ref, reactive } from 'vue'
  import ProjectTabs from '@/Components/Work/Projects/ProjectTabs.vue'
  import AppLayout from '@/Layouts/AppLayout.vue'
  import SortIcon from '@/Components/Icons/SortIcon.vue'
  import Pagination from '@/Components/ui/Pagination.vue'
  import Breadcrumbs from '@/Components/ui/Breadcrumbs.vue'
  import TaskFilters from '@/Components/TaskFilters.vue'
  import {
    formatPriority,
    priorityBadgeClass,
    statusBadgeClass,
    typeBadgeClass,
    formatStatus,
    formatType,
  } from '@/Helpers/tasks.helper.js'
  import TasksTabs from '../../../../../Components/Work/Projects/Tasks/TasksTabs.vue'

  const props = defineProps({
    project: Object,
    members: Object,
    filters: Object,
    tasks: Array,
    statuses: Array,
    type: Array,
    priority: Array,
    sort: String,
    direction: String,
    pagination: Object,
  })
  console.log(props, '111111')
  const text = ref(props.filters.text || '')
  const type = ref(props.filters.type || '')
  const status = ref(props.filters.status || '')
  const priority = ref(props.filters.priority || '')
  const author = ref(props.filters.author || '')
  const executor = ref(props.filters.executor || '')
  const roots = ref(props.filters.roots || false)
  const sort = ref(props.filters.sort || false)
  const direction = ref(props.filters.direction ?? 'asc')

  const tasks = ref(props.tasks || [])
  const pagination = reactive({ ...props.pagination })

  function toggleSort(field) {
    if (sort.value === field) {
      direction.value = direction.value === 'asc' ? 'desc' : 'asc'
    } else {
      sort.value = field
      direction.value = 'asc'
    }
    submitFilters(1)
  }

  function submitFilters(page = 1) {
    if (typeof page !== 'number') {
      page = 1
    }

    const query = new URLSearchParams({
      text: text.value,
      type: type.value,
      status: status.value,
      priority: priority.value,
      author: author.value,
      executor: executor.value,
      roots: roots.value ? 1 : '',
      page,
      sort: typeof sort.value === 'string' ? sort.value : 't.id',
      direction: direction.value,
    }).toString()

    window.location.href = `/work/projects/${props.project.id}/tasks?${query}`
  }

  function resetFilters() {
    text.value = ''
    type.value = ''
    status.value = ''
    priority.value = ''
    author.value = ''
    executor.value = ''
    roots.value = ''
    submitFilters()
  }

  function paginationLink(page) {
    const query = new URLSearchParams({
      text: text.value,
      type: type.value,
      status: status.value,
      priority: priority.value,
      author: author.value,
      executor: executor.value,
      roots: roots.value ? 1 : '',
      page,
      sort: typeof sort.value === 'string' ? sort.value : 't.id',
      direction: direction.value,
    }).toString()

    return `/work/projects/${props.project.id}/tasks?${query}`
  }

  function handleSubmit(updatedFilters) {
    text.value = updatedFilters.text
    type.value = updatedFilters.type
    status.value = updatedFilters.status
    priority.value = updatedFilters.priority
    author.value = updatedFilters.author
    executor.value = updatedFilters.executor
    roots.value = updatedFilters.roots
    submitFilters(1)
  }
</script>

<template>
  <AppLayout>
    <Breadcrumbs
      :items="[
        { label: 'Home', href: '/' },
        { label: 'Work', href: '/work' },
        { label: project.name, href: `/work/projects/${project.id}` },
        { label: 'Tasks' },
      ]"
    />

    <ProjectTabs :project-id="project.id" />
    <!-- Tabs -->

    <!-- Add Task Button -->
    <div v-if="project" class="mb-6">
      <a
        :href="`/work/projects/${project.id}/tasks/create`"
        class="inline-block rounded p-3 bg-indigo-800 hover:bg-indigo-700 shadow-lg shadow-indigo-700/40 text-white transition-colors"
        >Add Task</a
      >
    </div>

    <TaskFilters
      :filters="props.filters"
      :types="props.type"
      :statuses="props.statuses"
      :priorities="props.priority"
      :members="props.members"
      :project="props.project"
      @submit="handleSubmit"
      @reset="resetFilters"
    />
    <TasksTabs :project-id="project.id" />
    <!-- Tasks Table -->
    <div
      class="overflow-auto rounded-lg shadow-lg shadow-indigo-800/40"
      tabindex="0"
      aria-label="Tasks list table container"
    >
      <table
        class="min-w-full border-collapse border border-indigo-800 text-indigo-200"
        role="table"
      >
        <thead class="bg-indigo-800 sticky top-0 z-10">
          <tr>
            <th
              @click="toggleSort('t.id')"
              class="border border-indigo-700 p-3 text-left text-sm font-semibold tracking-wide select-none cursor-pointer"
              scope="col"
            >
              ID
              <SortIcon :field="'t.id'" />
            </th>
            <th
              @click="toggleSort('t.date')"
              class="border border-indigo-700 p-3 text-left text-sm font-semibold tracking-wide select-none cursor-pointer"
              scope="col"
            >
              Date
              <SortIcon :field="'t.date'" />
            </th>
            <th
              class="border border-indigo-700 p-3 text-left text-sm font-semibold tracking-wide select-none"
              scope="col"
            >
              Author
            </th>
            <th
              v-if="!project"
              class="border border-indigo-700 p-3 text-left text-sm font-semibold tracking-wide select-none"
              scope="col"
            >
              Project
            </th>
            <th
              class="border border-indigo-700 p-3 text-left text-sm font-semibold tracking-wide select-none"
              scope="col"
            >
              Name
            </th>
            <th
              class="border border-indigo-700 p-3 text-left text-sm font-semibold tracking-wide select-none"
              scope="col"
            >
              Type
            </th>
            <th
              class="border border-indigo-700 p-3 text-left text-sm font-semibold tracking-wide select-none"
              scope="col"
            >
              Priority
            </th>
            <th
              class="border border-indigo-700 p-3 text-left text-sm font-semibold tracking-wide select-none"
              scope="col"
            >
              Executors
            </th>
            <th
              class="border border-indigo-700 p-3 text-left text-sm font-semibold tracking-wide select-none"
              scope="col"
            >
              Plan Date
            </th>
            <th
              class="border border-indigo-700 p-3 text-left text-sm font-semibold tracking-wide select-none"
              scope="col"
            >
              Status
            </th>
            <th
              class="border border-indigo-700 p-3 text-left text-sm font-semibold tracking-wide select-none"
              scope="col"
            >
              Progress
            </th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="task in tasks"
            :key="task.id"
            class="border-t border-indigo-700 hover:bg-indigo-900 transition-colors"
            tabindex="0"
          >
            <td class="border border-indigo-700 p-2 text-sm font-mono">{{ task.id }}</td>
            <td class="border border-indigo-700 p-2 text-sm">
              {{ new Date(task.date).toLocaleDateString() }}
            </td>
            <td class="border border-indigo-700 p-2 text-sm">{{ task.author_name }}</td>
            <td v-if="!project" class="border border-indigo-700 p-2 text-sm">
              <a
                :href="`/work/projects/${task.project_id}`"
                class="hover:text-indigo-300 transition-colors"
              >
                {{ task.project_name }}
              </a>
            </td>
            <td class="border border-indigo-700 p-2 text-sm">
              <span v-if="task.root" class="mr-1"> ➔ </span>
              <a
                :href="`/work/projects/tasks/${task.id}`"
                class="text-indigo-300 hover:underline transition-colors"
              >
                {{ task.name }}
              </a>
            </td>
            <td class="border border-indigo-700 p-2 text-sm">
              <span
                :class="[
                  'inline-block px-2 py-1 rounded text-xs font-semibold',
                  typeBadgeClass(task.type),
                ]"
              >
                {{ formatType(task.type) || 'NONE' }}
              </span>
            </td>

            <td class="border border-indigo-700 p-2 text-sm text-center">
              <span
                :class="[
                  'inline-block px-2 py-1 rounded text-xs font-semibold',
                  priorityBadgeClass(task.priority),
                ]"
              >
                {{ formatPriority(task.priority) || 'NONE' }}
              </span>
            </td>

            <td class="border border-indigo-700 p-2 text-sm gap-1">
              <span
                v-for="executor in task.executors"
                :key="executor.name"
                class="inline-block bg-indigo-700 text-indigo-100 px-2 py-0.5 rounded select-none"
              >
                {{ executor.name }}
              </span>
            </td>
            <td class="border border-indigo-700 p-2 text-sm">
              {{ task.plan_date ? new Date(task.plan_date).toLocaleDateString() : '' }}
            </td>

            <td class="border border-indigo-700 p-2 text-sm">
              <span
                :class="[
                  'inline-block px-2 py-1 rounded text-xs font-semibold',
                  statusBadgeClass(task.status),
                ]"
              >
                {{ formatStatus(task.status) || 'NONE' }}
              </span>
            </td>

            <td class="border border-indigo-700 p-2 text-sm text-center">
              <div class="w-full bg-indigo-900 rounded-full h-4 relative overflow-hidden">
                <div
                  class="bg-indigo-500 h-4 rounded-full transition-all duration-500 ease-in-out"
                  :style="{ width: (task.progress ?? 0) + '%' }"
                ></div>
                <div
                  class="absolute inset-0 flex items-center justify-center text-xs font-semibold text-indigo-100 select-none"
                >
                  {{ task.progress ? task.progress + '%' : '0%' }}
                </div>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <Pagination :pagination="pagination" :linkBuilder="paginationLink" />
  </AppLayout>
</template>

<style scoped>
  div[tabindex='0']::-webkit-scrollbar {
    height: 8px;
    width: 8px;
  }

  div[tabindex='0']::-webkit-scrollbar-track {
    background: #0e0f11;
    border-radius: 8px;
  }

  div[tabindex='0']::-webkit-scrollbar-thumb {
    background: #4c51bf;
    border-radius: 8px;
    border: 2px solid #0e0f11;
  }
  div[tabindex='0']::-webkit-scrollbar-thumb:hover {
    background: #6366f1;
  }
</style>
