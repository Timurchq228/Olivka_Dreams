export const orders = [
  {
    id: 'ORD-001',
    date: '15.11.2023',
    status: 'ready',
    total: 4500,
    items: [
      {
        id: 1,
        name: 'Непромокаемая муслиновая пеленка',
        price: 1200,
        quantity: 2,
        image: '/images/waterproof-muslin.jpg'
      },
      {
        id: 4,
        name: 'Держатель для сосок',
        price: 350,
        quantity: 3,
        image: '/images/pacifier-holder.jpg'
      }
    ]
  },
  {
    id: 'ORD-002',
    date: '10.11.2023',
    status: 'shipping',
    total: 3200,
    items: [
      {
        id: 3,
        name: 'Утепленный комбинезон из футера',
        price: 2500,
        quantity: 1,
        image: '/images/warm-combineson.jpg'
      },
      {
        id: 7,
        name: 'Слюнявчик муслиновый',
        price: 450,
        quantity: 1,
        image: '/images/muslin-bib.jpg'
      }
    ]
  },
  {
    id: 'ORD-003',
    date: '05.11.2023',
    status: 'delivered',
    total: 800,
    items: [
      {
        id: 2,
        name: 'Обычная муслиновая пеленка',
        price: 800,
        quantity: 1,
        image: '/images/regular-muslin.jpg'
      }
    ]
  },
  {
    id: 'ORD-004',
    date: '01.11.2023',
    status: 'cancelled',
    total: 1500,
    items: [
      {
        id: 6,
        name: 'Детский плед из муслина',
        price: 1500,
        quantity: 1,
        image: '/images/muslin-blanket.jpg'
      }
    ]
  }
];