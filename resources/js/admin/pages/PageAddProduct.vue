<template>
  <page :loading="loading" class="fixed-footer" title="Create Product" :alert="alert">
    <tab-list :active="currentTab" @current-tab="handleTabs" :tab-items="tabs"></tab-list>
    <div class="row">
      <div class="col-md-8">
        <tab-container :show="currentTab == 'basic-info'">
          <product-new-basic></product-new-basic>
        </tab-container>
        <tab-container :show="currentTab == 'variants'">
          <product-new-variant-options @modal="optionsPanel"></product-new-variant-options>
        </tab-container>
        <tab-container :show="currentTab == 'media'">
          <product-new-media @get-media="getMedia"></product-new-media>
        </tab-container>

        <tab-container :show="currentTab == 'attributes'">
          <product-new-custom-fields></product-new-custom-fields>
        </tab-container>

        <card title="Description">
          <text-editor></text-editor>
        </card>
        
      </div>
      <div class="col-md-4">
        <category-tree-select></category-tree-select>
        <product-new-fitments @alert="handleAlert"></product-new-fitments>
      </div>
    </div>
    {{optionList}}
    <template #footer>
      <page-footer class="p-fixed p-bottom p-right"><base-button @click="saveProduct" size="lg" type="primary">Save Product</base-button></page-footer>
    </template>
  </page>
</template>

<script>
import ProductNewBasic from "./AddProduct/ProductNewBasic";
import ProductNewVariantOptions from "./AddProduct/ProductNewVariantOptions";
import CategoryTreeSelect from "./AddProduct/CategoryTreeSelect";
import ProductNewFitments from "./AddProduct/ProductNewFitments";
import ProductNewMedia from './AddProduct/ProductNewMedia'
import ProductNewCustomFields from './AddProduct/ProductNewCustomFields'
export default {
  components: {
    ProductNewBasic, ProductNewVariantOptions, CategoryTreeSelect, ProductNewFitments,
    ProductNewMedia, ProductNewCustomFields
  },
  data() {
    return {
      optionsPanelOpen: false,
      basicFields: {},
      productId: null,
      sendVariants: false,
      optionList: [],
      alert: {},
      productSaved: false,
      loading: true,
      productData: null,
      currentTab: 'basic-info',
      tabs: [
        {label: 'Basic Info', toOpen: 'basic-info'},
        {label: 'Variants', toOpen: 'variants'},
        {label: 'Images/Video', toOpen: 'media'},
        {label: 'Attributes', toOpen: 'attributes'}
      ]

    };
  },
  watch: {
    variants() {
      if (this.variants.length > 0) {
      
      }
    },
    productSaved() {
      if(this.productSaved == true) {
        this.fetchProduct()
      }
    }
  },
  mounted() {
    setTimeout(() => {
      this.loading = false
    }, 400)
  },
  methods: {
    
    handleTabs(e) {
      console.log(e)
      this.currentTab = e
    },
    fetchProduct() {
      axios.get(`/api/product/${this.productId}`)
      .then(res => {
        console.log(res.data.data)
        this.productData = res.data.data
        this.loading = false
        this.$store.dispatch('savedProductData', res.data.data)
      })
    },
    optionsPanel(e) {
      this.optionsPanelOpen = true;
    },
    handleAlert(alert) {
      this.alert = alert
    },
    getBasicFields(e) {
      this.basicFields = e;
    },
    getMedia(e) {
      console.log(e)
    },
    saveProduct() {
      this.loading = true
      this.$store.dispatch("createProduct", this.newProduct).then(res => {
        console.log(res)
        const productId = res.data.data.id;
        this.productId = res.data.data.id;
        this.saveOptions(productId);
      });
    },
    saveImages(productId) {
      if(this.newProductImages.length) {

      }
    },
    saveVariants() {
      let promises = [];
      let output = [];
      this.variants.forEach(item => {
        promises.push(
          axios.post("/api/create/product/variants", {
            product_id: this.productId,
            variant: item
          })
        );
      });
      if(this.fitments) {
        this.fitments.forEach(fitment => {
          promises.push(axios.post('/api/create/product/custom-fields', {
            product_id: this.productId,
            field: fitment
          }))
        })
      }
      if(this.newProductImages) {
        this.newProductImages.forEach(image => {
          promises.push(axios.post('/api/create/product/images', {
            product_id: this.productId,
            image: {
              description: image.alt_text,
              image_url: `http://bcpim.test${image.image}`
            }
          }))
        })
      }
      axios.all(promises).then(res => {
        res.forEach(r => {
          output.push(r);
        });
      });
      this.productSaved = true
    },
    saveOptions(productId) {
      let promises = [];
      let output = [];
      this.options.forEach(item => {
        let finalValues = [];
        item.finalValues.forEach(val => {
          const newValue = {
            label: val.label,
            sort_order: val.sort_order,
            is_default: false
          };
          const newValueColor = {
            label: val.label,
            sort_order: val.sort_order,
            is_default: false,
            value_data: {
              colors: JSON.parse(val.value_data)
            }
          };
          if (item.type == "swatch") {
            finalValues.push(newValueColor);
          } else {
            finalValues.push(newValue);
          }
        });
        const data = {
          name: item.name,
          display_name: item.display_name,
          sort_order: item.sort_order,
          type: item.type,
          option_values: finalValues
        };
        promises.push(
          axios.post("/api/create/product/options", {
            product_id: productId,
            option: data
          })
        );
      });
      axios.all(promises).then(res => {
        res.forEach(r => {
          output.push(r.data.data);
        });
        this.saveVariants()
      });
      this.optionList = output;
      this.sendVariants = true;
      console.log(output)
    }
  },
  computed: {
    newProduct() {
      return this.$store.getters.newProduct;
    },
    newProductImages() {
      return this.$store.getters.newProductImages;
    },
    options() {
      return this.$store.getters.newVariants;
    },
    fitments() {
      return this.$store.getters.newFitments;
    },
    variants() {
      const values = this.optionList.map(a => {
        return a.option_values.filter(i => {
          i.group_id = a.id;
          return i;
        });
      });

      this.valueErrors = false;
      const combine = ([head, ...[headTail, ...tailTail]]) => {
        if (!headTail) return head;

        const combined = headTail.reduce((acc, x) => {
          let a = acc;
          head.forEach(i => {
            const d = {
              sku: `${this.newProduct.sku.replace(
                /\s+/g,
                "-"
              )}-${i.label.replace(/\s+/g, "-")}-${x.label.replace(
                /\s+/g,
                "-"
              )}`,
              product_id: this.productId,
              option_values: [
                { id: x.id, option_id: x.group_id },
                { id: i.id, option_id: i.group_id }
              ]
            };
            a.push(d);
          });
          return a;
        }, []);
        return combine([combined, ...tailTail]);
      };
      return combine(values);
    }
  }
};
</script>

<style>
.page.fixed-footer {
  padding-bottom: 110px;
}
</style>