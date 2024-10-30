CREATE TABLE IF NOT EXISTS tarefas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descricao TEXT,
    status ENUM('pendente', 'concluída') DEFAULT 'pendente'
);

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

INSERT INTO usuarios (username, password) VALUES ('usuario', '$2y$10$PgJZ8QykkZmU7IMiOu4/Q.dKo6JPbyLl1mxJiRuHr7xNVEFYWdXZe');
