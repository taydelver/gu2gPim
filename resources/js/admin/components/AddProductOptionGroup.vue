<template>
  <div class="option-input-group">
    <div class="sort-grabber"><i class="fas fa-grip-vertical"></i></div>
    <div class="row">
    <div class="col-md-6">
    <form-group :error="handleError" class="mb-2" label="Option Group">
        <el-select @change="sendData('group')" v-model="selected.group" filterable
                  placeholder="">
          <el-option v-for="option in optionGroups"
                      :key="option.id"
                      :label="option.display_name"
                      :value="option.display_name">
          </el-option>
        </el-select>
        <div v-if="validate && checkEmpty" class="form-feedback form-feedback--error">This field is required.</div>
      </form-group>
      <base-action-link v-show="canDelete" @click="removeSelf" icon="fas fa-plus">Delete Option</base-action-link>
    </div>
    <div class="col-md-6">
      
      <form-group class="mb-2" label="Values">
        <draggable @sort="onSort" :disabled="disableDrag" v-model="selected.values" ghost-class="ghost" @end="onEnd" @choose="onChoose">
          <transition-group type="transition" name="flip-list">

            <div v-for="(val, key) in selected.values" :key="key" class="option-group">
            <div class="d-flex align-items-center option-group-input-wrapper">
                <div @mouseenter="handleDrag('grabber', $event)" class="sort-grabber"><i class="fas fa-grip-vertical"></i></div>
             
                  <input type="text" :value="val.label" disabled class="form-control">
                  
        
                <base-icon @click="removeValue(key)" v-if="canDeleteValue" class="ml-2" type="danger" icon="fas fa-minus-circle" size="sm"></base-icon>
                </div>

                <div v-if="validate && checkValues(key)" class="form-feedback form-feedback--error">This field is required.</div>
                
            </div>
          </transition-group>
        <!-- <base-action-link @click="addValueField" icon="fas fa-plus">Add Value</base-action-link> -->
        </draggable>
      </form-group>
      <base-action-link @click="addValueField" icon="fas fa-plus">Add Value</base-action-link>
      </div>
      </div>
  </div>
</template>

<script>

import draggable from 'vuedraggable'


export default {
  components: {
    draggable
  },
  props: {
    canDelete: Boolean,
    error: Object,
    updated: Object,
    valueErrors: Boolean,
    validate: Boolean
  },
  data() {
    return {
      optionGroups: [],
      optionValues: [],
      selected: {
        group: '',
        values: ['']
      },
      defaults: {
        value: 0
      },
      oldIndex: '',
      newIndex: '',
      disableDrag: false,
      valueRows: [''],
      showErrors: false,
      ignoreErrors: [],
      shouldValidate: true,
    }
  },
  
  watch: {
    updated() {
      this.selected = this.updated
    },
    validate() {
      
    },
    valueErrors() {
      this.showErrors = this.valueErrors
      
    },
    showErrors() {
     
    },
    selected: {
      handler(val, old) {
       this.selected.values = this.currentOptionGroup.values
      },
      deep: true
    }
  },
  created() {
    this.fetchOptionGroups()
    this.fetchOptionValues()
  },
  
  methods: {
    onEnd(evt) {
      this.sendData()
      
      console.log(evt)
    },
    onChoose(evt) {
      
    },
    onSort(evt) {
      console.log(evt)
    },
    sendData(type) {
      if(type == 'group') {
        this.$emit('group', this.selected.group)
      }
      this.$emit('data', this.selected)
    },
    handleData() {

    },
    removeSelf() {
      this.$emit('remove', this.selected.group)
    },
    addValueField() {
      this.selected.values.push('')
    },
    valueFocus(x, evt) {
        this.disableDrag = true
    },
    handleDrag(x, evt) {
      if(x == 'focus') {
        this.disableDrag = true
       
      } else {
        this.disableDrag = false
      }
    },
    checkOption(label) {
      if(this.selected.values.length) {
        return this.formatSelectedValues.includes(this.formatValue(label))
      } else {
        return false
      }
    },
    checkValues(key) {
        if(this.selected.values[key] == '' || this.selected.values[key] == null) {
          return true
        } else {
          return false
        }
    },
    formatValue(val) {
      return val.toLowerCase()
    },
    removeValue(key) {
      if(this.canDeleteValue) {
        this.selected.values.splice(key, 1)
      }
    },
    fetchOptionGroups() {
      axios.get('/api/products/option-groups')
      .then(res => {
        this.optionGroups = res.data.data
      })
    },
    fetchOptionValues() {
      axios.get('/api/products/option-values')
      .then(res => {
        this.optionValues = res.data.data
      })
    },
    fetchOptionGroupValues() {
      axios.get(`/api/products/option-group/${this.currentOptionGroup.id}/values`)
      .then(res => {
        this.selected.values = res.data.data
      })
    },
  },
  computed: {
    currentOptionGroup() {
      const x = this.optionGroups.filter(g => g.display_name == this.selected.group)
      return x[0]
    },
    valuesOnly() {
      let x = []
      this.optionValues.forEach(ov => {
        ov.values.forEach(v => {
          x.push(v.id)
        });
      })
      return x
    },
    formatSelectedValues() {
      const x = this.selected.values.map(v => v.toLowerCase())
      return x
    },

    canDeleteValue() {
      return this.selected.values.length > 1
    },
    handleError() {
      return this.hasError ? 'There is an existing option with this display name.' : null

    },
    checkEmpty() {
      if(this.selected.group == '' || this.selected.group == null) {
        return true
      }
    },
    hasError() {
      if(this.error.value == this.selected.group) {
        return true
      }
    }
  }
}
</script>

<style lang="scss">
  .option-input-group {
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    margin-bottom: 1.5rem;
    display: flex;
    > .row {
      width: 100%;
    }
    > .sort-grabber {
      z-index: 1;
      position: relative;
      top: 35px;
    }
  }
  .option-group-input-wrapper {
    margin-bottom: 0.75rem;
  }
</style>