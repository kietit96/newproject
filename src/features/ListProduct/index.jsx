import React, {useEffect} from "react"
import PropTypes from "prop-types"
import {useState} from "react"
import apiItem from "../../api/apiProduct"
import ProductList from "./Product"

FeatureProduct.propTypes = {}

function FeatureProduct(props) {
  const [listProduct, setListProduct] = useState([])
  useEffect(() => {
    try {
      const getListProduct = async () => {
        const listApi = await apiItem.getList()
        if (listApi.error === 0) {
          setListProduct(listApi.result)
        } else {
          setListProduct([])
        }
      }
      getListProduct()
    } catch (error) {
      console.log(error)
    }
  }, [])
  return <ProductList listProduct={listProduct} />
}

export default FeatureProduct
