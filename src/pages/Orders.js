import React, { useState } from 'react';
import OrderTracking from '../components/OrderTracking';
import { orders } from '../data/orders';

const Orders = () => {
  const [activeTab, setActiveTab] = useState('all');

  const filteredOrders = activeTab === 'all' 
    ? orders 
    : orders.filter(order => order.status === activeTab);

  return (
    <div className="orders-page">
      <div className="container">
        <h1>Мои заказы</h1>
        
        <div className="orders-tabs">
          <button 
            className={activeTab === 'all' ? 'active' : ''}
            onClick={() => setActiveTab('all')}
          >
            Все заказы
          </button>
          <button 
            className={activeTab === 'ready' ? 'active' : ''}
            onClick={() => setActiveTab('ready')}
          >
            Готов к выдаче
          </button>
          <button 
            className={activeTab === 'shipping' ? 'active' : ''}
            onClick={() => setActiveTab('shipping')}
          >
            В пути
          </button>
          <button 
            className={activeTab === 'delivered' ? 'active' : ''}
            onClick={() => setActiveTab('delivered')}
          >
            Получен
          </button>
          <button 
            className={activeTab === 'cancelled' ? 'active' : ''}
            onClick={() => setActiveTab('cancelled')}
          >
            Отменен
          </button>
        </div>
        
        <div className="orders-list">
          {filteredOrders.length > 0 ? (
            filteredOrders.map(order => (
              <OrderTracking key={order.id} order={order} />
            ))
          ) : (
            <p>Заказы не найдены</p>
          )}
        </div>
      </div>
    </div>
  );
};

export default Orders;