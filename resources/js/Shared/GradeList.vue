<template>
  <div class="relative overflow-x-auto sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Year
                </th>
                <th scope="col" class="px-6 py-3">
                    Semester
                </th>
                <th scope="col" class="px-6 py-3">
                    GPA
                </th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="grade in grades" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700" :key="grade.id">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                    {{grade.school_year}}
                </th>
                <td class="px-6 py-4">
                    {{semesters[grade.semester]}}
                </td>
                <td class="px-6 py-4">
                    {{grade.gpa}}
                </td>
            </tr>
        </tbody>
    </table>
  </div>
</template>

<script>

export default {
  data() {
    return {
      semesters: {
        '1': '1st Semester',
        '2': '2nd Semester',
      },
    }
  },
  props: {
    grades: {
      type: Array,
    },
  },
}
</script>
