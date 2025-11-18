import React, { useContext } from 'react';
import { CartContext } from '../context/CartContext';

const Cart = () => {
  const { cartItems, removeFromCart, updateQuantity, clearCart } = useContext(CartContext);

  const totalPrice = cartItems.reduce((total, item) => total + (item.price * item.quantity), 0);

  return (
    <div className="cart">
      <div className="cart-items">
        {cartItems.map(item => (
          <div key={item.id} className="cart-item">
            <img src={item.image} alt={item.name} />
            <div className="item-details">
              <h4>{item.name}</h4>
              <p>{item.price} ₽</p>
            </div>
            <div className="quantity-controls">
              <button onClick={() => updateQuantity(item.id, item.quantity - 1)}>-</button>
              <span>{item.quantity}</span>
              <button onClick={() => updateQuantity(item.id, item.quantity + 1)}>+</button>
            </div>
            <div className="item-total">
              {item.price * item.quantity} ₽
            </div>
            <button 
              className="remove-btn"
              onClick={() => removeFromCart(item.id)}
            >
              Удалить
            </button>
          </div>
        ))}
      </div>
      
      <div className="cart-summary">
        <div className="total">
          <strong>Итого: {totalPrice} ₽</strong>
        </div>
        <div className="cart-actions">
          <button className="clear-cart-btn" onClick={clearCart}>
            Очистить корзину
          </button>
        </div>
      </div>
    </div>
  );
};

export default Cart;