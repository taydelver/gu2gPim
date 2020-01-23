const CustomValidator = (fields) => {
  const empty = fields.filter(f => {
    return f.length < 1
  })
  return empty
}

export default CustomValidator