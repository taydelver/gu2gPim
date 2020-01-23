<template>

  <slide-panel title="Add Options" @close="close" :open="show">
     <draggable v-model="selected" ghost-class="ghost" chosen-class="drag-selected">
          <transition-group type="transition" name="flip-list">
            <draggable-item icon-align="top" :can-delete="canDeleteGroup" @remove="removeGroup(key, item.id)" v-for="(item, key) in $v.selected.$each.$iter" :key="key">
              <form-group class="w-100 mb-0" label="Option Group">
                <el-select @change="checkUnique(key, $event)" class="w-100" :value="item.id" v-model="selected[key]" value-key="id" filterable
                          placeholder="">
                  <el-option v-for="option in optionGroups"
                              :key="option.id"
                              :label="option.name"
                              :disabled="checkOption(option.id)"
                              :value="option">
                  </el-option>
                </el-select>
                 <div class="error text-danger" v-if="$v.selected.$each[key].id.$invalid && showErrors">This field is required!</div>
                <select v-model="selected[key].selectedValues" multiple class="form-control multiselect-list">
                  <option v-for="val in item.$model.values" :key="val.id" :value="val.id">{{val.label}}</option>
                </select>
                <div class="error text-danger" v-if="$v.selected.$each[key].selectedValues.$invalid && showErrors">Must select 2 values!</div>
              </form-group>
            </draggable-item>
          </transition-group>
     </draggable>
     <base-action-link @click="addOptionGroup" icon="fas fa-plus">Add Group</base-action-link>
        <div class="panel-footer" slot="footer">
          <base-button @click="saveOptions" size="lg" type="primary">Add Options</base-button>
        </div>
  </slide-panel>
</template>

<script>
import AddProductOptionGroup from '../../components/AddProductOptionGroup'
import draggable from 'vuedraggable'
import { required, minLength } from "vuelidate/lib/validators";
import CustomValidator from '../../functions/CustomValidator';
export default {
  components: {
    AddProductOptionGroup,
    draggable
  },
  props: {
    show: Boolean,
    type: String,
  },
  validations: {
    selected: {
      $each: {
        selectedValues: {
          required,
          minLength: minLength(2)
        },
        id: {
          required
        }
      }
    }
  },
  data() {
    return {
      optionGroups: [],
      optionValues: [],
      newInputGroups: [1],
      selected: [],
      showErrors: false
    }
  },
  watch: {
    selected() {
      this.selected.forEach((item, index) => {
        if(item !== '') {
          item.sort_order = index
        }
      })
    }
  },
  created() {
    this.fetchOptionGroups()
    this.fetchOptionValues()
  },
  methods: {
    checkOption(id) {
      const x = this.selected.filter(item => item.id == id)
      return x.length > 0
    },
    checkUnique(key, e) {
      const selected = this.selected.filter(s => s.id == e.id)
    },
    saveOptions() {
      const errors = this.$v.selected.$each.$invalid
      console.log(this.$v.selected.$each)
      if(errors) {
        this.showErrors = true
      } else {
        this.showErrors = false
        this.$store.dispatch('newVariantData', this.formatSelections())
        this.$emit('generate-variants', this.formatSelections())
        this.close()
      }
      
    },
    formatSelections() {
      const a = this.selected.filter(i => {
        i.finalValues = i.values.filter(b => i.selectedValues.includes(b.id))
        return i
      })
      return a
    },
    getLastError(key, value) {
      const index = this.selectedGroupIds.indexOf(value)
      return index < key
    },
    fetchOptionGroups() {
      axios.get('/api/products/option-groups')
      .then(res => {
        let groups = []
        const x = res.data.data
        x.forEach(i => {
          i.selectedValues = []
          groups.push(i)
        })
        this.optionGroups = groups
        // this.optionGroups = res.data.data
        // this.selected.push(res.data.data[0])
        this.selected.push({id: '', values: [], selectedValues: []})
        console.log(res.data.data)
      })
    },
    fetchOptionValues() {
      axios.get('/api/products/option-values')
      .then(res => {
        this.optionValues = res.data.data
      })
    },
    close(e) {
      this.$emit('close')
    },
    submitVariants(e) {
      this.validate = true
    },
    addOptionGroup() {
      if(this.canAddGroup) {
        this.selected.push({id: '', values: [], selectedValues: []})
      }
    },
    removeGroup(key) {
      this.$delete(this.selected, key)
    },
  },
  computed: {
    canAddGroup() {
      return this.selected.length < 6 ? true : false
    },
    canDeleteGroup() {
      return this.selected.length > 1
    },
    selectedGroupNames() {
      return this.selected.map(data => {
        return data.display_name
      }).filter(g => g != null)
    },
    selectedGroupIds() {
      return this.selected.map(data => {
        return data.id
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
    },
    newVariants() {
      return this.$store.getters.newVariants
    },
    newProduct() {
      return this.$store.getters.newProduct
    },

  }
}
</script>