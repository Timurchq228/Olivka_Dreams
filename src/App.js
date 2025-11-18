import React, { useState } from 'react';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import { CartProvider } from './context/CartContext';
import { UserProvider } from './context/UserContext';
import Header from './components/Header';
import Footer from './components/Footer';
import Home from './pages/Home';
import Catalog from './pages/Catalog';
import CartPage from './pages/CartPage';
import Profile from './pages/Profile';
import Orders from './pages/Orders';
import './App.css';

function App() {
  const [language, setLanguage] = useState('ru');
  const [currency, setCurrency] = useState('RUB');

  return (
    <Router>
      <UserProvider>
        <CartProvider>
          <div className="app">
            <Header 
              language={language} 
              setLanguage={setLanguage}
              currency={currency}
              setCurrency={setCurrency}
            />
            <main className="main-content">
              <Routes>
                <Route path="/" element={<Home />} />
                <Route path="/catalog" element={<Catalog />} />
                <Route path="/cart" element={<CartPage />} />
                <Route path="/profile" element={<Profile />} />
                <Route path="/orders" element={<Orders />} />
              </Routes>
            </main>
            <Footer />
          </div>
        </CartProvider>
      </UserProvider>
    </Router>
  );
}

export default App;