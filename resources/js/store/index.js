import Vuex from 'vuex'
import Vue from 'vue'
import axios from 'axios'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    token: localStorage.getItem('access_token') || null,
    test: 'This is from vuex',
    newProduct: {
      product_type: 'physical',
      sku: 'PRODUCT',
      name: 'My Product',
      price: '20.00',
      weight: '0.9',
      categories: [],
    },
    newVariants: [],
    newFitments: [],
    newAttributes: [],
    newProductImages: [],
  },
  getters: {
    test: (state) => state.test,
    newProduct: (state) => state.newProduct,
    loggedIn: (state) => state.token != null,
    newVariants: (state) => state.newVariants,
    newFitments: (state) => state.newFitments,
    newAttributes: (state) => state.newAttributes,
    newProductImages: (state) => state.newProductImages
  },
  actions: {
    login: (context, credentials) => {
      return axios.post('/api/login', {
        username: credentials.username,
        password: credentials.password
      }).then(res => {
        const token = res.data.access_token
        localStorage.setItem('access_token', token)
        return res
        // context.commit('')
      })
    },
    newProductBasic: (context, fields) => {
      context.commit('setProductFields', fields)
    },
    savedProductData: (context, data) => {
      context.commit('setProductData', data)
    },
    newProductVariants: (context, variants) => {
      context.commit('setVariantFields', variants)
    },
    newProductImages: (context, images) => {
      context.commit('setProductImages', images)
    },
    newVariantData: (context, variants) => {
      context.commit('setNewVariants', variants)
    },
    newProductCategories: (context, cats) => {
      context.commit('setNewProductCategories', cats)
    },
    fetchOptionGroups: (context, page) => {
      axios.get('/api/products/option-groups', {
        params: {
          paginate: page.paginate
        }
      })
        .then(res => {
          console.log(res)
        })
    },
    createProduct: (context, product) => {
      return axios.post('/api/create/product', {
        product: product
      })
    },
    storeFitments: (context, fitments) => {
      context.commit('setNewFitments', fitments)
    },
    storeAttributes: (context, attributes) => {
      context.commit('setNewAttributes', attributes)
    },
    fetchBcCategories() {
      return axios.get('/api/bc/categories')
    }
  },
  mutations: {
    setProductFields: (state, fields) => {
      state.newProduct.type = fields.type
      state.newProduct.sku = fields.sku
      state.newProduct.name = fields.name
      state.newProduct.price = fields.price
      // state.newProudct.brand = fields.brand
      state.newProduct.weight = fields.weight
    },
    setVariantFields: (state, variants) => state.newProduct.variants = variants,
    setNewProductCategories: (state, categories) => state.newProduct.categories = categories,
    setNewVariants: (state, variants) => state.newVariants = variants,
    setNewFitments: (state, fitments) => state.newFitments = fitments,
    setNewAttributes: (state, attributes) => state.newAttributes = attributes,
    setProductData: (state, data) => state.newProduct = data,
    setProductImages: (state, images) => state.newProductImages = images
  }
})