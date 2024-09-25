import PropTypes from "prop-types"

ProductList.propTypes = {
  listProduct: PropTypes.array,
}

function ProductList(props) {
  const {listProduct} = props
  return (
    <div>
      {listProduct.map((list) => (
        <div key={list.id}>{list.title}</div>
      ))}
    </div>
  )
}

export default ProductList
