const { createClient } = require("@supabase/supabase-js");
const fs = require("fs");
const path = require("path");
require("dotenv").config({ path: ".env.local" });

const supabaseUrl = process.env.NEXT_PUBLIC_SUPABASE_URL;
const supabaseServiceKey = process.env.SUPABASE_SERVICE_ROLE_KEY;

if (!supabaseUrl || !supabaseServiceKey) {
  console.error("❌ Missing Supabase credentials in .env.local");
  console.error("Required variables:");
  console.error("  - NEXT_PUBLIC_SUPABASE_URL");
  console.error("  - SUPABASE_SERVICE_ROLE_KEY");
  process.exit(1);
}

const supabase = createClient(supabaseUrl, supabaseServiceKey);

async function runMigrations() {
  console.log("🚀 Starting database migration...\n");

  const migrationsDir = path.join(__dirname, "..", "supabase", "migrations");

  if (!fs.existsSync(migrationsDir)) {
    console.error("❌ Migrations directory not found:", migrationsDir);
    process.exit(1);
  }

  const migrationFiles = fs
    .readdirSync(migrationsDir)
    .filter((file) => file.endsWith(".sql"))
    .sort();

  if (migrationFiles.length === 0) {
    console.log("⚠️  No migration files found");
    return;
  }

  for (const file of migrationFiles) {
    const filePath = path.join(migrationsDir, file);
    const sql = fs.readFileSync(filePath, "utf8");

    console.log(`📄 Running migration: ${file}`);

    try {
      const { error } = await supabase.rpc("exec_sql", { sql });

      if (error) {
        // Try direct execution if RPC fails
        const statements = sql.split(";").filter((s) => s.trim());
        for (const statement of statements) {
          if (statement.trim()) {
            const { error: execError } = await supabase.rpc("exec", {
              query: statement,
            });
            if (execError) throw execError;
          }
        }
      }

      console.log(`✅ Successfully ran: ${file}\n`);
    } catch (error) {
      console.error(`❌ Error running ${file}:`, error.message);
      console.error("Please run this SQL manually in Supabase SQL Editor:\n");
      console.error(sql);
      process.exit(1);
    }
  }

  console.log("✅ All migrations completed successfully!");
}

runMigrations()
  .then(() => {
    console.log("\n🎉 Migration process finished!");
    process.exit(0);
  })
  .catch((error) => {
    console.error("\n❌ Migration failed:", error);
    process.exit(1);
  });
