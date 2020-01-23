<template>
  <div class="editorHtml" ref="editor"></div>
</template>
<script>
import Quill from 'quill'
  export default {
    props: {
      value: {
        type: String,
        default: ''
      },
      name: String
    },
    data () {
      return {
        editor: null,
        content: null,
        lastHtmlValue: '',
        editorId: null,
        toolbarId: null
      }
    },
     mounted () {
      this.editor = new Quill(this.$refs.editor, {
        modules: {
            toolbar: [
                [{ header: [1, 2, 3, 4, false] }],
                ['bold', 'italic', 'underline'],
                ['image', 'code-block']
            ]
          },
          theme: 'snow',
          formats: ['bold', 'underline', 'header', 'italic', 'code-block']
      });
      this.editor.root.innerHTML = this.value;
      this.editor.on('text-change', () => {});
    },
    methods: {
      update() {
        this.$emit('input', this.editor.getText() ? this.editor.root.innerHTML : '');
      }
    },
   
    watch: {
      
    }
  }
</script>