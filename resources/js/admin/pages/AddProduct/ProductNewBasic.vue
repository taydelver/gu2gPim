<template>
      <card title="Basic Information">
      <div class="row">
        <div class="col-md-6">
          <form-group label="Product Title">
              <input @keyup="onNameChange" v-model="inputs.name" type="text" class="form-control">
              <div v-if="error.duplicateName" class="error text-danger">This name already exists!</div>
          </form-group>
    
        </div><!--COLUMN END-->
        <div class="col-md-6">
          <form-group label="SKU">
              <input v-model="inputs.sku" type="text" class="form-control">
          </form-group>
        </div><!--COLUMN END-->
      </div><!-- ROW END -->
      <div class="row">
        <div class="col-md-6">
          <form-group label="Product Type">
              <el-select v-model="inputs.type" filterable
                      placeholder="">
            <el-option v-for="option in productTypes"
                        :key="option.label"
                        :label="option.label"
                        :value="option.value">
            </el-option>
          </el-select>
          </form-group>
        </div><!--COLUMN END-->
        <div class="col-md-6">
          <form-group label="Default Price">
            <number-input :start-value="inputs.price" :data.sync="inputs.price"></number-input>
          </form-group>
        </div><!--COLUMN END-->
      </div><!-- ROW END -->
      <div class="row">
        <div class="col-md-6">
          <form-group label="Brand">
              <el-select v-model="inputs.brand" filterable
                      placeholder="">
            <el-option v-for="option in brands"
                        :key="option.label"
                        :label="option.label"
                        :value="option.value">
            </el-option>
          </el-select>
          </form-group>
        </div><!--COLUMN END-->
        <div class="col-md-6">
          <form-group label="Weight">
            <number-input :start-value="inputs.weight" :data.sync="inputs.weight"></number-input>
          </form-group>
        </div><!--COLUMN END-->
      </div><!-- ROW END -->
    </card>
</template>

<script>
import optionTypes from '../../../option-types'
import _ from 'lodash'
export default {
  data() {
    return {
      productTypes: [
        {label: 'Physical', value: 'physical'},
        {label: 'Digital', value: 'digital'}
      ],
      brands: [
        {label: 'Brand One', value: 'brand-one'},
        {label: 'Brand Two', value: 'brand-two'}
      ],
      inputs: {
        type: 'physical',
        sku: 'PRODUCT',
        name: 'My Product',
        price: '20.00',
        brand: 'brand-one',
        weight: '0.9'
      },
      error: {
        duplicateName: false
      }
    }
  },
  watch: {
    inputs: {
      handler: function(val, oldVal) {
        this.$store.dispatch('newProductBasic', val)
      },
      deep: true
    }
  },
  created() {
    this.debounced = _.debounce(this.searchName, 900)
  },
  methods: {
    searchName() {
       axios.get('/api/bc/search/name', {
         params: {
           name: this.inputs.name
         }
       }).then(res => {
         const data = res.data.data
         console.log(data)
         if(data.length > 0) {
           this.error.duplicateName = true
         } else {
           this.error.duplicateName = false
         }
       })
    },
    onNameChange() {
      this.debounced()
    }
  },
  computed: {
    newProduct() {
      return this.$store.getters.newProduct
    }
  }
}
</script>

<style>

</style>