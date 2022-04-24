import { createApp, h } from 'vue'
import { InertiaProgress } from '@inertiajs/progress'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import VueApexCharts from "vue3-apexcharts";

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

InertiaProgress.init()

createInertiaApp({
  resolve: name => require(`./Pages/${name}`),
  title: (title) => `${title} - ${appName}`,
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .mixin({ methods: { route } })
      .use(VueApexCharts)
      .mount(el)
  },
})
