<template>
  <div class="tags-input__wrapper">
    <el-tag
      v-for="(tag, index) in dynamicTags"
      :key="tag + index"
      size="small"
      :type="tagType"
      :closable="true"
      :close-transition="false"
      @close="handleClose(tag)"
    >
      {{ tag }}
    </el-tag>

    <input
      class="form-control"
      v-model="inputValue"
      ref="saveTagInput"
      size="mini"
      v-bind="$attrs"
      @input="onInput"
      @keyup.enter="handleInputConfirm"
      @blur="onBlur"
    />
  </div>
</template>

<script>
import { Tag } from 'element-ui';

export default {
  name: 'tags-input',
  inheritAttrs: false,
  components: {
    [Tag.name]: Tag
  },
  props: {
    value: {
      type: Array,
      default: () => [],
      description: 'List of tags'
    },
    tagType: {
      type: String,
      default: 'primary',
      description: 'Tag type (primary|danger etc)'
    }
  },
  model: {
    prop: 'value',
    event: 'change'
  },
  data() {
    return {
      dynamicTags: [],
      inputVisible: false,
      inputValue: ''
    };
  },
  methods: {
    handleClose(tag) {
      this.dynamicTags.splice(this.dynamicTags.indexOf(tag), 1);
      this.$emit('change', this.dynamicTags);
    },
    showInput() {
      this.inputVisible = true;
      this.$nextTick(() => {
        this.$refs.saveTagInput.$refs.input.focus();
      });
    },

    handleInputConfirm() {
      let inputValue = this.inputValue;
      if (inputValue) {
        this.dynamicTags.push(inputValue);
        this.$emit('change', this.dynamicTags);
      }
      this.inputVisible = false;
      this.inputValue = '';
    },
    onBlur(e) {
      this.$emit('blur', e)
    },
    onInput(evt) {
      this.$emit('input', evt.target.value);
    }
  },
  created() {
    this.$watch(
      'value',
      newVal => {
        this.dynamicTags = [...newVal];
      },
      { immediate: true }
    );
  }
};
</script>

<style lang="scss">
.tags-input__wrapper {
  .el-tag {
    margin-bottom: 0.6rem;
  }
}
  .el-tag--primary {
    background: #9799a2;
    height: 25px;
    margin: 0.125rem;
    border-radius: 0.25rem;
    background: #9799a2;
    color: #fff;
    line-height: 25px;
    cursor: pointer;
    box-shadow: 0 1px 2px rgba(68, 68, 68, 0.25);
    transition: all 0.15s ease;
    box-sizing: border-box;
    white-space: nowrap;
    font-size: 12px;
  }
  .el-tag__close.el-icon-close {
    color: #fff;
    background: #424752;
    &:hover {
      background:#909399;
    }
  }
</style>
