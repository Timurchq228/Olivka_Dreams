import React, { useState } from 'react';
import SellerDashboard from '../components/SellerDashboard';

const SellerPanel = () => {
  const [activeSection, setActiveSection] = useState('dashboard');

  return (
    <div className="seller-panel">
      <div className="container">
        <div className="seller-header">
          <h1>Панель продавца</h1>
          <p>Управление вашими товарами и продажами</p>
        </div>
        
        <div className="seller-layout">
          <aside className="seller-sidebar">
            <nav className="seller-nav">
              <button 
                className={activeSection === 'dashboard' ? 'active' : ''}
                onClick={() => setActiveSection('dashboard')}
              >
                Обзор
              </button>
              <button 
                className={activeSection === 'products' ? 'active' : ''}
                onClick={() => setActiveSection('products')}
              >
                Товары
              </button>
              <button 
                className={activeSection === 'brands' ? 'active' : ''}
                onClick={() => setActiveSection('brands')}
              >
                Бренды
              </button>
              <button 
                className={activeSection === 'promotion' ? 'active' : ''}
                onClick={() => setActiveSection('promotion')}
              >
                Продвижение
              </button>
              <button 
                className={activeSection === 'analytics' ? 'active' : ''}
                onClick={() => setActiveSection('analytics')}
              >
                Аналитика
              </button>
              <button 
                className={activeSection === 'orders' ? 'active' : ''}
                onClick={() => setActiveSection('orders')}
              >
                Заказы
              </button>
            </nav>
          </aside>
          
          <main className="seller-content">
            <SellerDashboard section={activeSection} />
          </main>
        </div>
      </div>
    </div>
  );
};

export default SellerPanel;