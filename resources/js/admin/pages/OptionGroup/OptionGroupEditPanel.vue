<template>
  <slide-panel :open="open" @close="close" title="Update Option Group">
    <form @submit.prevent="update">
      <form-group label="Name">
        <input v-model="selected.name" type="text" class="form-control" />
        <div
          class="error text-danger"
          v-if="!$v.selected.name.required && submitStatus == 'ERROR'"
        >Name is required!</div>
        <div
          class="error text-danger"
          v-if="!$v.selected.name.isUnique && submitStatus !== 'ERROR'"
        >This name already exists</div>
        <div
          class="error text-danger"
          v-if="!$v.selected.name.isUnique && submitStatus == 'ERROR'"
        >This name already exists</div>
      </form-group>
      <form-group label="Display name">
        <input v-model="selected.displayName" type="text" class="form-control" />
        <div
          class="error text-danger"
          v-if="!$v.selected.displayName.required && submitStatus == 'ERROR'"
        >Display name is required!</div>
      </form-group>
      <form-group label="Type">
        <el-select v-model="selected.groupType" filterable placeholder="Type">
          <el-option
            v-for="option in optionTypes"
            :key="option.label"
            :label="option.label"
            :value="option.value"
          ></el-option>
        </el-select>
      </form-group>
      <form-group v-if="!showList" label="Values">
        <el-select
          @visible-change="onValuesBlur"
          @change="onValuesChange"
          class="multiple"
          v-model="selected.optionValues"
          multiple
          filterable
          allow-create
          default-first-option
          placeholder="Select values"
        >
          <el-option
            v-for="option in optionValues"
            :key="option.id"
            :label="option.label"
            :value="option.label"
          ></el-option>
          <el-option v-for="item in newList" :key="item" :label="item" :value="item"></el-option>
        </el-select>
      </form-group>

      <form-group v-if="showList" label="Selected Values">
        <draggable v-model="selected.optionValues" ghost-class="ghost">
          <transition-group type="transition" name="flip-list">
            <draggable-item
              @remove="removeItem(key)"
              v-for="(item, key) in selected.optionValues"
              :key="item"
            >
              <input
                @dblclick="onDblClick"
                readonly
                type="text"
                v-model="selected.optionValues[key]"
                class="form-control disabled"
              />
            </draggable-item>
          </transition-group>
        </draggable>
      </form-group>

      <div class="button-row">
        <base-button
          v-if="showList"
          @click="showList = false"
          class="primary mt-3 d-block w-100"
          type="bare"
          size="tiny"
          icon="fas fa-edit"
        >Edit List</base-button>
      </div>
      {{groups}}
      <div class="panel-footer" slot="footer">
        <submit-button size="lg">{{submitBtn.text}}</submit-button>
      </div>
    </form>
  </slide-panel>
</template>

<script>
import optionTypes from "../../../option-types";
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
    groups: Array,
    group: Object
  },
  validations: {
    selected: {
      name: {
        required,
        isUnique(value) {
          return !this.groups.includes(value) || value == this.group.name 
        }
      },
      displayName: {
        required
      },
      groupType: {
        required
      }
    }
  },
  data() {
    return {
      optionTypes,
      optionValues: [],
      selected: {
        optionValues: [],
        groupType: "radio_buttons",
        displayName: "",
        name: ''
      },
      showList: false,
      newList: [],
      commpiled: [],
      submitStatus: null,
      submitBtn: {
        icon: "fas fa-sync-alt",
        text: "Update Group"
      },
      currentGroup: {}
    };
  },
  watch: {
    open() {
      console.log(this.open);
      if (this.open == true) {
        this.fetchOptionValues();
        this.currentGroup = this.group;
        const values = this.group.values.map(v => v.label);
        this.selected.optionValues = values;
        this.selected.displayName = this.group.display_name;
        this.selected.name = this.group.name;
        this.selected.groupType = this.group.type;
      }
    }
  },
  created() {
    this.fetchOptionValues();
  },
  methods: {
    close() {
      this.$emit("close");
    },
    removeItem(key) {
      this.selected.optionValues.splice(key, 1);
    },
    onDblClick(e) {
      e.type == "dblclick" ? (this.showList = false) : (this.showList = true);
    },
    onValuesBlur(e) {
      if (this.selected.optionValues.length) {
        this.showList = !e;
      }
    },
    onValuesChange(e) {
      const options = this.optionValues.map(i => i.label);
      const items = this.selected.optionValues.filter(i => {
        return !options.includes(i);
      });
      this.newList = items;
    },
    async update() {
      this.$v.$touch();
      if (this.$v.$invalid) {
        this.submitStatus = "ERROR";
      } else {
        await this.updateGroup();
        // this.submitStatus = "PENDING";
        await setTimeout(() => {
          this.selected.optionValues = [];
          this.selected.groupType = "";
          this.selected.displayName = "";
          this.selected.name = "";
          this.showList = false;
          this.newList = [];
          this.submitStatus = "OK";
          this.close(true);
          this.$emit("show-alert", {
            show: true,
            text: "Group updated successfully!",
            type: "success"
          });
        }, 400);
      }
    },
    updateGroup() {
      axios
        .post("/api/products/option-group/update", {
          group_id: this.group.id,
          display_name: this.selected.displayName,
          name: this.selected.name,
          type: this.selected.groupType,
          values: this.format
        })
        .then(res => {
          console.log(res);
        });
    },

    fetchOptionValues() {
      axios.get("/api/products/option-values").then(res => {
        console.log(res);
        this.optionValues = res.data.data;
      });
    }
  },
  computed: {
    formatValues() {
      return this.optionValues.filter((item, index) => {
        const related = this.selected.optionValues.indexOf(item.label);
        item.sort_order = related;
        return this.selected.optionValues.includes(item.label);
      });
    },
    format() {
      let output = [];
      this.selected.optionValues.forEach((item, key) => {
        const x = {
          sort_order: key,
          label: item
        };
        output.push(x);
      });
      return output;
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