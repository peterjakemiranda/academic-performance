<template>
  <div>
    <Head title="Grades" />
    <h1 class="mb-8 text-3xl font-bold">Grade Point Average (GPA)</h1>
    <div class="flex items-center justify-between mb-6">
      <search-filter v-model="form.search" class="mr-4 w-full max-w-md" @reset="reset">
        <label class="block text-gray-700">School Year:</label>
        <select v-model="form.school_year" class="form-select mt-1 w-full">
          <option :value="null">All</option>
          <option v-for="school_year in school_years" :key="school_year" :value="school_year">{{ school_year }}</option>
        </select>
        <label class="block mt-3 text-gray-700">Semester:</label>
        <select v-model="form.semester" class="form-select mt-1 w-full">
          <option :value="null">All</option>
          <option v-for="semester in semesters" :key="semester" :value="semester">{{ semester }}</option>
        </select>
        <label class="block mt-3 text-gray-700">Student:</label>
        <select v-model="form.student" class="form-select mt-1 w-full">
          <option :value="null">All</option>
          <option v-for="student in students" :key="student.id" :value="student.id">{{ student.name }}</option>
        </select>
      </search-filter>
      <Link class="btn-indigo" href="/grades/create">
        <span>Create</span>
        <span class="hidden md:inline">&nbsp;Grade</span>
      </Link>
    </div>
    <div class="bg-white rounded-md shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <tr class="text-left font-bold">
          <th class="pb-4 pt-6 px-6">Student ID</th>
          <th class="pb-4 pt-6 px-6">Student Name</th>
          <th class="pb-4 pt-6 px-6">School Year</th>
          <th class="pb-4 pt-6 px-6">Semester</th>
          <th class="pb-4 pt-6 px-6">GPA</th>
          <th class="pb-4 pt-6 px-6"></th>
        </tr>
        <tr v-for="grade in grades.data" :key="grade.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/grades/${grade.id}/edit`">
              {{ grade.student.number }}
              <icon v-if="grade.deleted_at" name="trash" class="flex-shrink-0 ml-2 w-3 h-3 fill-gray-400" />
            </Link>
          </td>
          <td class="border-t">
            <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/grades/${grade.id}/edit`">
              {{ grade.student.name }}
            </Link>
          </td>
          <td class="px-6 py-4 border-t">
              {{ grade.school_year }}
          </td>
          <td class="px-6 py-4 border-t">
              {{ grade.semester }}
          </td>
          <td class="px-6 py-4 border-t">
              {{ grade.gpa }}
          </td>
          <td class="w-px border-t">
            <Link class="flex items-center px-4" :href="`/grades/${grade.id}/edit`" tabindex="-1">
              <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
            </Link>
          </td>
        </tr>
        <tr v-if="grades.data.length === 0">
          <td class="px-6 py-4 border-t" colspan="4">No grades found.</td>
        </tr>
      </table>
    </div>
    <pagination class="mt-6" :links="grades.links" />
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3'
import Icon from '@/Shared/Icon'
import pickBy from 'lodash/pickBy'
import Layout from '@/Shared/Layout'
import throttle from 'lodash/throttle'
import mapValues from 'lodash/mapValues'
import Pagination from '@/Shared/Pagination'
import SearchFilter from '@/Shared/SearchFilter'

export default {
  components: {
    Head,
    Icon,
    Link,
    Pagination,
    SearchFilter,
  },
  layout: Layout,
  props: {
    filters: Object,
    grades: Object,
    school_years: Array,
    semesters: Array,
    students: Array,
  },
  data() {
    return {
      form: {
        search: this.filters.search,
        school_year: this.filters.school_year,
        semester: this.filters.semester,
        student: this.filters.student,
      },
    }
  },
  watch: {
    form: {
      deep: true,
      handler: throttle(function () {
        this.$inertia.get('/grades', pickBy(this.form), { preserveState: true })
      }, 150),
    },
  },
  methods: {
    reset() {
      this.form = mapValues(this.form, () => null)
    },
  },
}
</script>
