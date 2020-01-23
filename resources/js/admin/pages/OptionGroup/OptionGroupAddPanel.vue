<template>
  <slide-panel :open="open" @close="close" title="Create Option Group">
    <form @submit.prevent="createAll">
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
      <form-group label="Display name">
        <input v-model="selected.displayName" type="text" class="form-control" />
        <div
          class="error text-danger"
          v-if="!$v.selected.displayName.required && submitStatus == 'ERROR'"
        >Display name is required!</div>
        <div
          class="error text-danger"
          v-if="!$v.selected.displayName.isUnique && submitStatus == 'ERROR'"
        >This name already exists</div>
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


      <form-group v-if="!showList && selected.groupType !== 'swatch'" label="Values">
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
            v-for="(option, key) in optionValues"
            :key="key"
            :label="option.label"
            :value="option.label"
            value-key="id"
        
          ></el-option>
          <el-option v-for="item in newList" :key="item" :label="item" :value="item"></el-option>
        </el-select>
      </form-group>

      <form-group v-if="showList && selected.groupType !== 'swatch'" label="Selected Values">
        <draggable :list="selected.optionValues" ghost-class="ghost">
          <transition-group type="transition" name="flip-list">
            <draggable-item
              @remove="removeItem(key)"
              v-for="(item, key) in selected.optionValues"
              :key="key"
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


      <form-group v-if="selected.groupType == 'swatch'" label="Selected Colors">
        <draggable :list="selected.colorValues" ghost-class="ghost">
          <transition-group type="transition" name="flip-list">
            <draggable-item
              @remove="removeColorItem(key)"
              v-for="(item, key) in selected.colorValues"
              :key="key"
            >

              <el-color-picker color-format="hex" v-model="item.color"></el-color-picker>
              <input v-model="item.label" placeholder="Color name" type="text" class="form-control">
            </draggable-item>

          </transition-group>
        </draggable>
        <base-action-link @click="addColorItem" icon="fas fa-plus">Add Another Color</base-action-link>
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
    groups: Array
  },
  validations: {
    selected: {
      name: {
        required,
        isUnique(value) {
          return !this.groups.includes(value);
        }
      },
      displayName: {
        required
      },
      groupType: {
        required
      },
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
        name: '',
        colorValues: [{color: '#409EFF', label: ''}]
      },
      showList: false,
      newList: [],
      commpiled: [],
      submitStatus: null,
      submitBtn: {
        icon: "fas fa-sync-alt",
        text: "Create Group"
      }
    };
  },
  watch: {
    open() {
      console.log(this.open);
      if (this.open == true) {
        this.fetchOptionValues();
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
    validateColorLabel(value) {
      if(this.checkColorLabel == true) {
        if(value == null || value == '') {
          return false
        } else {
          return true
        }
      }
    },
    removeItem(key) {
      this.selected.optionValues.splice(key, 1);
    },
    addColorItem() {
      this.selected.colorValues.push({color: '#ffffff', label: ''})
    },
    removeColorItem(key) {
      if(this.selected.colorValues.length > 1) {
        this.selected.colorValues.splice(key, 1)
      }
      
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
      console.log(e)
      const options = this.optionValues.map(i => i.label);
      const items = this.selected.optionValues.filter(i => {
        return !options.includes(i);
      });
      this.newList = items;
    },
    async createAll() {
      this.$v.$touch();
      if (this.$v.$invalid) {
        this.submitStatus = "ERROR";
      } else {
        await this.createGroup();
        // this.submitStatus = "PENDING";
        await setTimeout(() => {
          this.selected.optionValues = [];
          this.selected.groupType = "";
          this.selected.displayName = "";
          this.showList = false;
          this.newList = [];
          this.submitStatus = "OK";
          this.close(true);
          this.$emit("show-alert", true);
        }, 400);
      }
    },
    createGroup() {
      axios
        .post("/api/products/option-group/create", {
          display_name: this.selected.displayName,
          type: this.selected.groupType,
          name: this.selected.name,
          values: this.selected.groupType == 'swatch' ? this.formatColors : this.format
        })
        .then(res => {
          console.log(res);
        });
    },
    createColorGroup() {
      axios
        .post("/api/products/option-group/create", {
          display_name: this.selected.displayName,
          type: this.selected.groupType,
          values: this.formatColors,
          swatch: true
        })
        .then(res => {
          console.log(res);
        });
    },
    createNewOptions() {
      axios
        .post("/api/products/option-values/create", {
          values: this.newList
        })
        .then(res => {
          res.data.forEach(value => {
            this.optionValues.push(value);
          });
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
    },
    formatColors() {
      let output = [];
      this.selected.colorValues.forEach((item, key) => {
        item.sort_order = key
        output.push(item);
      });
      return output;
    },
    isColorInputs() {
      return this.selected.groupType == 'swatch'
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