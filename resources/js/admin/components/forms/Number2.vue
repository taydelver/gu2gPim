<template>
  <input @keydown.prevent="checkValue($event)" @blur="convertNumber" type="text" class="form-control" v-model="value">
</template>

<script>
export default {
  props: {
    startValue: String
  },
  data() {
    return {
      value: this.startValue,
      toCheck: ''
    }
  },
  watch: {
    value() {
      this.sendValue()
    }
  },
  mounted() {
    
  },
  methods: {
    sendValue() {
      this.$emit('update:data', this.value)
    },
    checkValue(e) {
      let selectionString = window.getSelection().toString()
      let x;
      const b = /^\d+(?:\.\d{0,2})?$/.test(e.key)
      const isDecFirst = this.valueLength < 1 && this.keyCheck(e, 190) ? true : false
      if(this.value.indexOf('.') == 0) {
        x = /^\d+(?:\.\d{0,2})?$/.test('0' + this.value + e.key)
      }
      const exp = /^\d+(?:\.\d{0,2})?$/.test(this.value + e.key)
      let t = {
        decimal: isDecFirst,
        expression: exp,
        x: x
      }
      if( exp || this.keyCheck(e, 8) || isDecFirst == true || x || b) {
        if(b && selectionString) {
          this.value = this.value.replace(selectionString, '')
        }
        if(this.keyCheck(e, 8) ) {
          if(selectionString) {
              this.value = this.value.replace(selectionString, '')
            
          } else {
            let end = this.valueLength - 1
            this.value = this.value.substring(0, end)
          }
          
        } else if(this.value == '0' && this.keyCheck(e, 48)) {
        } else {
          let val = this.value + e.key
          this.value = val
        }
      }
    },
    convertNumber() {
      if(this.value == '') {
        let n = 0
        this.value = n.toFixed(2)
      } else {
        let n = parseFloat(this.value)
        this.value = n.toFixed(2)
      }
    },
    keyCheck(e, val) {
      return e.keyCode == val || e.which == val ? true : false
    }
  },
  computed: {
    valueLength() {
      return this.value.length
    },
    validator() {
      if(this.value == '.') {
        let n = parseFloat('0.')
        return n.toFixed(2)
      } else {
        let n = parseFloat(this.value)
        return n.toFixed(2)
      }
      
    }
  }
}
</script>