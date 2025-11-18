import React, { useContext } from 'react';
import { Link } from 'react-router-dom';
import { CartContext } from '../context/CartContext';
import Cart from '../components/Cart';

const CartPage = () => {
  const { cartItems } = useContext(CartContext);

  return (
    <div className="cart-page">
      <div className="container">
        <h1>Корзина</h1>
        
        {cartItems.length === 0 ? (
          <div className="empty-cart">
            <p>Ваша корзина пуста</p>
            <Link to="/catalog" className="continue-shopping-btn">
              Продолжить покупки
            </Link>
          </div>
        ) : (
          <>
            <Cart />
            <div className="cart-actions-bottom">
              <button className="checkout-btn">
                Перейти к оформлению
              </button>
            </div>
          </>
        )}
      </div>
    </div>
  );
};

export default CartPage;