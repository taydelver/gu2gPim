<template>
  <div class="product-variants-section">
    
    <div class="title-row">
      <div class="title-row__title"><h3>Variants</h3></div>
      <div class="title-row__right"><base-action-link @click="editVariants" size="lg" icon="fas fa-cog">Configure options</base-action-link></div>
    </div>
    <div class="table-responsive">
      <base-table class="table align-items-center table-flush"
                  :thead-classes="`thead-light`"
                  tbody-classes="list"
                  :data="variants">
        <template slot="columns">
          <th colspan="1">Available</th>
          <!-- <th>Image</th> -->
          <th>Variant</th>
          <th>SKU</th>
          <th>Default Price</th>
          <th>Sale Price</th>
        </template>

        <template slot-scope="{row, index}">
          <th style="width: 40px" colspan="1" scope="row">
            <span class="checkbox-wrapper mb-0 text-sm">
              <input :id="inputId('tableCheckbox', index)" :ref="inputId('tableCheckbox', index)" class="table-checkbox" type="checkbox" v-model="row.purchasable">
              <label :class="{checked: row.purchasable}" class="table-checkbox__label" :for="inputId('tableCheckbox', index)"></label>
            </span>
          </th>
          <!-- <td><image-input :thumbnail="thumbnails[index]" @remove="handleRemove(inputId('variantImageUpload', index))" :ref="inputId('variantImageUpload', index)" :input-id="inputId('variantImageUpload', index)" @change="filesChange($event, index)"></image-input></td> -->
          <td>{{ row.variant }}</td>
          <td><input v-model="row.sku" type="text" class="form-control"></td>
          <td><number-input :start-value="newProduct.price" :data.sync="row.regular_price"></number-input></td>
          <td>{{ row.sale_price }}</td>
        </template>
      </base-table>
    </div>
    
  </div>
</template>
<script>
  export default {
    name: 'product-variants-table',
    props: {
      refresh: Boolean,
      variantData: Array,
    },
    data() {
      return {
        paginate: 3,
        tableData: this.variantData,
        files: [],
        imageForm: new FormData,
        thumbnails: []
      }
    },
    watch: {
      // variantData() {
      //   this.tableData = this.variantData
      // },
    },
    created() {
      
    },
    
    methods: {
      checked(e) {
      
    },
    editVariants() {
      this.$emit('open-panel')
    },
    filesChange(files, index) {
      
      this.imageForm.append('image', files[0])
      
      const config = { headers: { 'Content-Type': 'multipart/form-data' } };
      axios.post('/api/products/images/save', this.imageForm, config)
      .then(res => {
        this.thumbnails.splice(index, 1, res.data)
        console.log(this.thumbnails)
      })
      .catch(err => console.log(err))
    },
    inputId(prefix, key) {
      return `${prefix}${key}`
    },
    handleRemove(input) {
      console.log(this.$refs[input])
      console.log(input)
    },
    isChecked(val) {
      console.log(this.$refs.tableCheckbox0)
      // if(this.$refs.val.checked == true) {
      //   return 'checked'
      // }
    }
  },
  computed: {
    newProduct() {
      return this.$store.getters.newProduct
    },
    variants() {
      return this.variantData
    }
  }
}
</script>
<style>
</style>