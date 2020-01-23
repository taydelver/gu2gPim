<template>
  <slide-panel :open="open" @close="close" title="Add Attributes">
    <form @submit.prevent="storeAttributes">
      <draggable v-model="selected" ghost-class="ghost" chosen-class="drag-selected">
        <transition-group type="transition" name="flip-list">
          <draggable-item :can-delete="canDelete" @remove="removeGroup(key, item.id)" v-for="(item, key) in selected" :key="key">
            <form-group class="w-100 mb-0" label="Attribute">
              <el-select
                v-model="selected[key]"
                filterable
                default-first-option
                placeholder="Select attribute name"
                value-key="id"
                :value="item.name"
                @change="changeGroup"
                class="mb-1"
              >
                <el-option
                  v-for="group in attributeGroups"
                  :key="group.id"
                  :label="group.name"
                  :value="group"
                  :disabled="checkOption(group.id)"
              
                ></el-option>
              </el-select>
              <el-select
                v-model="selected[key].value"
                allow-create
                filterable
                default-first-option
                placeholder="Select values"
                value-key="id"
              >
                <el-option
                  v-for="option in item.options"
                  :key="option.id"
                  :label="option.value"
                  :value="option.value"
              
                ></el-option>
              </el-select>
            </form-group>
          </draggable-item>
        </transition-group>
      </draggable>

      <base-action-link v-show="showAdd && canAdd" @click="addItem" icon="fas fa-plus">Add Attribute</base-action-link>
      <div class="panel-footer" slot="footer">
        <submit-button size="lg">{{submitBtn.text}}</submit-button>
      </div>
    </form>
  </slide-panel>
</template>

<script>
import { Select, Option } from "element-ui";
import draggable from "vuedraggable";
import { required } from "vuelidate/lib/validators";
export default {
  components: {
    [Select.name]: Select,
    [Option.name]: Option,
    draggable
  },
  props: {
    open: Boolean,
    groups: Array
  },
  validations: {
    
  },
  data() {
    return {
      selected: [{}],
      submitStatus: null,
      submitBtn: {
        icon: "fas fa-sync-alt",
        text: "Add Attributes"
      },
      attributeGroups: [],
      showAdd: true,
      showErrors: false,
      alert: {
        show: true,
        text: "Fitments added successfully!",
        type: "success",
        autoClose: true
      }
    };
  },
  created() {
    this.fetchAttributes();
  },
  methods: {
    storeAttributes() {
      let rendered = []
      this.selected.forEach(item => {
        const x = {
          name: item.name,
          value: item.value
        }
        rendered.push(x)
      })
      this.$store.dispatch('storeAttributes', rendered)
      this.close()
      this.$emit('send-attributes', rendered)
      setTimeout(() => {
        this.$emit('show-alert', this.alert)
      }, 300)
    },
    close() {
      this.$emit("close");
    },
    checkOption(id) {
      const x = this.selected.filter(item => item.id == id)
      return x.length > 0
    },
    isRequired(key, field) {
      if(field == 'models') {
        const x = this.selected.filter((item, index) => index == key)
        return x.models.length > 0
      } else if(field == 'name') {
        return this.selected[key].name !== ''
      }
    },
    getModels(id) {
      const x = this.selected.filter(i => i.group == id)
      return x.models
    },
    changeGroup(e) {
      if(e.name !== '' || e.name !== null) {
        this.showAdd = true
      } else {
        this.showAdd = false
      }
    },
    isUnique() {
      return index.length < 2 
    
    },
    removeGroup(key) {
      this.$delete(this.selected, key)
    },
    addItem() {
        this.selected.push({})
        this.showAdd = false
    },
    fetchAttributes() {
      axios
        .get("/api/attribute-groups")
        .then(res => {
          console.log(res);
          this.attributeGroups = res.data.data
        });
    },
  },
  computed: {
    renderModels() {
      return this.selected.map(item => item.models)
    },
    canDelete() {
      return this.selected.length > 1
    },
    canAdd() {
      return this.attributeGroups.length > 0
    }
    
  }
};
</script>
<style lang="scss">
.multiple .el-input {
	.el-input__inner {
		&::placeholder {
			opacity: 0.9;
			color: #8898aa;
		}
	}
}
</style>