CREATE DATABASE IF NOT EXISTS olivka_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE olivka_db;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE IF NOT EXISTS customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    phone VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    short_description TEXT,
    description TEXT,
    price INT NOT NULL DEFAULT 0,
    image VARCHAR(255) DEFAULT '',
    badge VARCHAR(100) DEFAULT '',
    sizes_text VARCHAR(255) DEFAULT '',
    status_text VARCHAR(100) DEFAULT 'В наличии',
    features TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_code VARCHAR(50) NOT NULL,
    customer_id INT NULL,
    customer_name VARCHAR(255) NOT NULL,
    customer_phone VARCHAR(100) NOT NULL,
    delivery_type VARCHAR(50) NOT NULL,
    delivery_label VARCHAR(100) DEFAULT '',
    address TEXT NOT NULL,
    comment_text TEXT,
    items_json LONGTEXT NOT NULL,
    subtotal INT NOT NULL DEFAULT 0,
    delivery_cost INT NOT NULL DEFAULT 0,
    grand_total INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_orders_customer FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


INSERT IGNORE INTO users (username, password)
VALUES ('GoOliv', '$2y$12$oDIFFvuJKGUZVOJfTWeg2eXB3ihyAd4cTX9.0BQGAjPHWM8Iw8Cq2');

