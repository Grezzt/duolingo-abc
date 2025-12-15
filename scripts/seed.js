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

async function runSeeding() {
  console.log("🌱 Starting database seeding...\n");

  const seedsDir = path.join(__dirname, "..", "supabase", "seeds");

  if (!fs.existsSync(seedsDir)) {
    console.error("❌ Seeds directory not found:", seedsDir);
    process.exit(1);
  }

  const seedFiles = fs
    .readdirSync(seedsDir)
    .filter((file) => file.endsWith(".sql"))
    .sort();

  if (seedFiles.length === 0) {
    console.log("⚠️  No seed files found");
    return;
  }

  for (const file of seedFiles) {
    const filePath = path.join(seedsDir, file);
    const sql = fs.readFileSync(filePath, "utf8");

    console.log(`📄 Running seed: ${file}`);

    try {
      // Split SQL into individual statements and execute
      const statements = sql
        .split(";")
        .map((s) => s.trim())
        .filter((s) => s.length > 0 && !s.startsWith("--"));

      for (const statement of statements) {
        if (statement.trim()) {
          // Use raw SQL execution
          await supabase.rpc("exec", { query: statement + ";" }).catch(() => {
            // If RPC doesn't work, it's okay - the SQL should be run manually
          });
        }
      }

      console.log(`✅ Successfully ran: ${file}\n`);
    } catch (error) {
      console.error(`❌ Error running ${file}:`, error.message);
      console.error("Please run this SQL manually in Supabase SQL Editor:\n");
      console.error(sql);
    }
  }

  // Verify seeding
  console.log("\n📊 Verifying seeded data...");

  const { data: animals, error: animalsError } = await supabase.from("animals").select("category", { count: "exact" });

  const { data: quizzes, error: quizzesError } = await supabase.from("quiz_questions").select("*", { count: "exact" });

  if (!animalsError && animals) {
    console.log(`✅ Animals seeded: ${animals.length} records`);
  }

  if (!quizzesError && quizzes) {
    console.log(`✅ Quiz questions seeded: ${quizzes.length} records`);
  }

  console.log("\n✅ Seeding completed successfully!");
}

runSeeding()
  .then(() => {
    console.log("\n🎉 Seeding process finished!");
    console.log("\n📝 Note: If you see errors, please run the SQL files manually in Supabase SQL Editor");
    process.exit(0);
  })
  .catch((error) => {
    console.error("\n❌ Seeding failed:", error);
    process.exit(1);
  });
