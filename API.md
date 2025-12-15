# KidsLearn API Documentation

Complete API reference for KidsLearn services and database operations.

## Table of Contents

- [Authentication API](#authentication-api)
- [Animal API](#animal-api)
- [Quiz API](#quiz-api)
- [Progress API](#progress-api)
- [Database Direct Queries](#database-direct-queries)

---

## Authentication API

### `authService.register()`

Register a new user account.

**Parameters:**

```typescript
{
  name: string; // Username (unique, 3-100 characters)
  password: string; // Password (min 4 characters)
  avatar: string; // Avatar URL/path
}
```

**Returns:**

```typescript
{
  id: string;
  name: string;
  avatar: string;
  level: number; // Always 1 for new users
  experience: number; // Always 0 for new users
}
```

**Errors:**

- `"Username already exists"` - Username is taken
- `"Registration failed"` - General error

**Example:**

```typescript
try {
  const user = await authService.register({
    name: "johndoe",
    password: "secure123",
    avatar: "/img/avatar1.png",
  });
  console.log("Registered:", user.name);
} catch (error) {
  console.error(error.message);
}
```

---

### `authService.login()`

Authenticate a user and retrieve their data.

**Parameters:**

```typescript
{
  name: string; // Username
  password: string; // Password
}
```

**Returns:**

```typescript
{
  id: string;
  name: string;
  avatar: string;
  level: number;
  experience: number;
}
```

**Errors:**

- `"Invalid username or password"` - Wrong credentials
- `"Login failed"` - General error

**Example:**

```typescript
try {
  const user = await authService.login({
    name: "johndoe",
    password: "secure123",
  });
  console.log("Logged in:", user.name, "Level:", user.level);
} catch (error) {
  console.error(error.message);
}
```

---

### `authService.updateUser()`

Update user profile information.

**Parameters:**

```typescript
userId: string;
updates: {
  name?: string;      // New username
  password?: string;  // New password
  avatar?: string;    // New avatar
}
```

**Returns:**

```typescript
{
  id: string;
  name: string;
  avatar: string;
  level: number;
  experience: number;
}
```

**Example:**

```typescript
const updated = await authService.updateUser(userId, {
  avatar: "/img/avatar2.png",
});
```

---

## Animal API

### `animalService.getAnimalsByCategory()`

Fetch all animals in a specific category.

**Parameters:**

```typescript
category: string; // 'mammals' | 'birds' | 'sea' | 'insects' | 'reptiles' | 'amphibians'
```

**Returns:**

```typescript
Animal[] = [{
  id: string;
  name: string;
  category: string;
  description: string;
  image_url: string;
  sound_url: string;
  fun_facts: string[];
}]
```

**Example:**

```typescript
const mammals = await animalService.getAnimalsByCategory("mammals");
console.log(`Found ${mammals.length} mammals`);

mammals.forEach((animal) => {
  console.log(`${animal.name}: ${animal.description}`);
});
```

---

### `animalService.getAllAnimals()`

Fetch all animals from all categories.

**Returns:**

```typescript
Animal[] = [{
  id: string;
  name: string;
  category: string;
  description: string;
  image_url: string;
  sound_url: string;
  fun_facts: string[];
}]
```

**Example:**

```typescript
const allAnimals = await animalService.getAllAnimals();
console.log(`Total animals: ${allAnimals.length}`);

// Group by category
const grouped = allAnimals.reduce((acc, animal) => {
  acc[animal.category] = acc[animal.category] || [];
  acc[animal.category].push(animal);
  return acc;
}, {});
```

---

### `animalService.getAnimalById()`

Fetch a specific animal by its ID.

**Parameters:**

```typescript
id: string; // UUID of the animal
```

**Returns:**

```typescript
Animal | null = {
  id: string;
  name: string;
  category: string;
  description: string;
  image_url: string;
  sound_url: string;
  fun_facts: string[];
}
```

**Example:**

```typescript
const animal = await animalService.getAnimalById(animalId);
if (animal) {
  console.log(animal.name);
  console.log(animal.fun_facts.join("\n"));
}
```

---

## Quiz API

### `quizService.getQuizzesByCategory()`

Get all quiz questions for a specific category.

**Parameters:**

```typescript
category: string; // Animal category
```

**Returns:**

```typescript
QuizQuestion[] = [{
  id: string;
  question: string;
  category: string;
  correct_answer: string;
  options: string[];       // Array of answer options
  image_url: string;
  difficulty: string;      // 'easy' | 'medium' | 'hard'
}]
```

**Example:**

```typescript
const quizzes = await quizService.getQuizzesByCategory("mammals");
console.log(`${quizzes.length} quiz questions available`);

const easyQuizzes = quizzes.filter((q) => q.difficulty === "easy");
```

---

### `quizService.getRandomQuiz()`

Get a random quiz question, optionally filtered by category.

**Parameters:**

```typescript
category?: string  // Optional category filter
```

**Returns:**

```typescript
QuizQuestion | null = {
  id: string;
  question: string;
  category: string;
  correct_answer: string;
  options: string[];
  image_url: string;
  difficulty: string;
}
```

**Example:**

```typescript
// Random quiz from any category
const randomQuiz = await quizService.getRandomQuiz();

// Random quiz from mammals only
const mammalsQuiz = await quizService.getRandomQuiz("mammals");

if (randomQuiz) {
  console.log(randomQuiz.question);
  console.log("Options:", randomQuiz.options);
}
```

---

## Progress API

### `progressService.getUserProgress()`

Get all progress records for a user.

**Parameters:**

```typescript
userId: string; // User UUID
```

**Returns:**

```typescript
UserProgress[] = [{
  id: string;
  user_id: string;
  category: string;
  completed_animals: string[];  // Array of completed animal names
  quiz_score: number;
  last_activity: string;        // ISO timestamp
}]
```

**Example:**

```typescript
const progress = await progressService.getUserProgress(userId);

progress.forEach((p) => {
  console.log(`${p.category}: ${p.completed_animals.length} completed`);
  console.log(`Quiz score: ${p.quiz_score}`);
});
```

---

### `progressService.updateProgress()`

Update or create progress for a category.

**Parameters:**

```typescript
userId: string;
category: string;
updates: {
  completed_animals?: string[];
  quiz_score?: number;
}
```

**Returns:**

```typescript
void
```

**Example:**

```typescript
await progressService.updateProgress(userId, "mammals", {
  completed_animals: ["Dog", "Cat", "Elephant"],
  quiz_score: 85,
});
```

---

### `progressService.markAnimalCompleted()`

Mark an animal as completed (learning finished).

**Parameters:**

```typescript
userId: string;
category: string;
animalName: string;
```

**Returns:**

```typescript
void
```

**Example:**

```typescript
await progressService.markAnimalCompleted(userId, "mammals", "Elephant");
```

---

## Database Direct Queries

### Supabase Client Usage

```typescript
import { supabase } from "@/lib/supabase";

// Select
const { data, error } = await supabase.from("animals").select("*").eq("category", "mammals");

// Insert
const { data, error } = await supabase
  .from("users")
  .insert([{ name: "john", password_hash: "hash", avatar: "/img/avatar1.png" }])
  .select();

// Update
const { data, error } = await supabase.from("users").update({ level: 5 }).eq("id", userId);

// Delete
const { error } = await supabase.from("user_progress").delete().eq("user_id", userId);
```

---

## Response Codes & Error Handling

### Success Responses

- `200` - Operation successful
- `201` - Resource created

### Error Responses

- `400` - Bad request (validation error)
- `401` - Unauthorized
- `404` - Resource not found
- `500` - Server error

### Error Handling Pattern

```typescript
try {
  const result = await service.method();
  // Handle success
} catch (error: any) {
  if (error.message.includes("not found")) {
    // Handle not found
  } else if (error.message.includes("already exists")) {
    // Handle duplicate
  } else {
    // Handle general error
  }
  console.error(error.message);
}
```

---

## Rate Limits

Supabase Free Tier Limits:

- 500MB database space
- 50,000 monthly active users
- 2GB bandwidth per month
- 500MB file storage

---

## Best Practices

### 1. Error Handling

Always wrap service calls in try-catch blocks.

### 2. Loading States

Show loading indicators during async operations.

### 3. Caching

Store frequently accessed data in state/local storage.

### 4. Optimistic Updates

Update UI immediately, revert on error.

### 5. Batch Operations

Combine multiple queries when possible.

---

## Examples

### Complete User Flow

```typescript
// Registration -> Login -> Load Animals -> Play Quiz

// 1. Register
const user = await authService.register({
  name: "learner1",
  password: "pass123",
  avatar: "/img/avatar1.png",
});

// 2. Login (in next session)
const loggedUser = await authService.login({
  name: "learner1",
  password: "pass123",
});

// 3. Load animals
const animals = await animalService.getAnimalsByCategory("mammals");

// 4. Play quiz
const quiz = await quizService.getRandomQuiz("mammals");

// 5. Update progress
await progressService.updateProgress(user.id, "mammals", {
  quiz_score: 10,
});
```

---

## Testing

### Test Authentication

```typescript
// test/auth.test.ts
describe("Authentication", () => {
  it("should register new user", async () => {
    const user = await authService.register({
      name: "test_" + Date.now(),
      password: "test123",
      avatar: "/img/avatar1.png",
    });
    expect(user.name).toBeDefined();
    expect(user.level).toBe(1);
  });
});
```

---

For more information, see [README.md](README.md) or [QUICKSTART.md](QUICKSTART.md).
