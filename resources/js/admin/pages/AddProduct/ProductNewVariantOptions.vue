<template>
  <div>
  <card title="Variant Options">
    <div class="variants-container">
      <div v-if="!showVariantTable" class="text-center pt-3 pb-3">
        <small class="d-block mb-3">No Option has been added yet.</small>
        <base-button @click="openPanel" class="d-block m-auto" type="primary" size="lg" icon="fas fa-plus">Add Variant Option</base-button>
      </div>
      <product-variants-table @open-panel="openEditPanel" v-if="showVariantTable" :variant-data="variantData"></product-variants-table>
    </div>
  </card>
   <add-product-options-panel :type="panelOpenType" @close="panelOpen = false" @generate-variants="generateVariants" :show="panelOpen"></add-product-options-panel>
  </div>
</template>

<script>
import ProductVariantsTable from './ProductVariantsTable'
import ProductAddOptions from './ProductAddOptions'
import AddProductOptionsPanel from './AddProductOptionsPanel'
import Combinatorics from 'js-combinatorics'
export default {
  name: 'product-new-variant-options',
  components: { ProductVariantsTable, ProductAddOptions, AddProductOptionsPanel },
  props: {
    productVariants: Array
  },
  data() {
    return {
      panelOpen: false,
      variantData: [],
      showVariantTable: false,
      panelOpenType: null,
      variantOptions: [],
      ttt: 'test'
    }
  },
  methods: {
    openPanel() {
      this.panelOpen = true
      // this.$emit('modal', 'product-options-modal')
    },
    openEditPanel() {
      this.panelOpenType = 'edit'
      this.panelOpen = true
    },
    generateSkus(e) {
      this.panelOpen = false
      this.showVariantTable = true
      this.createVariants(e)
      console.log(e)
    },
    updateData(e) {
      console.log(e)
    },
    createVariants(variants) {
      let data = []
      variants.forEach(v => {
        const item = {
          purchasable: true,
          image: '',
          variant: v,
          sku: this.skuBuilder(v),
          default_price: '',
          sale_price: '',
          msrp: '',
          weight: ''
        }
        data.push(item)
      })
      this.variantData = data
    },
    singleVariantGroup(dataVariants) {
      // const variants = dataVariants.map(a => a.finalValues.map(b => b.label))[0].join('-')
      // const variants = dataVariants.map(a => a.finalValues.map(b => b.label))[0]
      const newData = dataVariants.map(a => a.finalValues.map(b => {
        const item = {
          values: dataVariants.map(a => a.finalValues)[0],
          sku: this.skuBuilder(b.label.replace(/\s+/g, "-")),
          purchasable: true,
          variant: b.label,
          image: '',
          default_price: '',
          sale_price: '',
          msrp: '',
          weight: ''
        }
        return item
      }))[0]
      this.showVariantTable = true
      this.variantData = newData
    },
    generateVariants(dataVariants) {
      if(dataVariants.length == 1) {
        this.singleVariantGroup(dataVariants)
      } else {
      const values = dataVariants.map(a => {
        return a.finalValues.filter(i => {
          i.group_id = a.id;
          return i;
        })
        return a
      });
      const result = values.reduce((a, b) => a.reduce((r, v) => r.concat(b.map(w => [].concat(v, w))), []))
      // const newData = result.map(r => r.map(s => s.label.replace(/\s+/g, "-")).join('-'))
      const newData = result.map(r => {
        let w = r
        const item = {
          values: w.map(s => s),
          sku: w.map(s => s.label.replace(/\s+/g, "-")).join('-'),
          purchasable: true,
          variant: w.map(s => s.label).join(','),
          image: '',
          default_price: '',
          sale_price: '',
          msrp: '',
          weight: ''
        }
        return item
      })
      this.showVariantTable = true
      this.variantData = newData
      }

    },
    myTest(dataVariants) {
      const values = dataVariants.map(a => {
        return a.finalValues.filter(i => {
          i.group_id = a.id;
          return i;
        })
        
      });
      const combine = ([head, ...[headTail, ...tailTail]]) => {
        if (!headTail) return head;

        const combined = headTail.reduce((acc, x) => {
          return acc.concat(head.map(h => `${h}-${x}`))
        }, []);
        return combined
        // return combine([combined, ...tailTail]);
      };

      console.log(combine)
      // console.log(combine(values))
      // return combine(values);
    },
    skuBuilder(variant) {
      const sku = this.newProduct.sku
      return sku ? `${sku}-${variant}` : ''
    }
  },
  computed: {
    newVariants() {
      return this.$store.getters.newVariants
    },
    newProduct() {
      return this.$store.getters.newProduct
    },
  }
}
</script>

<style>

</style>