import React from 'react';
import { Link } from 'react-router-dom';
import ProductList from '../components/ProductList';

const Home = () => {
  return (
    <div className="home-page">
      <section className="hero-section">
        <div className="container">
          <div className="hero-content">
            <h1>Olivka_Dreams - комфорт для самых маленьких</h1>
            <p>Сделаем жизнь каждой мамы приятнее, комфортнее и проще</p>
            <Link to="/catalog" className="cta-button">Перейти к покупкам</Link>
          </div>
        </div>
      </section>

      <section className="features-section">
        <div className="container">
          <div className="features-grid">
            <div className="feature">
              <h3>Непромокаемые муслиновые пеленки</h3>
              <p>Защита от протеканий для спокойного сна</p>
            </div>
            <div className="feature">
              <h3>Обычные муслиновые пеленки</h3>
              <p>Мягкость и комфорт для нежной кожи</p>
            </div>
            <div className="feature">
              <h3>Утепленный комбинезон из футера</h3>
              <p>Тепло и уют в прохладную погоду</p>
            </div>
            <div className="feature">
              <h3>Держатели для сосок</h3>
              <p>Удобство и гигиена для малыша</p>
            </div>
          </div>
        </div>
      </section>

      <section className="promo-section">
        <div className="container">
          <h2>Акции и специальные предложения</h2>
          <div className="promo-banner">
            <p>Скидка 15% на первый заказ для новых клиентов!</p>
          </div>
        </div>
      </section>

      <section className="popular-products">
        <div className="container">
          <h2>Популярные товары</h2>
          <ProductList limit={4} />
        </div>
      </section>
    </div>
  );
};

export default Home;