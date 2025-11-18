import React, { useContext, useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { CartContext } from '../context/CartContext';
import CheckoutForm from '../components/CheckoutForm';

const Checkout = () => {
  const { cartItems, clearCart } = useContext(CartContext);
  const navigate = useNavigate();
  const [orderComplete, setOrderComplete] = useState(false);
  const [orderNumber, setOrderNumber] = useState(null);

  const totalPrice = cartItems.reduce((total, item) => total + (item.price * item.quantity), 0);

  const handleOrderSubmit = (orderData) => {
    // Здесь будет логика отправки заказа на сервер
    const newOrderNumber = Math.floor(Math.random() * 1000000);
    setOrderNumber(newOrderNumber);
    setOrderComplete(true);
    clearCart();
  };

  if (orderComplete) {
    return (
      <div className="checkout-page">
        <div className="container">
          <div className="order-success">
            <h1>Заказ оформлен!</h1>
            <div className="success-icon">✅</div>
            <p>Ваш заказ №{orderNumber} успешно оформлен.</p>
            <p>Мы свяжемся с вами для подтверждения заказа.</p>
            <div className="success-actions">
              <button onClick={() => navigate('/orders')} className="btn-primary">
                Посмотреть заказы
              </button>
              <button onClick={() => navigate('/catalog')} className="btn-secondary">
                Продолжить покупки
              </button>
            </div>
          </div>
        </div>
      </div>
    );
  }

  return (
    <div className="checkout-page">
      <div className="container">
        <h1>Оформление заказа</h1>
        
        <div className="checkout-content">
          <div className="checkout-form-section">
            <CheckoutForm onSubmit={handleOrderSubmit} />
          </div>
          
          <div className="checkout-summary">
            <h2>Ваш заказ</h2>
            <div className="order-items">
              {cartItems.map(item => (
                <div key={item.id} className="checkout-item">
                  <img src={item.image} alt={item.name} />
                  <div className="item-details">
                    <h4>{item.name}</h4>
                    <p>Количество: {item.quantity}</p>
                  </div>
                  <div className="item-price">
                    {item.price * item.quantity} ₽
                  </div>
                </div>
              ))}
            </div>
            
            <div className="order-total">
              <strong>Итого: {totalPrice} ₽</strong>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Checkout;