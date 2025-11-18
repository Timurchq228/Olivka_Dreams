import React from 'react';

const Footer = () => {
  return (
    <footer className="footer">
      <div className="container">
        <div className="footer-content">
          <div className="footer-section">
            <h3>Olivka_Dreams</h3>
            <p>С заботой о самых маленьких</p>
          </div>
          <div className="footer-section">
            <h4>Покупателям</h4>
            <a href="#help">Помощь</a>
            <a href="#delivery">Доставка</a>
            <a href="#returns">Возвраты</a>
          </div>
          <div className="footer-section">
            <h4>Компания</h4>
            <a href="#about">О нас</a>
            <a href="#contacts">Контакты</a>
            <a href="#vacancies">Вакансии</a>
          </div>
        </div>
        <div className="footer-bottom">
          <p>© 2023 Olivka_Dreams. Все права защищены.</p>
        </div>
      </div>
    </footer>
  );
};

export default Footer;