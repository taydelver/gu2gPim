<template>

  <slide-panel title="Add Options" @close="close" :open="show">
   
      <form @submit.prevent="runGenerate">
     <draggable @end="onEnd" v-model="groupData" ghost-class="ghost" chosen-class="drag-selected">
          <transition-group type="transition" name="flip-list">
            <add-product-option-group :validate.sync="validate" :value-errors="valueErrors" :updated="groupData[key]" :error="errorFor" :can-delete="canDeleteGroup" @group="checkGroup(key, $event)" @data="getData(key, $event)" v-for="(item, key) in groupData" :key="key" @remove="removeItem(key, $event)"></add-product-option-group>
          </transition-group>
     </draggable>
      <base-button v-show="canAddGroup" @click="addOptionGroup" size="sm" outline type="primary">
        <i class="fas fa-plus mr-1"></i>Add Option
        </base-button>
        
        <div class="panel-footer" slot="footer">
          <base-button native-type="submit" size="lg" type="primary">Add to Product</base-button>
        </div>
      </form>
  </slide-panel>
</template>

<script>
import AddProductOptionGroup from '../../components/AddProductOptionGroup'
import draggable from 'vuedraggable'
export default {
  components: {
    AddProductOptionGroup,
    draggable
  },
  props: {
    show: Boolean,
    type: String,
  },
  data() {
    return {
      newInputGroups: [1],
      groupData: [{group: null, values: []}],
      error: null,
      errorFor: {
        type: null,
        value: null
      },
      valueErrors: false,
      validate: false
    }
  },
  watch: {
    groupData() {
      
    },
    validate() {
      console.log(this.validate)
    }
  },
  methods: {
    close(e) {
      this.$emit('close')
    },
    submitVariants(e) {
      this.validate = true
    },
    onEnd(evt) {
  
    },
    validateFields() {

    },
    getData(index, e) {
      if(this.selectedGroups.indexOf(e.group) > -1 && this.selectedGroups.indexOf(e.group) != index) {
        this.errorFor.value = e.group
        this.errorFor.type = 'duplciate'
      } else {
        this.errorFor.value = null
        this.errorFor.type = null
      }
      this.groupData.splice(index, 1, e)
    },
    handleData(index, e) {
      const x = this.selectedGroups.filter(i => {
        return this.selectedGroups.includes(e)
      })
      return x
    },
    checkGroup(group) {
      return this.selectedGroups.map((g, index) => {
        return index
      })
    },
    removeItem(index, group) {
      if(group == this.errorFor.value) {
        this.errorFor.value = null
        this.errorFor.type = null
      }
      this.groupData.splice(index, 1)
    },
    generateSkus() {

        const values = this.groupData.map(a => a.values.map(b => b.label))
  
        this.valueErrors = false
        const combine = ([head, ...[headTail, ...tailTail]]) => {
          if (!headTail) return head

          const combined = headTail.reduce((acc, x) => {
            return acc.concat(head.map(h => `${h.replace(/\s+/g, '-')}-${x.replace(/\s+/g, '-')}`))
          }, [])

          return combine([combined, ...tailTail])
        }
        return combine(values)
        //  console.log('With N arrays:', combine(values))

    },
    generateSkus2() {

        const values = this.groupData.map(a => a.values.map(b => b.label))
  
        this.valueErrors = false
        const combine = ([head, ...[headTail, ...tailTail]]) => {
          if (!headTail) return head

          const combined = headTail.reduce((acc, x) => {
            return acc.concat(head.map(h => `${h.replace(/\s+/g, '-')}-${x.replace(/\s+/g, '-')}`))
          }, [])

          return combine([combined, ...tailTail])
        }
        return combine(values)
        //  console.log('With N arrays:', combine(values))

    },
    generateOptions() {
      this.$store.dispatch('newVariantData', this.groupData)
    },
    async runGenerate() {
      this.validate = true
      const generate = await this.generateSkus()
      
      this.valueErrors = this.hasValueErrors
      if(generate) {
        this.$emit('generate-skus', generate)
        this.generateOptions()
      }
    },
    addOptionGroup() {
      if(this.canAddGroup) {
        let empty = {
          group: '',
          values: ['']
        }
        this.groupData.push(empty)
      }
    },
    checkOptionGroups(e) {
      return this.selectedGroups.indexOf(e.group) > -1
    },
    // sendEmptyFields(key) {
    //   this.groupData[key].values.filter(v => {
    //     return c.values.includes('') || c.values.length < 1
    //   })

    // }
  },
  computed: {
    canAddGroup() {
      return this.groupData.length < 6 ? true : false
    },
    canDeleteGroup() {
      return this.groupData.length > 1
    },
    selectedGroups() {
      return this.groupData.map(data => {
        return data.group
      }).filter(g => g != null)
    },

    emptyFields() {
      return this.groupData.filter(c => {
        return c.values.includes('') || c.values.length < 1
      })
    },

    checkGroupField() {
      const fields = this.groupData.filter(c => {
        return c.group == '' || c.group == null
      })
      return fields.length > 0
    },

    emptyGroups() {
      const groups = this.groupData.filter(c => {
        return c.group == '' || c.group == null
      })
      return groups
    },

    hasValueErrors() {
      if(this.emptyFields.length > 0) {
        return true
      } else {
        return false
      }
    }

  }
}
</script>