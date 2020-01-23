<template>
  <slide-panel :open="open" @close="close" :title="panelTitle">
    <loader overlay :loading="loading"></loader>

        <form-group label="Name">
          <input v-model="selected.name" type="text" class="form-control" />
          <div
            class="error text-danger"
            v-if="!$v.selected.name.required && submitStatus == 'ERROR'"
          >Display name is required!</div>
          <div
            class="error text-danger"
            v-if="!$v.selected.name.isUnique && submitStatus !== 'ERROR'"
          >This name already exists</div>
          <div
            class="error text-danger"
            v-if="!$v.selected.name.isUnique && submitStatus == 'ERROR'"
          >This name already exists</div>
        </form-group>
   
  
        <form-group label="Assign Category">
              <el-select v-model="selected.category" filterable
                      placeholder="">
            <el-option v-for="category in categories"
                        :key="category.id"
                        :label="category.name"
                        :value="category.id">
            </el-option>
          </el-select>
        </form-group>



      <form-group label="Options">
        <tags-input @blur="onValuesBlur" v-model="selected.values" placeholder="Enter options"></tags-input>
      </form-group>

      <div class="panel-footer" slot="footer">
        <base-button @click="updateGroup" size="lg" type="primary">{{ submitBtn.text }}</base-button>
      </div>
  </slide-panel>
</template>

<script>
import { Select, Option } from "element-ui";
import { required } from "vuelidate/lib/validators";
export default {
  components: {
    [Select.name]: Select,
    [Option.name]: Option,
  },
  props: {
    open: Boolean,
    group: Object
  },
  validations: {
    selected: {
      name: {
        required,
        isUnique(value) {
          return !this.groupNames.includes(value) || value == this.group.name 
        }
      }
    }
  },
  data() {
    return {
      selected: {
        name: '',
        category: '',
        values: []
      },
      submitStatus: null,
      submitBtn: {
        icon: "fas fa-sync-alt",
        text: "Update Group"
      },
      groupNames: [],
      categories: [],
      loading: false
    };
  },
  watch: {
    open() {
      if (this.open == true) {
        // this.currentGroup = this.group;
        this.selected.values = this.group.options.map(v => v.value);
        this.selected.name = this.group.name;
        this.selected.category = this.group.category;
      }
    }
  },
  created() {
    this.fetchAttributes();
    this.fetchCategories()
  },
  methods: {
    close() {
      this.$emit("close");
    },
    removeItem(key) {
      if(this.selected.values.length > 1) {
        this.selected.values.splice(key, 1);
      }
    },
    onDblClick(e) {
      e.type == "dblclick" ? (this.showList = false) : (this.showList = true);
    },
    onValuesBlur(e) {
      if(this.selected.values.length > 0) {
        this.showList = true
      }
    },
    fetchCategories() {
      this.$store.dispatch('fetchBcCategories')
      .then(res => {
        this.categories = res.data
      })
    },
    updateGroup() {
      axios
        .post("/api/attribute/group/update", {
          id: this.group.id,
          name: this.selected.name,
          category: this.selected.category ? this.selected.category : null,
          values: this.selected.values
        })
        .then(res => {
          setTimeout(() => {
            this.selected = {name: '', values: []};
            this.showList = false;
            this.close(true);
            this.$emit("show-alert", {
              show: true,
              text: "Group updated successfully!",
              type: "success"
            });
          }, 300);
          console.log(res.data)
          this.loading = false
        })
    },
    fetchAttributes() {
      axios
        .get("/api/attribute-groups")
        .then(res => {
          this.groupNames = res.data.data.map(item => item.name);
        });
    }
  },
  computed: {
    panelTitle() {
      return `Update ${this.group.name}`
    }
  }
};
</script>