# 🗄️ Database Schema Documentation - KidsLearn

Dokumentasi lengkap struktur database aplikasi KidsLearn.

## Database Information

-   **Database Name:** kidslearn
-   **Engine:** MySQL/MariaDB or SQLite
-   **Charset:** utf8mb4
-   **Collation:** utf8mb4_unicode_ci

---

## Table Overview

| Table Name     | Description              | Rows (After Seeding)      |
| -------------- | ------------------------ | ------------------------- |
| users          | User accounts            | 2                         |
| animals        | Animal data for learning | 13                        |
| quiz_questions | Quiz questions           | 4                         |
| user_progress  | User learning progress   | 0 (created on first quiz) |
| cache          | Laravel cache            | Variable                  |
| cache_locks    | Laravel cache locks      | Variable                  |
| jobs           | Laravel queue jobs       | Variable                  |
| job_batches    | Laravel job batches      | Variable                  |
| failed_jobs    | Failed queue jobs        | Variable                  |
| sessions       | Laravel sessions         | Variable                  |

---

## Table: users

Stores user account information.

### Schema

```sql
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    avatar VARCHAR(255) DEFAULT 'avatar1.png',
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    INDEX idx_email (email)
);
```

### Columns

| Column            | Type            | Nullable | Default        | Description                           |
| ----------------- | --------------- | -------- | -------------- | ------------------------------------- |
| id                | BIGINT UNSIGNED | No       | AUTO_INCREMENT | Primary key                           |
| name              | VARCHAR(255)    | No       | -              | User's display name (username)        |
| email             | VARCHAR(255)    | No       | -              | User's email (unique, auto-generated) |
| email_verified_at | TIMESTAMP       | Yes      | NULL           | Email verification timestamp          |
| password          | VARCHAR(255)    | No       | -              | Hashed password                       |
| avatar            | VARCHAR(255)    | No       | avatar1.png    | Avatar filename                       |
| remember_token    | VARCHAR(100)    | Yes      | NULL           | Laravel remember token                |
| created_at        | TIMESTAMP       | Yes      | NULL           | Creation timestamp                    |
| updated_at        | TIMESTAMP       | Yes      | NULL           | Last update timestamp                 |

### Indexes

-   Primary Key: `id`
-   Unique: `email`
-   Index: `idx_email`

### Sample Data

```sql
INSERT INTO users (name, email, password, avatar) VALUES
('Budi', 'budi@example.com', '$2y$12$...', 'img/avatar1.png'),
('Siti', 'siti@example.com', '$2y$12$...', 'img/avatar2.png');
```

### Relationships

-   `hasOne` → user_progress

---

## Table: animals

Stores animal data for learning module.

### Schema

```sql
CREATE TABLE animals (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    category VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    sound_path VARCHAR(255) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    INDEX idx_category (category)
);
```

### Columns

| Column      | Type            | Nullable | Default        | Description                                              |
| ----------- | --------------- | -------- | -------------- | -------------------------------------------------------- |
| id          | BIGINT UNSIGNED | No       | AUTO_INCREMENT | Primary key                                              |
| name        | VARCHAR(255)    | No       | -              | Animal name (e.g., "Dog", "Elephant")                    |
| category    | VARCHAR(255)    | No       | -              | Category: mammals, birds, sea, insects, reptils, amphibi |
| description | TEXT            | No       | -              | Animal description                                       |
| image_path  | VARCHAR(255)    | No       | -              | Path to animal image                                     |
| sound_path  | VARCHAR(255)    | Yes      | NULL           | Path to animal sound file                                |
| created_at  | TIMESTAMP       | Yes      | NULL           | Creation timestamp                                       |
| updated_at  | TIMESTAMP       | Yes      | NULL           | Last update timestamp                                    |

### Indexes

-   Primary Key: `id`
-   Index: `idx_category`

### Categories

Valid category values:

-   `mammals` - Mamalia
-   `birds` - Burung
-   `sea` - Hewan Laut
-   `insects` - Serangga
-   `reptils` - Reptil
-   `amphibi` - Amfibi

### Sample Data

```sql
INSERT INTO animals (name, category, description, image_path, sound_path) VALUES
('Dog', 'mammals', 'has four legs, eats meat, vegetables...', 'img/dog1.png', 'sound/dog.mp3'),
('Elephant', 'mammals', 'has four legs, eats grass...', 'img/elephant.png', 'sound/Elephant.mp3'),
('Cat', 'mammals', 'has four legs, sharp claws...', 'img/kucing.png', 'sound/cat.mp3');
```

### Statistics

Total animals per category (after seeding):

-   Mammals: 4
-   Birds: 2
-   Sea Animals: 2
-   Insects: 2
-   Reptiles: 2
-   Amphibians: 1

---

## Table: quiz_questions

