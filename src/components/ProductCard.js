import React, { useContext } from 'react';
import { CartContext } from '../context/CartContext';

const ProductCard = ({ product }) => {
  const { addToCart } = useContext(CartContext);

  const handleAddToCart = () => {
    addToCart(product);
    alert('Товар добавлен в корзину!');
  };

  return (
    <div className="product-card">
      <div className="product-image">
        <img src={product.image} alt={product.name} />
      </div>
      <div className="product-info">
        <h3 className="product-name">{product.name}</h3>
        <p className="product-brand">{product.brand}</p>
        <p className="product-description">{product.description}</p>
        <p className="product-price">{product.price} ₽</p>
        <div className="product-actions">
          <button className="add-to-cart-btn" onClick={handleAddToCart}>
            В корзину
          </button>
        </div>
      </div>
    </div>
  );
};

export default ProductCard;