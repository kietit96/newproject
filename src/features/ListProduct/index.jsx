<<<<<<< HEAD
import React, {useEffect} from "react"
import PropTypes from "prop-types"
import {useState} from "react"
import apiItem from "../../api/apiProduct"
import ProductList from "./Product"

FeatureProduct.propTypes = {}

function FeatureProduct(props) {
=======
import React, { useEffect } from "react"
import PropTypes from "prop-types"
import { useState } from "react"
import apiItem from "../../api/apiProduct"
import ProductList from "./Product"

ProductFeature.propTypes = {}

function ProductFeature(props) {
>>>>>>> origin/master
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

<<<<<<< HEAD
export default FeatureProduct
=======
export default ProductFeature
>>>>>>> origin/master
