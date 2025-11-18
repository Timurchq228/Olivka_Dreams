import React from 'react';
import ProductCard from './ProductCard';
import { products } from '../data/products';

const ProductList = ({ limit, filters = {} }) => {
  let displayedProducts = [...products];
  
  // Применяем фильтры если они есть
  if (filters.brand && filters.brand !== 'all') {
    displayedProducts = displayedProducts.filter(product => 
      product.brand === filters.brand
    );
  }
  
  if (filters.minPrice) {
    displayedProducts = displayedProducts.filter(product => 
      product.price >= filters.minPrice
    );
  }
  
  if (filters.maxPrice) {
    displayedProducts = displayedProducts.filter(product => 
      product.price <= filters.maxPrice
    );
  }
  
  if (filters.category && filters.category !== 'all') {
    displayedProducts = displayedProducts.filter(product => 
      product.category === filters.category
    );
  }
  
  // Ограничиваем количество если нужно
  if (limit) {
    displayedProducts = displayedProducts.slice(0, limit);
  }

  return (
    <div className="product-list">
      {displayedProducts.length > 0 ? (
        <div className="products-grid">
          {displayedProducts.map(product => (
            <ProductCard key={product.id} product={product} />
          ))}
        </div>
      ) : (
        <p>Товары не найдены</p>
      )}
    </div>
  );
};

export default ProductList;