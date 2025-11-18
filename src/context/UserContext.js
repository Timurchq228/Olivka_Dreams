import React, { createContext, useState, useContext } from 'react';

const UserContext = createContext();

export const useUser = () => {
  return useContext(UserContext);
};

export const UserProvider = ({ children }) => {
  const [user, setUser] = useState({
    id: 1,
    name: 'Иван Иванов',
    email: 'ivan@example.com',
    phone: '+7 (912) 345-67-89',
    address: 'Ижевск, ул. Пушкина, д. 10',
    isSeller: false
  });

  const updateUser = (updatedData) => {
    setUser(prevUser => ({
      ...prevUser,
      ...updatedData
    }));
  };

  const value = {
    user,
    updateUser
  };

  return (
    <UserContext.Provider value={value}>
      {children}
    </UserContext.Provider>
  );
};

export { UserContext };