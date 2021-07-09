
Vue.use(VTooltip);

Vue.component('comment', {
  delimiters: ['[[', ']]'],
  props: {
  },
  data: function(){
    return {}
  },
  methods: {},
  computed: {},
  template: ``
})

new Vue({
  el: '#app',
  delimiters: ['[[', ']]'],
  data: {
  	positive: '17件',
  	normal: '1件',
  	negative: '20件',
  },
  methods: {
  },
  computed: {
  },
});