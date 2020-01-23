/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import globalDirectives from './admin/plugins/globalDirectives';
import { ValidationProvider, ValidationObserver } from 'vee-validate'
import ElementUI from 'element-ui'
import lang from 'element-ui/lib/locale/lang/en'
import locale from 'element-ui/lib/locale'
import store from './store'
import CKEditor from '@ckeditor/ckeditor5-vue'
import Vuelidate from 'vuelidate'

import Buefy from 'buefy'


locale.use(lang);
Vue.use(globalDirectives);
Vue.use(CKEditor);
Vue.use(Vuelidate)
Vue.use(ElementUI);
Vue.use(Buefy);


// import Guards from './admin/plugins/guards'
// import VueRouter from 'vue-router';
// import routes from './routes';
// Vue.use(VueRouter);
// const router = new VueRouter({
//     routes,
//     mode: 'history'
//   })
// Guards.auth(router)
// import Master from './admin/Master'

Vue.component('ValidationProvider', ValidationProvider);
Vue.component('ValidationObserver', ValidationObserver);


// GLOBAL COMPONENTS
Vue.component('notification', require('./admin/components/Notification.vue').default);
Vue.component('submit-button', require('./admin/components/SubmitButton.vue').default);
Vue.component('sync-data', require('./admin/SyncData.vue').default);
Vue.component('base-button', require('./admin/components/BaseButton.vue').default);
Vue.component('base-dropdown', require('./admin/components/BaseDropdown.vue').default);
Vue.component('base-table', require('./admin/components/BaseTable.vue').default);
Vue.component('base-pagination', require('./admin/components/BasePagination.vue').default);
Vue.component('sidebar-item', require('./admin/components/sidebar/SidebarItem.vue').default);
Vue.component('form-card', require('./admin/components/forms/FormCard.vue').default);
Vue.component('form-group', require('./admin/components/forms/FormGroup.vue').default);
Vue.component('card', require('./admin/components/Card.vue').default);
Vue.component('slide-panel', require('./admin/components/SlidePanel.vue').default);
Vue.component('page', require('./admin/components/Page.vue').default);
Vue.component('modal', require('./admin/components/Modal.vue').default);
Vue.component('number-input', require('./admin/components/forms/NumberInput.vue').default);
Vue.component('base-action-link', require('./admin/components/BaseActionLink.vue').default);
Vue.component('base-icon', require('./admin/components/BaseIcon.vue').default);
Vue.component('file-input', require('./admin/components/forms/FileInput.vue').default);
Vue.component('image-input', require('./admin/components/forms/ImageInput.vue').default);
Vue.component('draggable-item', require('./admin/components/DraggableItem.vue').default);
Vue.component('tags-input', require('./admin/components/TagsInput.vue').default);
Vue.component('loader', require('./admin/components/Loader.vue').default);
Vue.component('page-footer', require('./admin/components/PageFooter.vue').default);
Vue.component('text-editor', require('./admin/components/TextEditor.vue').default);
Vue.component('table-search', require('./admin/components/TableSearch.vue').default);
Vue.component('tab-container', require('./admin/components/TabContainer.vue').default);
Vue.component('tab-item', require('./admin/components/TabItem.vue').default);
Vue.component('tab-list', require('./admin/components/TabList.vue').default);

//LAYOUTS
// Vue.component('products-table', require('./admin/layouts/ProductsTable.vue').default);
// Vue.component('product-options-table', require('./admin/layouts/ProductOptionsTable.vue').default);
// Vue.component('option-group-add', require('./admin/layouts/OptionGroupAdd.vue').default);
// Vue.component('category-tree-select', require('./admin/layouts/products/CategoryTreeSelect.vue').default);

// PAGES
Vue.component('page-product-options', require('./admin/pages/PageProductOptions.vue').default);
Vue.component('page-add-product', require('./admin/pages/PageAddProduct.vue').default);
Vue.component('page-fitments', require('./admin/pages/PageFitments.vue').default);
Vue.component('page-products', require('./admin/pages/PageProducts.vue').default);
Vue.component('page-attributes', require('./admin/pages/PageAttributes.vue').default);

// const app =new Vue({
//     el: '#adminLayout',
//     router: router,
//     store,
//     components: { Master }
// });

const app = new Vue({
    el: '#admin',
    store
});