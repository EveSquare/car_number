
Vue.use(VTooltip);

Vue.component('comment', {
  delimiters: ['[[', ']]'],
  props: {
    evaluation: {
      type: String,
    },
    title: {
      type: String,
    },
    content: {
      type: String,
    },
  },
  data: function(){
    return {
      _evaluation: null,
      _title: null,
      _content: null,
      is_hidden: true,
    }
  },
  methods: {
    hidden() {
      this.is_hidden = !this.is_hidden;
    },
  },
  computed: {},
  created: function() {
    this._evaluation = this.evaluation;
    this._title = this.title;
    this._content = this.content;
  },
  template: `
  <div class="comments">
    <div class="comment-card">
      <div class="comment-body">
        <p>[[ evaluation ]]</p>
        <h5 class="comment-title">[[ _title ]]</h5>
        <hr>
          <template v-if="evaluation == '+'">
            <p class="comment-content">
              [[ _content ]]
            </p>
          </template>
          <template v-else>
            <p v-if="!is_hidden" class="comment-content">
              [[ _content ]]
            </p>
          </template>
      </div>
      <button v-if="evaluation != '+'" class="btn-show" @click="hidden()">続きを見る+</button>
    </div>
  </div>
  `
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