TRUNCATE TABLE products;
INSERT INTO products (id,title,short_description,description,price,image,badge,sizes_text,status_text,features) VALUES (1,'Держатель для соски','Удобный держатель с креплением к одежде','Практичный и удобный держатель для соски с надежным креплением к детской одежде. Не потеряется даже во время активных игр.',400,'держатель.jpg','Практичный','Цвета: розовый, голубой, бежевый','В наличии','Надежное крепление к одежде
Мягкий силиконовый держатель
Длина регулируемого шнура: 15 см
Легко чистится
Безопасный материал');
INSERT INTO products (id,title,short_description,description,price,image,badge,sizes_text,status_text,features) VALUES (2,'Утепленный комбинезон из футера','Мягкий комбинезон для прогулок в прохладную погоду','Мягкий и теплый комбинезон из качественного футера для комфортных прогулок в прохладную погоду. Идеально подходит для осенних и зимних прогулок.',1600,'комбинезон.jpg','Теплый','Размеры: 62, 68, 74, 80','В наличии','Материал: 100% хлопок (футер)
Утепленный капюшон
Манжеты на рукавах и штанинах
Молния для удобства одевания
Карманы для рук');
INSERT INTO products (id,title,short_description,description,price,image,badge,sizes_text,status_text,features) VALUES (3,'Купальник для беременных','Удобный и стильный купальник для будущих мам','Стильный и удобный купальник для будущих мам. Специальный крой обеспечивает комфорт и поддержку во время плавания.',1500,'купальник.jpg','Для мам','Размеры: S, M, L, XL','Нет в наличии','Специальный крой для беременных
Поддержка живота и груди
Быстросохнущая ткань
УФ-защита 50+
Удобные регулируемые бретели');
INSERT INTO products (id,title,short_description,description,price,image,badge,sizes_text,status_text,features) VALUES (4,'Детское полотенце банное','Мягкое полотенце с капюшоном для малышей','Мягкое банное полотенце с капюшоном для малышей. Отлично впитывает влагу и сохраняет тепло после купания.',1500,'полотенце.jpg','Мягкое','Размер: 80x100 см','В наличии','Размер: 80x100 см
Материал: 100% хлопок (махра)
Удобный капюшон
Мягкая ткань, не раздражает кожу
Яркие детские принты');
INSERT INTO products (id,title,short_description,description,price,image,badge,sizes_text,status_text,features) VALUES (5,'Подарочный бокс','Набор детских товаров в красивой упаковке','Набор детских товаров в красивой упаковке. Идеальный подарок на рождение ребенка или детский праздник.',1728,'бокс.jpg','Подарок','Состав: 5 предметов','В наличии','5 предметов в наборе
Красивая подарочная упаковка
Все товары из натуральных материалов
Возможность выбрать тематику
Подарочная карточка');
INSERT INTO products (id,title,short_description,description,price,image,badge,sizes_text,status_text,features) VALUES (6,'Рюкзак для мам','Вместительный рюкзак для детских вещей','Вместительный и стильный рюкзак для детских вещей. Удобно носить все необходимое на прогулках, в поликлинике или в путешествии.',1900,'рюкзак.jpg','Стильный','Цвета: серый, бежевый, черный','В наличии','Вместительный: 25 литров
Водоотталкивающая ткань
Отделение для бутылочки
Карман для влажных салфеток
Удобные мягкие лямки');
INSERT INTO products (id,title,short_description,description,price,image,badge,sizes_text,status_text,features) VALUES (7,'Бра для кормления','Удобный бюстгальтер для кормящих мам','Удобный бюстгальтер для кормящих мам. Поддерживает грудь и обеспечивает легкий доступ для кормления малыша.',1900,'бра.jpg','Для мам','Размеры: 44/100 CDE, 44/100 CD','В наличии','Удобный доступ для кормления
Поддерживающая конструкция
Мягкие регулируемые бретели
Дышащий материал
Легко расстегивается одной рукой');
INSERT INTO products (id,title,short_description,description,price,image,badge,sizes_text,status_text,features) VALUES (8,'WOW Непромокаемая пелёнка','Муслиновая пеленка с непромокаемым слоем','Муслиновые непромокаемые пелёнки – идеальное сочетание комфорта и защиты! Сочетают преимущества натурального муслина и современных непромокаемых технологий.',1200,'пеленка.jpg','Непромокаемая','Размер: 65×90 см','В наличии','Дышащий муслин – лёгкая, мягкая и гипоаллергенная ткань
Непромокаемый слой – нижняя часть с мембраной блокирует протекание
Многофункциональность – подходят для пеленания, подстилки, кормления
Удобство ухода – выдерживают стирку при 40–90°C');
INSERT INTO products (id,title,short_description,description,price,image,badge,sizes_text,status_text,features) VALUES (9,'Муслиновый нагрудник','Двусторонний слюнявчик из муслина','Непромокаемый двусторонний слюнявчик из нежнейшего муслина и непромокаемой мембранной ткани. На обороте застежки для регулировки размера.',190,'нагрудник.jpg','Непромокаемый','Цена: от 190 ₽ (1 шт)','В наличии','Двусторонний – можно использовать с двух сторон
Непромокаемая мембрана
Застежки для регулировки размера
Мягкий муслин не раздражает кожу
Легко стирается и быстро сохнет');
INSERT INTO products (id,title,short_description,description,price,image,badge,sizes_text,status_text,features) VALUES (10,'Косынка детская из муслина','Модная косынка для малышки из муслина','Отличный вариант на лето для вашей малышки! Косынка выполнена из нежнейшего муслина - натурального, дышащего материала, который идеально подходит для нежной детской кожи.',300,'косынка.jpg','Стильная','Размеры: 42-48','В наличии','Изготовлена из 100% хлопкового муслина
Мягкая и нежная на ощупь
Не вызывает раздражения
Легко стирается и быстро сохнет
Доступна в разных расцветках');
INSERT INTO products (id,title,short_description,description,price,image,badge,sizes_text,status_text,features) VALUES (11,'Пеленка из муслина ','Мягкая пеленка из 100% муслина','Мягкие муслиновые пелёнки – нежность и комфорт для малыша! Идеальны с первых дней жизни. Универсальные: для пеленания, как покрывало, подстилка, полотенце или накидка для коляски.',720,'пеленка_муслин.jpg','Мягкая','Размер: 90×65 см','В наличии','Дышащий муслин – лёгкий, натуральный, гипоаллергенный
Универсальность – используется для пеленания, как покрывало, подстилка
Мягкость – становится нежнее с каждой стиркой
Практичность – быстро сохнет, не линяет, легко гладится
Безопасность – 100% хлопок, безопасный для детской кожи');
INSERT INTO products (id,title,short_description,description,price,image,badge,sizes_text,status_text,features) VALUES (12,'Костюм из муслина для мальчика','Комплект из муслина для мальчика','В наличии нежнейший костюм-двойка для мальчика из 100% муслина. Идеальный комплект для теплой погоды и домашнего комфорта. В комплекте: мягкая майка/топик и удобные штанишки на резинке.',990,'костюм.jpg','Комплект','Размеры: 56-80','В наличии','Долговечность и износостойкость благодаря особому плетению муслина
Превосходная воздухопроницаемость – ткань ''дышит''
Защита от УФ-лучей – муслин естественным образом защищает кожу
Гипоаллергенность – 100% натуральный хлопок
Мягкость – становится еще мягче после каждой стирки');
INSERT INTO products (id,title,short_description,description,price,image,badge,sizes_text,status_text,features) VALUES (13,'Платье-боди + повязка для малышки','Комплект для малышки из муслина','Прекрасный комплект для маленькой принцессы! Платье-боди + повязка на голову выполнены из нежнейшего муслина. Идеальный набор для фотосессий, праздников и повседневной носки.',990,'платье.jpg','Набор','Размеры: 68-86','В наличии','Платье-боди с кнопочками между ножек для удобства смены подгузника
Повязка на голову из такого же муслина
Стильная упаковка – готовый подарок!
Идеально для жаркого летнего дня
Все швы обработаны, не натирают кожу');
INSERT INTO products (id,title,short_description,description,price,image,badge,sizes_text,status_text,features) VALUES (14,'Резинка для волос из муслина','Мягкая резинка из двухслойного муслина','Резинка для волос из двухслойного муслина - идеальный аксессуар для маленьких модниц и их мам! Бережно относится к волосам и отлично держит даже тонкие детские волосики.',50,'резинка.jpg','Аксессуар','12+ цветов','В наличии','Бережное отношение к волосам – не рвет и не тянет волосы
Отлично держит – благодаря эластичной резинке внутри
Мягкая и удобная – не давит на голову даже при длительной носке
Универсальный размер – подходит и детям, и взрослым
Доступна в 12+ цветах');