<template>
  <div class="table-search">
    <el-input placeholder="Please input" v-model="searchBy" class="input-with-select">
    <el-select v-model="value" slot="prepend" placeholder="Select">
      <el-option label="Restaurant" value="1"></el-option>
    </el-select>
    <el-button slot="append" icon="el-icon-search"></el-button>
  </el-input>
  </div>
</template>

<script>
export default {
  props: {
    options: Array,
    value: String,
    searchBy: String
  },
  watch: {
    
  }
}
</script>

<style>
  .table-search {
    width: 100%;
    max-width: 430px;
    margin-left: auto;
  }
</style>