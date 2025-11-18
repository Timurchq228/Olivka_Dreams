import React, { useState } from 'react';

const SellerDashboard = ({ section }) => {
  const [products, setProducts] = useState([]);
  const [newProduct, setNewProduct] = useState({
    name: '',
    brand: '',
    price: '',
    category: '',
    description: '',
    image: ''
  });

  const handleInputChange = (e) => {
    const { name, value } = e.target;
    setNewProduct(prev => ({
      ...prev,
      [name]: value
    }));
  };

  const handleAddProduct = (e) => {
    e.preventDefault();
    const product = {
      id: Date.now(),
      ...newProduct,
      price: parseInt(newProduct.price)
    };
    setProducts([...products, product]);
    setNewProduct({
      name: '',
      brand: '',
      price: '',
      category: '',
      description: '',
      image: ''
    });
  };

  const renderSection = () => {
    switch (section) {
      case 'dashboard':
        return (
          <div className="dashboard-overview">
            <h2>Обзор продаж</h2>
            <div className="stats-grid">
              <div className="stat-card">
                <h3>Всего продаж</h3>
                <p className="stat-number">24</p>
              </div>
              <div className="stat-card">
                <h3>Выручка</h3>
                <p className="stat-number">45,600 ₽</p>
              </div>
              <div className="stat-card">
                <h3>Товаров в каталоге</h3>
                <p className="stat-number">{products.length}</p>
              </div>
              <div className="stat-card">
                <h3>Новых заказов</h3>
                <p className="stat-number">3</p>
              </div>
            </div>
          </div>
        );
      
      case 'products':
        return (
          <div className="products-management">
            <h2>Управление товарами</h2>
            
            <div className="add-product-form">
              <h3>Добавить новый товар</h3>
              <form onSubmit={handleAddProduct}>
                <div className="form-row">
                  <div className="form-group">
                    <label>Название товара</label>
                    <input
                      type="text"
                      name="name"
                      value={newProduct.name}
                      onChange={handleInputChange}
                      required
                    />
                  </div>
                  <div className="form-group">
                    <label>Бренд</label>
                    <input
                      type="text"
                      name="brand"
                      value={newProduct.brand}
                      onChange={handleInputChange}
                      required
                    />
                  </div>
                </div>
                
                <div className="form-row">
                  <div className="form-group">
                    <label>Цена</label>
                    <input
                      type="number"
                      name="price"
                      value={newProduct.price}
                      onChange={handleInputChange}
                      required
                    />
                  </div>
                  <div className="form-group">
                    <label>Категория</label>
                    <select
                      name="category"
                      value={newProduct.category}
                      onChange={handleInputChange}
                      required
                    >
                      <option value="">Выберите категорию</option>
                      <option value="Пеленки">Пеленки</option>
                      <option value="Одежда">Одежда</option>
                      <option value="Аксессуары">Аксессуары</option>
                    </select>
                  </div>
                </div>
                
                <div className="form-group">
                  <label>Описание</label>
                  <textarea
                    name="description"
                    value={newProduct.description}
                    onChange={handleInputChange}
                    rows="4"
                  />
                </div>
                
                <div className="form-group">
                  <label>URL изображения</label>
                  <input
                    type="url"
                    name="image"
                    value={newProduct.image}
                    onChange={handleInputChange}
                  />
                </div>
                
                <button type="submit" className="add-product-btn">
                  Добавить товар
                </button>
              </form>
            </div>
            
            <div className="products-list">
              <h3>Ваши товары</h3>
              {products.length > 0 ? (
                <div className="products-grid">
                  {products.map(product => (
                    <div key={product.id} className="product-item">
                      <div className="product-image">
                        {product.image ? (
                          <img src={product.image} alt={product.name} />
                        ) : (
                          <div className="no-image">Нет изображения</div>
                        )}
                      </div>
                      <div className="product-info">
                        <h4>{product.name}</h4>
                        <p>{product.brand}</p>
                        <p className="price">{product.price} ₽</p>
                        <div className="product-actions">
                          <button className="edit-btn">Редактировать</button>
                          <button className="delete-btn">Удалить</button>
                        </div>
                      </div>
                    </div>
                  ))}
                </div>
              ) : (
                <p>У вас пока нет товаров</p>
              )}
            </div>
          </div>
        );
      
      case 'brands':
        return (
          <div className="brands-management">
            <h2>Управление брендами</h2>
            <p>Здесь вы можете управлять своими брендами</p>
          </div>
        );
      
      case 'promotion':
        return (
          <div className="promotion-management">
            <h2>Продвижение товаров</h2>
            <p>Инструменты для продвижения ваших товаров</p>
          </div>
        );
      
      case 'analytics':
        return (
          <div className="analytics-management">
            <h2>Аналитика продаж</h2>
            <p>Статистика и аналитика по вашим продажам</p>
          </div>
        );
      
      case 'orders':
        return (
          <div className="orders-management">
            <h2>Управление заказами</h2>
            <p>Просмотр и управление заказами покупателей</p>
          </div>
        );
      
      default:
        return <div>Выберите раздел</div>;
    }
  };

  return (
    <div className="seller-dashboard">
      {renderSection()}
    </div>
  );
};

export default SellerDashboard;