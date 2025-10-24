# 🚀 MicrosFirstTask

**MicrosFirstTask** — это демонстрационный проект на **Laravel + Vue.js**, запущенный в контейнерах Docker. Проект включает серверную часть на Laravel и клиентскую часть на Node.js, что делает его простым для развёртывания и тестирования.

---

## ⚙️ Установка и запуск

Следуйте инструкциям ниже, чтобы развернуть проект локально:

```bash
# 1️⃣ Клонируем репозиторий
git clone https://github.com/explorer16/MicrosFirstTask.git
```

```bash
# 2️⃣ Переходим в папку проекта
cd MicrosFirstTask
```

```bash
# 3️⃣ Запускаем Docker-контейнеры
docker compose up -d
```
```bash
# 4️⃣ Устанавливаем зависимости Laravel
docker exec first_app composer install
```
```bash
# 5️⃣ Копируем файл окружения
docker exec first_app cp .env.example .env
```
```bash
# 6️⃣ Генерируем ключ приложения
docker exec first_app php artisan key:generate
```
```bash
# 7️⃣ Применяем миграции и заполняем тестовыми данными
docker exec first_app php artisan migrate:fresh --seed
```

<hr>
Необязательные команды

```bash
# 8️⃣ Установка зависимости фронтенда
docker exec first_node npm install
```
```bash
# 9️⃣ Сборка фронтенда
docker exec first_node npm run build
```
