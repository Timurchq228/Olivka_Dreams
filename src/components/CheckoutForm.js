import React, { useState } from 'react';

const CheckoutForm = ({ onSubmit }) => {
  const [formData, setFormData] = useState({
    firstName: '',
    lastName: '',
    email: '',
    phone: '',
    address: '',
    city: 'Ижевск',
    paymentMethod: 'card',
    deliveryMethod: 'pickup'
  });

  const handleInputChange = (e) => {
    const { name, value } = e.target;
    setFormData(prev => ({
      ...prev,
      [name]: value
    }));
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    onSubmit(formData);
  };

  return (
    <form className="checkout-form" onSubmit={handleSubmit}>
      <div className="form-section">
        <h3>Контактная информация</h3>
        <div className="form-row">
          <div className="form-group">
            <label>Имя *</label>
            <input
              type="text"
              name="firstName"
              value={formData.firstName}
              onChange={handleInputChange}
              required
            />
          </div>
          <div className="form-group">
            <label>Фамилия *</label>
            <input
              type="text"
              name="lastName"
              value={formData.lastName}
              onChange={handleInputChange}
              required
            />
          </div>
        </div>
        
        <div className="form-row">
          <div className="form-group">
            <label>Email *</label>
            <input
              type="email"
              name="email"
              value={formData.email}
              onChange={handleInputChange}
              required
            />
          </div>
          <div className="form-group">
            <label>Телефон *</label>
            <input
              type="tel"
              name="phone"
              value={formData.phone}
              onChange={handleInputChange}
              required
            />
          </div>
        </div>
      </div>

      <div className="form-section">
        <h3>Адрес доставки</h3>
        <div className="form-group">
          <label>Город</label>
          <input
            type="text"
            name="city"
            value={formData.city}
            onChange={handleInputChange}
            required
          />
        </div>
        <div className="form-group">
          <label>Адрес *</label>
          <textarea
            name="address"
            value={formData.address}
            onChange={handleInputChange}
            rows="3"
            required
          />
        </div>
      </div>

      <div className="form-section">
        <h3>Способ доставки</h3>
        <div className="radio-group">
          <label className="radio-label">
            <input
              type="radio"
              name="deliveryMethod"
              value="pickup"
              checked={formData.deliveryMethod === 'pickup'}
              onChange={handleInputChange}
            />
            Самовывоз из пункта выдачи
          </label>
          <label className="radio-label">
            <input
              type="radio"
              name="deliveryMethod"
              value="courier"
              checked={formData.deliveryMethod === 'courier'}
              onChange={handleInputChange}
            />
            Курьерская доставка
          </label>
        </div>
      </div>

      <div className="form-section">
        <h3>Способ оплаты</h3>
        <div className="radio-group">
          <label className="radio-label">
            <input
              type="radio"
              name="paymentMethod"
              value="card"
              checked={formData.paymentMethod === 'card'}
              onChange={handleInputChange}
            />
            Банковская карта
          </label>
          <label className="radio-label">
            <input
              type="radio"
              name="paymentMethod"
              value="cash"
              checked={formData.paymentMethod === 'cash'}
              onChange={handleInputChange}
            />
            Наличные при получении
          </label>
        </div>
      </div>

      <button type="submit" className="submit-order-btn">
        Подтвердить заказ
      </button>
    </form>
  );
};

export default CheckoutForm;