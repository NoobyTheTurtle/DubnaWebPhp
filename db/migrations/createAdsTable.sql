-- Создание таблицы для объявлений
CREATE TABLE ads
(
    id          SERIAL PRIMARY KEY,
    title       VARCHAR(100) NOT NULL,
    description TEXT         NOT NULL,
    user_id     INT REFERENCES users (id),
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
