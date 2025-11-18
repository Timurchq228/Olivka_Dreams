import React from 'react';

const OrderTracking = ({ order }) => {
  const getStatusText = (status) => {
    const statusMap = {
      'ready': 'Готов к выдаче',
      'shipping': 'В пути',
      'delivered': 'Получен',
      'cancelled': 'Отменен'
    };
    return statusMap[status] || status;
  };

  const getStatusClass = (status) => {
    return `status-${status}`;
  };

  return (
    <div className="order-card">
      <div className="order-header">
        <div className="order-info">
          <h3>Заказ №{order.id}</h3>
          <p className="order-date">{order.date}</p>
        </div>
        <div className="order-status">
          <span className={`status-badge ${getStatusClass(order.status)}`}>
            {getStatusText(order.status)}
          </span>
        </div>
      </div>
      
      <div className="order-items">
        {order.items.map(item => (
          <div key={item.id} className="order-item">
            <img src={item.image} alt={item.name} />
            <div className="item-details">
              <h4>{item.name}</h4>
              <p>Количество: {item.quantity}</p>
              <p className="item-price">{item.price} ₽</p>
            </div>
          </div>
        ))}
      </div>
      
      <div className="order-footer">
        <div className="order-total">
          <strong>Итого: {order.total} ₽</strong>
        </div>
        <div className="order-actions">
          {order.status === 'ready' && (
            <button className="action-btn primary">Забрать заказ</button>
          )}
          {order.status === 'shipping' && (
            <button className="action-btn secondary">Отследить</button>
          )}
          <button className="action-btn">Повторить заказ</button>
        </div>
      </div>
    </div>
  );
};

export default OrderTracking;