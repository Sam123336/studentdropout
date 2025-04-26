# Fix Migration Order for Foreign Keys

To resolve your migration error, rename the migration files so the `posts` table is created before any migration that references it.

---

### 1. **Rename Migration Files**

Move or rename these two files as follows:

**Old:**
- `/home/sambit/student-dropout/database/migrations/2025_04_21_074254_create_posts_table.php`
- `/home/sambit/student-dropout/database/migrations/2023_08_20_000000_create_blog_likes_table.php`

**New:**

Rename `2025_04_21_074254_create_posts_table.php` to come BEFORE the `blog_likes` migration.  
You can do this by changing its date to, for example, one day earlier than `2023_08_20_000000`:

```bash
mv database/migrations/2025_04_21_074254_create_posts_table.php database/migrations/2023_08_19_000000_create_posts_table.php
```

(Or, you can just pick a date/time so that the `posts` migration comes first.)

---

### 2. **Run Migrations Again**

Run the following Artisan command to drop all tables and re-run migrations in the correct order:

```bash
php artisan migrate:fresh
```

---

**Result:**  
- The `posts` table will be created before any table that references it (like `blog_likes`).
- Your migration will now succeed with no foreign key errors.

---