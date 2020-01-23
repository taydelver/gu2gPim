const VariantGenerator = (options) => {
  if (options.length == 1) {
    const variants = dataVariants.map(a => a.finalValues.map(b => b.label))[0].join('-')
    console.log(variants)
    let newData = []
    const item = {
      values: dataVariants.finalValues,
      sku: '',
      purchasable: true,
      variant: '',
      image: '',
      default_price: '',
      sale_price: '',
      msrp: '',
      weight: ''
    }
    newData.push(item)
    // this.showVariantTable = true
    // this.variantData = newData
  }
}