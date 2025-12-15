const { createClient } = require("@supabase/supabase-js");
require("dotenv").config({ path: ".env.local" });

const supabaseUrl = process.env.NEXT_PUBLIC_SUPABASE_URL;
const supabaseServiceKey = process.env.SUPABASE_SERVICE_ROLE_KEY;

if (!supabaseUrl || !supabaseServiceKey) {
  console.error("❌ Missing Supabase credentials");
  process.exit(1);
}

const supabase = createClient(supabaseUrl, supabaseServiceKey);

async function resetDatabase() {
  console.log("⚠️  WARNING: This will delete ALL data from the database!");
  console.log("🗑️  Resetting database...\n");

  const tables = ["user_progress", "quiz_questions", "animals", "users"];

  for (const table of tables) {
    console.log(`🗑️  Clearing ${table}...`);
    const { error } = await supabase.from(table).delete().neq("id", "00000000-0000-0000-0000-000000000000"); // Delete all

    if (error) {
      console.error(`❌ Error clearing ${table}:`, error.message);
    } else {
      console.log(`✅ Cleared ${table}`);
    }
  }

  console.log("\n✅ Database reset complete!");
  console.log('💡 Run "npm run migrate" and "npm run seed" to repopulate');
}

resetDatabase()
  .then(() => process.exit(0))
  .catch((error) => {
    console.error("❌ Reset failed:", error);
    process.exit(1);
  });
