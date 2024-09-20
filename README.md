# Diplom
![image](https://github.com/user-attachments/assets/9368efa2-5112-4e19-92f3-ae2e48eb4372)
![image](https://github.com/user-attachments/assets/9c47bee0-5190-42c3-a6b6-990a25bafade)

users {
	ID_пользователя integer pk increments unique
	Логин varchar(255)
	Пароль varchar(255)
	Email varchar(255)
}

games {
	id_игры integer pk increments unique
	Название varchar(255)
	Дата_выхода date(255)
	Автор varchar(255)
	Описание_игры varchar(255)
	id_изображения integer > images.id_изображения
}

updates {
	id_обновления integer pk increments unique
	id_игры integer > games.id_игры
	Описание_обновления varchar(255)
	Дата_обновления date(255)
	id_изображения integer > images.id_изображения
}

comments {
	id_комментария integer pk increments unique
	id_игры integer > games.id_игры
	id_пользователя integer > users.ID_пользователя
	id_обновления integer > updates.id_обновления
	Текст_комментария varchar(255)
	Дата_комментария datetime(255)
}

images {
	id_изображения integer pk increments unique
	url_изображения integer
}
