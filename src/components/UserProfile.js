import React, { useContext, useState } from 'react';
import { UserContext } from '../context/UserContext';

const UserProfile = () => {
  const { user, updateUser } = useContext(UserContext);
  const [isEditing, setIsEditing] = useState(false);
  const [formData, setFormData] = useState({
    name: user.name,
    email: user.email,
    phone: user.phone,
    address: user.address
  });

  const handleInputChange = (e) => {
    const { name, value } = e.target;
    setFormData(prev => ({
      ...prev,
      [name]: value
    }));
  };

  const handleSave = () => {
    updateUser(formData);
    setIsEditing(false);
    alert('Профиль обновлен!');
  };

  const handleCancel = () => {
    setFormData({
      name: user.name,
      email: user.email,
      phone: user.phone,
      address: user.address
    });
    setIsEditing(false);
  };

  return (
    <div className="user-profile">
      <h2>Личный кабинет</h2>
      
      <div className="profile-section">
        <div className="profile-header">
          <h3>Профиль</h3>
          {!isEditing ? (
            <button onClick={() => setIsEditing(true)}>Редактировать</button>
          ) : (
            <div>
              <button onClick={handleSave}>Сохранить</button>
              <button onClick={handleCancel}>Отмена</button>
            </div>
          )}
        </div>
        
        <div className="profile-info">
          {isEditing ? (
            <div className="edit-form">
              <div className="form-group">
                <label>Имя:</label>
                <input
                  type="text"
                  name="name"
                  value={formData.name}
                  onChange={handleInputChange}
                />
              </div>
              <div className="form-group">
                <label>Email:</label>
                <input
                  type="email"
                  name="email"
                  value={formData.email}
                  onChange={handleInputChange}
                />
              </div>
              <div className="form-group">
                <label>Телефон:</label>
                <input
                  type="tel"
                  name="phone"
                  value={formData.phone}
                  onChange={handleInputChange}
                />
              </div>
              <div className="form-group">
                <label>Адрес:</label>
                <input
                  type="text"
                  name="address"
                  value={formData.address}
                  onChange={handleInputChange}
                />
              </div>
            </div>
          ) : (
            <div className="profile-details">
              <p><strong>Имя:</strong> {user.name}</p>
              <p><strong>Email:</strong> {user.email}</p>
              <p><strong>Телефон:</strong> {user.phone}</p>
              <p><strong>Адрес:</strong> {user.address}</p>
            </div>
          )}
        </div>
      </div>
      
      <div className="profile-section">
        <h3>Избранное</h3>
        <p>Здесь будут ваши избранные товары</p>
      </div>
      
      <div className="profile-section">
        <h3>Для продавцов</h3>
        <button className="seller-link">
          Перейти в панель продавца
        </button>
      </div>
    </div>
  );
};

export default UserProfile;