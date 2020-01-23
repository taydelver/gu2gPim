// function page (path) {
//   return () => import(/* webpackChunkName: '' */ `~/pages/${path}`).then(m => m.default || m)
// }

import ProductOptions from  './admin/pages/ProductOptions'
import PageAddProduct from './admin/pages/PageAddProduct'
import PageDashboard from './pages/PageDashboard'
import PageLogin from './admin/pages/PageLogin'
import Admin from './admin/Admin'

export default [
  {path: '/manage/login', component: PageLogin},
  {path: '/manage/dashboard', component: Admin, 
    children: [
      { path: '', component: PageDashboard },
      { path: '/manage/products', component: PageAddProduct },
      { path: '/manage/options', component: ProductOptions },
    ]
  }
]