Stores quiz questions for mini games.

### Schema

```sql
CREATE TABLE quiz_questions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    question VARCHAR(255) NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    correct_answer VARCHAR(255) NOT NULL,
    options JSON NOT NULL,
    category VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    INDEX idx_category (category)
);
```

### Columns

| Column         | Type            | Nullable | Default        | Description             |
| -------------- | --------------- | -------- | -------------- | ----------------------- |
| id             | BIGINT UNSIGNED | No       | AUTO_INCREMENT | Primary key             |
| question       | VARCHAR(255)    | No       | -              | Quiz question text      |
| image_path     | VARCHAR(255)    | No       | -              | Path to question image  |
| correct_answer | VARCHAR(255)    | No       | -              | Correct answer          |
| options        | JSON            | No       | -              | Array of answer options |
| category       | VARCHAR(255)    | No       | -              | Animal category         |
| created_at     | TIMESTAMP       | Yes      | NULL           | Creation timestamp      |
| updated_at     | TIMESTAMP       | Yes      | NULL           | Last update timestamp   |

### Indexes

-   Primary Key: `id`
-   Index: `idx_category`

### Options Format

The `options` column stores JSON array:

```json
["cat", "dog", "cow", "ant"]
```

### Sample Data

```sql
INSERT INTO quiz_questions (question, image_path, correct_answer, options, category) VALUES
('What mammals is this?', 'img/kucing.png', 'cat', '["cat","dog","cow","ant"]', 'mammals'),
('What animal has a long trunk?', 'img/elephant.png', 'elephant', '["elephant","dog","cow","cat"]', 'mammals');
```

---

## Table: user_progress

Tracks user learning progress, level, and statistics.

### Schema

```sql
CREATE TABLE user_progress (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    level INT NOT NULL DEFAULT 1,
    xp INT NOT NULL DEFAULT 0,
    total_quizzes_completed INT NOT NULL DEFAULT 0,
    correct_answers INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id)
);
```

### Columns

| Column                  | Type            | Nullable | Default        | Description                    |
| ----------------------- | --------------- | -------- | -------------- | ------------------------------ |
| id                      | BIGINT UNSIGNED | No       | AUTO_INCREMENT | Primary key                    |
| user_id                 | BIGINT UNSIGNED | No       | -              | Foreign key to users table     |
| level                   | INT             | No       | 1              | User's current level           |
| xp                      | INT             | No       | 0              | User's total experience points |
| total_quizzes_completed | INT             | No       | 0              | Total quizzes answered         |
| correct_answers         | INT             | No       | 0              | Total correct answers          |
| created_at              | TIMESTAMP       | Yes      | NULL           | Creation timestamp             |
| updated_at              | TIMESTAMP       | Yes      | NULL           | Last update timestamp          |

### Indexes

-   Primary Key: `id`
-   Foreign Key: `user_id` → users(id)
-   Index: `idx_user_id`

### Constraints

-   `ON DELETE CASCADE` - When user is deleted, progress is also deleted

### Business Logic

**Level Calculation:**

```
level = floor(xp / 100) + 1
```

**XP Rewards:**

-   Correct answer: +10 XP
-   Wrong answer: 0 XP

**Accuracy Calculation:**

```
accuracy = (correct_answers / total_quizzes_completed) * 100
```

### Sample Data

```sql
INSERT INTO user_progress (user_id, level, xp, total_quizzes_completed, correct_answers) VALUES
(1, 3, 250, 30, 25),  -- Budi: Level 3, 250 XP, 83.33% accuracy
(2, 1, 50, 5, 5);     -- Siti: Level 1, 50 XP, 100% accuracy
```

---

## Laravel System Tables

### cache

Stores application cache data.

```sql
CREATE TABLE cache (
    key VARCHAR(255) PRIMARY KEY,
    value MEDIUMTEXT NOT NULL,
    expiration INT NOT NULL,
    INDEX idx_expiration (expiration)
);
```

### cache_locks

Stores cache lock information.

```sql
CREATE TABLE cache_locks (
    key VARCHAR(255) PRIMARY KEY,
    owner VARCHAR(255) NOT NULL,
    expiration INT NOT NULL,
    INDEX idx_expiration (expiration)
);
```

### jobs

Stores queued jobs.

```sql
CREATE TABLE jobs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    queue VARCHAR(255) NOT NULL,
    payload LONGTEXT NOT NULL,
    attempts TINYINT UNSIGNED NOT NULL,
    reserved_at INT UNSIGNED NULL,
    available_at INT UNSIGNED NOT NULL,
    created_at INT UNSIGNED NOT NULL,
    INDEX idx_queue (queue)
);
```

### sessions

Stores user session data.

