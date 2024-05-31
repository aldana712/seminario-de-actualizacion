
DROP DATABASE IF EXISTS accescontroldb

CREATE DATABASE accesscontroldb;

USE accescontroldb;

CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

CREATE TABLE user_group (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

CREATE TABLE user_group_member (
    id_user INT,
    id_user_group INT,
    PRIMARY KEY (id_user, id_user_group),
    FOREIGN KEY (id_user) REFERENCES user(id),
    FOREIGN KEY (id_user_group) REFERENCES team(id)
);

CREATE TABLE action (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

CREATE TABLE group_action (
    id_group INT,
    id_action INT,
    PRIMARY KEY (id_group, id_action),
    FOREIGN KEY (id_group) REFERENCES user_group(id),
    FOREIGN KEY (id_action) REFERENCES action(id)
);

INSERT INTO user_group (name) VALUES ('vendedor'), ('cliente');

INSERT INTO action (name) VALUES ('publicarProducto'), ('retirarProducto'), ('verPedido'), ('realizarPedido'), ('buscarProducto'), ('agregarProducto');

INSERT INTO group_action (id_group, id_action) VALUES
((SELECT ID FROM user_group WHERE name = 'vendedor'), (SELECT ID FROM action WHERE name = 'publicarProducto')),
((SELECT ID FROM user_group WHERE name = 'vendedor'), (SELECT ID FROM action WHERE name = 'retirarProducto')),
((SELECT ID FROM user_group WHERE name = 'vendedor'), (SELECT ID FROM action WHERE name = 'verPedido')),
((SELECT ID FROM user_group WHERE name = 'cliente'), (SELECT ID FROM action WHERE name = 'realizarProducto')),
((SELECT ID FROM user_group WHERE name = 'cliente'), (SELECT ID FROM action WHERE name = 'buscarProducto')),
((SELECT ID FROM user_group WHERE name = 'cliente'), (SELECT ID FROM action WHERE name = 'agregarProducto'));

INSERT INTO user (name) VALUES ('Juan Perez'), ('Ana Gomez');

INSERT INTO user_group_member(id_user, id_user_group) VALUES
((SELECT ID FROM user WHERE name = 'Juan Perez'), (SELECT ID FROM user_group WHERE name = 'vendedor')),
((SELECT ID FROM user WHERE name = 'Ana Gomez'), (SELECT ID FROM user_group WHERE name = 'cliente'));