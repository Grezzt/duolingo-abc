# 🤝 Contributing to KidsLearn

First off, thank you for considering contributing to KidsLearn! It's people like you that make KidsLearn such a great tool for children's education.

---

## 📋 Table of Contents

1. [Code of Conduct](#code-of-conduct)
2. [How Can I Contribute?](#how-can-i-contribute)
3. [Development Setup](#development-setup)
4. [Pull Request Process](#pull-request-process)
5. [Coding Standards](#coding-standards)
6. [Commit Messages](#commit-messages)
7. [Testing](#testing)
8. [Documentation](#documentation)

---

## Code of Conduct

### Our Pledge

We pledge to make participation in our project a harassment-free experience for everyone, regardless of age, body size, disability, ethnicity, gender identity and expression, level of experience, nationality, personal appearance, race, religion, or sexual identity and orientation.

### Our Standards

**Positive behavior includes:**

-   Using welcoming and inclusive language
-   Being respectful of differing viewpoints
-   Gracefully accepting constructive criticism
-   Focusing on what is best for the community
-   Showing empathy towards other community members

**Unacceptable behavior includes:**

-   Trolling, insulting/derogatory comments, and personal attacks
-   Public or private harassment
-   Publishing others' private information without permission
-   Other conduct which could reasonably be considered inappropriate

---

## How Can I Contribute?

### 🐛 Reporting Bugs

Before creating bug reports, please check the existing issues to avoid duplicates.

**When submitting a bug report, include:**

-   Clear and descriptive title
-   Steps to reproduce the behavior
-   Expected behavior
-   Actual behavior
-   Screenshots (if applicable)
-   Environment details (OS, PHP version, Laravel version)

**Bug Report Template:**

```markdown
**Description:**
A clear description of the bug.

**Steps to Reproduce:**

1. Go to '...'
2. Click on '...'
3. Scroll down to '...'
4. See error

**Expected Behavior:**
What you expected to happen.

**Actual Behavior:**
What actually happened.

**Screenshots:**
If applicable, add screenshots.

**Environment:**

-   OS: [e.g., Windows 11, Ubuntu 22.04]
-   PHP Version: [e.g., 8.2.0]
-   Laravel Version: [e.g., 12.0]
-   Browser: [e.g., Chrome 120]
```

---

### ✨ Suggesting Enhancements

**Enhancement suggestions should include:**

-   Clear and descriptive title
-   Detailed description of the proposed feature
-   Why this enhancement would be useful
-   Possible implementation approach

**Enhancement Template:**

```markdown
**Feature Description:**
A clear description of what you want to happen.

**Use Case:**
Explain why this feature would be useful.

**Possible Implementation:**
How you think this could be implemented.

**Alternatives:**
Any alternative solutions you've considered.
```

---

### 🔨 Contributing Code

**Areas where we need help:**

-   Adding more animal categories
-   Improving UI/UX for kids
-   Adding more quiz questions
-   Implementing new features
-   Fixing bugs
-   Writing tests
-   Improving documentation
-   Translating content

---

## Development Setup

### Prerequisites

-   PHP 8.2+
-   Composer
-   MySQL/SQLite
-   Node.js 18+
-   Git

### Setup Steps

1. **Fork the repository**

    ```bash
    # Fork on GitHub, then clone your fork
    git clone https://github.com/YOUR-USERNAME/kidslearn-laravel.git
    cd kidslearn-laravel
    ```

2. **Add upstream remote**

    ```bash
    git remote add upstream https://github.com/kidslearn/kidslearn-laravel.git
    ```

3. **Install dependencies**

    ```bash
    composer install
    npm install
    ```

4. **Setup environment**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

5. **Setup database**

    ```bash
    php artisan migrate
    php artisan db:seed
    ```

6. **Run development server**
    ```bash
    php artisan serve
    npm run dev
    ```

---

## Pull Request Process

### Before Submitting

-   [ ] Code follows the project's coding standards
-   [ ] All tests pass
-   [ ] New tests added for new features
-   [ ] Documentation updated
-   [ ] Commit messages follow guidelines
-   [ ] No merge conflicts with main branch

### Submission Steps

1. **Create a new branch**

    ```bash
    git checkout -b feature/amazing-feature
    # or
    git checkout -b fix/bug-description
    ```

2. **Make your changes**

    ```bash
    # Make your code changes
    git add .
    git commit -m "Add amazing feature"
    ```

3. **Keep your fork updated**

    ```bash
    git fetch upstream
    git rebase upstream/main
    ```

4. **Push to your fork**

    ```bash
    git push origin feature/amazing-feature
    ```

5. **Create Pull Request**
    - Go to GitHub and create a pull request
    - Fill in the PR template
    - Link related issues

### Pull Request Template

```markdown
## Description

Brief description of changes.

## Type of Change

-   [ ] Bug fix
-   [ ] New feature
-   [ ] Breaking change
-   [ ] Documentation update

## Related Issues

Fixes #(issue number)

## Testing

-   [ ] Tested locally
-   [ ] Added new tests
-   [ ] All tests pass

## Screenshots (if applicable)

Add screenshots here.

## Checklist

-   [ ] Code follows style guidelines
-   [ ] Self-review completed
-   [ ] Commented code (if needed)
-   [ ] Documentation updated
-   [ ] No new warnings
-   [ ] Tests added/updated
```

---

## Coding Standards

### PHP Code Style

Follow **PSR-12** coding standard:

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExampleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $items = Item::all();

        return view('items.index', compact('items'));
    }

    /**
     * Store a newly created resource.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
        ]);

        Item::create($validated);

        return redirect()->route('items.index')
            ->with('success', 'Item created successfully');
    }
}
```

### Laravel Best Practices

**Controllers:**

-   Keep controllers thin
-   Use form requests for validation
-   Return appropriate response types

**Models:**

-   Use Eloquent relationships
-   Add appropriate fillable/guarded properties
-   Use accessors and mutators when needed

**Routes:**

-   Use resource routes when possible
-   Group related routes
-   Apply middleware appropriately

**Views:**

-   Use Blade components for reusable UI
-   Keep logic minimal in views
-   Use @yield and @section properly

### JavaScript Code Style

```javascript
// Use const/let, not var
const userName = "John";
let score = 0;

// Use arrow functions
const calculateScore = (points) => {
    return points * 10;
};

// Use template literals
const message = `Welcome ${userName}!`;

// Use async/await
const fetchData = async () => {
    try {
        const response = await fetch("/api/data");
        const data = await response.json();
        return data;
    } catch (error) {
        console.error("Error:", error);
    }
};
```

### CSS Code Style

```css
/* Use meaningful class names */
.learning-card {
    padding: 20px;
    border-radius: 10px;
}

/* Group related properties */
.button {
    /* Display & Box Model */
    display: inline-block;
    padding: 10px 20px;
    margin: 10px 0;

    /* Visual */
    background: #667eea;
    border: none;
    border-radius: 8px;

    /* Text */
    color: white;
    font-size: 16px;

    /* Other */
    cursor: pointer;
    transition: all 0.3s;
}
```

---

## Commit Messages

### Format

```
<type>(<scope>): <subject>

<body>

<footer>
```

### Types

-   `feat`: New feature
-   `fix`: Bug fix
-   `docs`: Documentation changes
-   `style`: Code style changes (formatting)
-   `refactor`: Code refactoring
-   `test`: Adding or updating tests
-   `chore`: Maintenance tasks

### Examples

```bash
# Feature
feat(learning): add reptiles category

# Bug fix
fix(quiz): correct answer validation logic

# Documentation
docs(api): update authentication endpoints

# Refactor
refactor(controllers): simplify quiz logic

# Test
test(auth): add login validation tests

# Chore
chore(deps): update Laravel to 12.1
```

### Good Commit Messages

✅ **Good:**

```
feat(quiz): add timer functionality

- Add 30-second timer for each question
- Display time remaining
- Auto-submit when time runs out
- Update quiz statistics

Closes #123
```

❌ **Bad:**

```
fixed stuff
```

---

## Testing

### Running Tests

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/AuthTest.php

# Run with coverage
php artisan test --coverage
```

### Writing Tests

**Feature Test Example:**

```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{
    public function test_user_can_login(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'name' => $user->name,
            'password' => 'password123',
        ]);

        $response->assertStatus(200);
        $this->assertAuthenticatedAs($user);
    }
}
```

**Unit Test Example:**

```php
<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\UserProgress;

class UserProgressTest extends TestCase
{
    public function test_level_calculation(): void
    {
        $progress = new UserProgress(['xp' => 250]);

        $this->assertEquals(3, $progress->level);
    }
}
```

---

## Documentation

### Code Comments

**Document:**

-   Complex logic
-   Non-obvious decisions
-   API endpoints
-   Model relationships

**Don't document:**

-   Obvious code
-   What the code does (code should be self-explanatory)

**Example:**

```php
// ✅ Good
/**
 * Calculate user's level based on XP.
 * Level increases every 100 XP.
 * Formula: level = floor(xp / 100) + 1
 */
public function calculateLevel(int $xp): int
{
    return floor($xp / 100) + 1;
}

// ❌ Bad
/**
 * This function adds two numbers
 */
public function add(int $a, int $b): int
{
    return $a + $b; // Return the sum
}
```

### README Updates

When adding new features, update:

-   Features list
-   Usage examples
-   Configuration options
-   Screenshots (if UI changes)

### API Documentation

Update `API_DOCUMENTATION.md` when:

-   Adding new endpoints
-   Changing request/response format
-   Updating parameters
-   Modifying error codes

---

## Review Process

### What We Look For

**Code Quality:**

-   Follows coding standards
-   No code duplication
-   Proper error handling
-   Security considerations

**Functionality:**

-   Works as intended
-   No breaking changes (unless discussed)
-   Edge cases handled

**Testing:**

-   Adequate test coverage
-   Tests pass
-   No breaking existing tests

**Documentation:**

-   Code is well-commented
-   README updated (if needed)
-   API docs updated (if needed)

### Review Timeline

-   Initial review: Within 3 days
-   Follow-up reviews: Within 2 days
-   Minor fixes: May be merged immediately

---

## Getting Help

### Resources

-   **Documentation:** See README.md and other docs
-   **Laravel Docs:** https://laravel.com/docs
-   **Stack Overflow:** Tag your question with `laravel` and `kidslearn`

### Contact

-   **GitHub Issues:** For bugs and features
-   **Email:** dev@kidslearn.com
-   **Discord:** (if available)

---

## Recognition

Contributors will be:

-   Listed in CONTRIBUTORS.md
-   Mentioned in release notes
-   Given credit in documentation

---

## License

By contributing, you agree that your contributions will be licensed under the MIT License.

---

Thank you for contributing to KidsLearn! Together, we can make learning fun for children everywhere! 🎉🚀

---

**Last Updated:** December 15, 2025
