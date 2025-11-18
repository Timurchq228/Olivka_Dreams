import React, { useContext, useState } from 'react';
import { Link } from 'react-router-dom';
import { CartContext } from '../context/CartContext';
import { UserContext } from '../context/UserContext';

const Header = ({ language, setLanguage, currency, setCurrency }) => {
  const { cartItems } = useContext(CartContext);
  const { user } = useContext(UserContext);
  const [searchQuery, setSearchQuery] = useState('');

  const cartItemsCount = cartItems.reduce((total, item) => total + item.quantity, 0);

  const handleSearch = (e) => {
    e.preventDefault();
    console.log('Searching for:', searchQuery);
  };

  return (
    <header className="header">
      <div className="top-header">
        <div className="container">
          <div className="top-header-content">
            <div className="location">
              <span>Ижевск</span>
            </div>
           
            <div className="header-actions">
              <select 
                value={language} 
                onChange={(e) => setLanguage(e.target.value)}
                className="language-select"
              >
                <option value="ru">RU</option>
                <option value="en">EN</option>
              </select>
              <select 
                value={currency} 
                onChange={(e) => setCurrency(e.target.value)}
                className="currency-select"
              >
                <option value="RUB">₽</option>
                <option value="USD">$</option>
                <option value="EUR">€</option>
              </select>
              <span className="balance">0 {currency === 'RUB' ? '₽' : currency === 'USD' ? '$' : '€'}</span>
            </div>
          </div>
        </div>
      </div>

      <div className="main-header">
        <div className="container">
          <div className="main-header-content">
            <div className="logo">
              <Link to="/">
                <span className="logo-text">Olivka_Dreams</span>
              </Link>
            </div>
            
            <form className="search-form" onSubmit={handleSearch}>
              <input
                type="text"
                placeholder="Найти на Olivka_Dreams"
                value={searchQuery}
                onChange={(e) => setSearchQuery(e.target.value)}
              />
              <button type="submit">Найти</button>
            </form>

            <div className="user-actions">
              <Link to="/orders" className="header-link">
                <span>Заказы</span>
              </Link>
              <Link to="/profile" className="header-link">
                <span>Избранное</span>
              </Link>
              <Link to="/profile" className="header-link profile-link">
                <span className="profile-icon">👤</span>
                <span>Профиль</span>
              </Link>
              <Link to="/cart" className="header-link cart-link">
                <span className="cart-icon">🛒</span>
                <span className="cart-count">{cartItemsCount}</span>
              </Link>
            </div>
          </div>
        </div>
      </div>

      <nav className="categories-nav">
        <div className="container">
          <div className="categories">
            <a href="#sale" className="sale-badge">11.11</a>
            <a href="#certificates">Сертификаты</a>
            <a href="#promotions">Акции</a>
            <Link to="/catalog">Все товары</Link>
            <a href="#waterproof">Непромокаемые пеленки</a>
            <a href="#regular">Обычные пеленки</a>
            <a href="#combinesons">Комбинезоны</a>
            <a href="#accessories">Аксессуары</a>
            <a href="#more">Ещё</a>
          </div>
        </div>
      </nav>
    </header>
  );
};

export default Header;