import React, { useState } from 'react';

const Filters = ({ onFilterChange }) => {
  const [filters, setFilters] = useState({
    brand: 'all',
    minPrice: '',
    maxPrice: '',
    category: 'all'
  });

  const handleFilterChange = (key, value) => {
    const newFilters = {
      ...filters,
      [key]: value
    };
    setFilters(newFilters);
    onFilterChange(newFilters);
  };

  const clearFilters = () => {
    const clearedFilters = {
      brand: 'all',
      minPrice: '',
      maxPrice: '',
      category: 'all'
    };
    setFilters(clearedFilters);
    onFilterChange(clearedFilters);
  };

  return (
    <div className="filters">
      <h3>Фильтры</h3>
      
      <div className="filter-group">
        <label htmlFor="brand">Бренд</label>
        <select 
          id="brand"
          value={filters.brand}
          onChange={(e) => handleFilterChange('brand', e.target.value)}
        >
          <option value="all">Все бренды</option>
          <option value="Olivka_Dreams">Olivka_Dreams</option>
        </select>
      </div>

      <div className="filter-group">
        <label htmlFor="category">Категория</label>
        <select 
          id="category"
          value={filters.category}
          onChange={(e) => handleFilterChange('category', e.target.value)}
        >
          <option value="all">Все категории</option>
          <option value="Пеленки">Пеленки</option>
          <option value="Одежда">Одежда</option>
          <option value="Аксессуары">Аксессуары</option>
        </select>
      </div>

      <div className="filter-group">
        <label htmlFor="minPrice">Минимальная цена</label>
        <input
          id="minPrice"
          type="number"
          value={filters.minPrice}
          onChange={(e) => handleFilterChange('minPrice', e.target.value)}
          placeholder="0"
        />
      </div>

      <div className="filter-group">
        <label htmlFor="maxPrice">Максимальная цена</label>
        <input
          id="maxPrice"
          type="number"
          value={filters.maxPrice}
          onChange={(e) => handleFilterChange('maxPrice', e.target.value)}
          placeholder="10000"
        />
      </div>

      <button className="clear-filters-btn" onClick={clearFilters}>
        Сбросить фильтры
      </button>
    </div>
  );
};

export default Filters;