```sql
CREATE TABLE sessions (
    id VARCHAR(255) PRIMARY KEY,
    user_id BIGINT UNSIGNED NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    payload LONGTEXT NOT NULL,
    last_activity INT NOT NULL,
    INDEX idx_user_id (user_id),
    INDEX idx_last_activity (last_activity)
);
```

---

## Entity Relationship Diagram

```
┌─────────────────┐
│     users       │
├─────────────────┤
│ id (PK)         │
│ name            │
│ email (UNIQUE)  │
│ password        │
│ avatar          │
└────────┬────────┘
         │ 1
         │
         │ has one
         │
         │ 1
┌────────▼────────┐
│ user_progress   │
├─────────────────┤
│ id (PK)         │
│ user_id (FK)    │
│ level           │
│ xp              │
│ quizzes_done    │
│ correct_answers │
└─────────────────┘

┌─────────────────┐
│    animals      │
├─────────────────┤
│ id (PK)         │
│ name            │
│ category        │
│ description     │
│ image_path      │
│ sound_path      │
└─────────────────┘

┌─────────────────┐
│ quiz_questions  │
├─────────────────┤
│ id (PK)         │
│ question        │
│ image_path      │
│ correct_answer  │
│ options (JSON)  │
│ category        │
└─────────────────┘
```

---

## Database Queries Examples

### Get user with progress

```sql
SELECT u.*, up.level, up.xp, up.total_quizzes_completed, up.correct_answers
FROM users u
LEFT JOIN user_progress up ON u.id = up.user_id
WHERE u.id = 1;
```

### Get animals by category

```sql
SELECT * FROM animals
WHERE category = 'mammals'
ORDER BY name ASC;
```

### Get random quiz question

```sql
SELECT * FROM quiz_questions
WHERE category = 'mammals'
ORDER BY RAND()
LIMIT 1;
```

### Calculate user accuracy

```sql
SELECT
    u.name,
    up.level,
    up.xp,
    up.total_quizzes_completed,
    up.correct_answers,
    ROUND((up.correct_answers / up.total_quizzes_completed * 100), 2) as accuracy
FROM users u
JOIN user_progress up ON u.id = up.user_id
WHERE up.total_quizzes_completed > 0;
```

### Get top 10 users by level and XP

```sql
SELECT u.name, u.avatar, up.level, up.xp
FROM users u
JOIN user_progress up ON u.id = up.user_id
ORDER BY up.level DESC, up.xp DESC
LIMIT 10;
```

---

## Backup & Restore

### Backup Database

**MySQL:**

```bash
mysqldump -u root -p kidslearn > backup_kidslearn.sql
```

**SQLite:**

```bash
sqlite3 database/database.sqlite .dump > backup_kidslearn.sql
```

### Restore Database

**MySQL:**

```bash
mysql -u root -p kidslearn < backup_kidslearn.sql
```

**SQLite:**

```bash
sqlite3 database/database.sqlite < backup_kidslearn.sql
```

---

## Performance Optimization

### Recommended Indexes

Already implemented:

-   `users.email` (UNIQUE)
-   `animals.category`
-   `quiz_questions.category`
-   `user_progress.user_id` (FK)

### Query Optimization Tips

1. Use indexes for frequently queried columns
2. Avoid SELECT \* when possible
3. Use LIMIT for pagination
4. Cache frequently accessed data
5. Use EXPLAIN to analyze queries

### Example with EXPLAIN

```sql
EXPLAIN SELECT * FROM animals WHERE category = 'mammals';
```

---

## Migration Files

Migrations are located in `database/migrations/`:

1. `0001_01_01_000000_create_users_table.php` - Default Laravel users table
2. `2024_12_15_000001_create_animals_table.php` - Animals table
3. `2024_12_15_000002_create_quiz_questions_table.php` - Quiz questions
4. `2024_12_15_000003_create_user_progress_table.php` - User progress
5. `2024_12_15_000004_add_avatar_to_users_table.php` - Add avatar column

---

## Seeder Files

Seeders are located in `database/seeders/`:

1. `UserSeeder.php` - Seed demo users
2. `AnimalSeeder.php` - Seed animals data
3. `QuizQuestionSeeder.php` - Seed quiz questions
4. `DatabaseSeeder.php` - Main seeder (calls all seeders)

---

## Future Enhancements

Potential database improvements:

1. **Add table: categories**

    - Store category information separately
    - Add category icons and descriptions

2. **Add table: user_achievements**

    - Track user achievements and badges
    - Gamification elements

3. **Add table: learning_sessions**

    - Track learning sessions
    - Analytics data

4. **Add table: quiz_attempts**

    - Store individual quiz attempts
    - Detailed analytics

5. **Add full-text search**
    - Enable searching animals by description
    - Faster search functionality

---

**Last Updated:** December 15, 2025

**Schema Version:** 1.0.0
