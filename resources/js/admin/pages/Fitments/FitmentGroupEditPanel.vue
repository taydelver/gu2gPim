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


      <form-group v-if="!showList" label="Values">
        <tags-input @blur="onValuesBlur" v-model="selected.values" placeholder="Enter values"></tags-input>
      </form-group>

      <form-group v-if="showList" label="Selected Values">
        <draggable v-model="selected.values" ghost-class="ghost">
          <transition-group type="transition" name="flip-list">
            <draggable-item
              @remove="removeItem(key)"
              v-for="(item, key) in selected.values"
              :key="key"
            >
              <input
                @dblclick="onDblClick"
                readonly
                type="text"
                v-model="selected.values[key]"
                class="form-control disabled"
              />
            </draggable-item>

          </transition-group>
        </draggable>
      </form-group>

      <div class="panel-footer" slot="footer">
        <base-button @click="update" size="lg" type="primary">{{ submitBtn.text }}</base-button>
      </div>
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
        values: []
      },
      submitStatus: null,
      submitBtn: {
        icon: "fas fa-sync-alt",
        text: "Update Group"
      },
      showList: false,
      fitmentModels: [],
      groupNames: [],
      loading: false,
      currentGroup: {}
    };
  },
  watch: {
    open() {
      if (this.open == true) {
        this.currentGroup = this.group;
        this.selected.values = this.group.models.map(v => v.value);
        this.selected.name = this.group.name;
      }
    }
  },
  created() {
    this.fetchFitments();
  },
  methods: {
    close() {
      this.$emit("close");
    },
    removeItem(key) {
      this.selected.values.splice(key, 1);
    },
    onDblClick(e) {
      e.type == "dblclick" ? (this.showList = false) : (this.showList = true);
    },
    onValuesBlur(e) {
      if (this.selected.values.length) {
        this.showList = true;
      }
    },
    update() {
      this.$v.$touch();
      if (this.$v.$invalid) {
        this.submitStatus = "ERROR";
      } else {
        this.updateGroup();
      }
    },
    updateGroup() {
      axios
        .post("/api/fitment/group/update", {
          id: this.group.id,
          name: this.selected.name,
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
        });
    },
    fetchFitments() {
      axios
        .get("/api/fitments")
        .then(res => {
          this.groupNames = res.data.data.map(item => item.name);
        });
    },
  },
  computed: {
    panelTitle() {
      return `Update ${this.group.name}`
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