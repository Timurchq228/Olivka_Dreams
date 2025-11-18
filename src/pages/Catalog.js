import React, { useState } from 'react';
import ProductList from '../components/ProductList';
import Filters from '../components/Filters';

const Catalog = () => {
  const [filters, setFilters] = useState({
    brand: 'all',
    minPrice: '',
    maxPrice: '',
    category: 'all'
  });

  const handleFilterChange = (newFilters) => {
    setFilters(newFilters);
  };

  return (
    <div className="catalog-page">
      <div className="container">
        <div className="catalog-header">
          <h1>Каталог товаров</h1>
          <p>Все для комфорта вашего малыша</p>
        </div>
        
        <div className="catalog-content">
          <aside className="filters-sidebar">
            <Filters onFilterChange={handleFilterChange} />
          </aside>
          
          <main className="products-main">
            <ProductList filters={filters} />
          </main>
        </div>
      </div>
    </div>
  );
};

export default Catalog;