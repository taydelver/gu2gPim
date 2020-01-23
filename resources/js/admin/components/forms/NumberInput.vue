<template>
  <input @input="tester($v.myinput)" @blur="formatValue" type="text" class="form-control" v-model="myinput">
  <!-- <input @keydown.prevent="checkValue($event)" @blur="convertNumber" type="text" class="form-control" v-model="value"> -->
</template>

<script>
import { helpers, required } from 'vuelidate/lib/validators'
const money = helpers.regex('currency', /^\d+(?:\.\d{0,2})?$/)
const startDec = helpers.regex('first', /^\.$/)
const dollars = helpers.regex('first', /^(?:0|[1-9][0-9]*)(?:\.[0-9]{0,2})?$/)

export default {
  props: {
    startValue: String
  },
  data() {
    return {
      value: this.startValue,
      toCheck: '',
      myinput: this.startValue,
      backup: '',
      showError: ''
    }
  },
  validations: {
    myinput: {
      required,
      money,
      isEmpty(value) {
        return value == ''
      },
      startDec,
      dollars
    }
  },
  watch: {
    value() {
      this.sendValue()
    },
  },
  mounted() {
    if(this.startValue) {
      this.formatValue()
    }
  },
  methods: {
    watchValue(e) {
      console.log(e)
    },
    sendValue() {
      this.$emit('update:data', this.value)
    },
    tester(value) {
      console.log(value)
      if(value.dollars) {
        this.showError = false
        this.backup = value.$model
        this.myinput = value.$model
      } else if(value.startDec) {
        this.showError = false
        this.backup = 0 + '.'
        this.myinput = 0 + '.'
      } else {
        this.myinput = this.backup
        this.showError = true
      }
    },
    formatValue() {
      let len = this.myinput.length
      let dot = this.myinput.indexOf('.')
      let decimals = this.myinput.substring(dot + 1, len)
      if(len) {
        if(dot > -1) {
          if(decimals.length == 0) {
            this.myinput = this.myinput + '00'
          } 
          if(decimals.length == 1) {
            this.myinput = this.myinput + '0'
          }
        } else {
          this.myinput = this.myinput + '.00'
        }
      } else {
        this.myinput = '0.00'
      }
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