-- Disable Row-Level Security and Create Permissive Policies
-- This allows all operations without authentication requirements

-- Drop existing policies
DROP POLICY IF EXISTS "Users can view own data" ON users;
DROP POLICY IF EXISTS "Users can update own data" ON users;
DROP POLICY IF EXISTS "Animals are publicly readable" ON animals;
DROP POLICY IF EXISTS "Quiz questions are publicly readable" ON quiz_questions;
DROP POLICY IF EXISTS "Users can view own progress" ON user_progress;
DROP POLICY IF EXISTS "Users can insert own progress" ON user_progress;
DROP POLICY IF EXISTS "Users can update own progress" ON user_progress;

-- Create permissive policies that allow all operations
-- Users table - allow all operations
CREATE POLICY "Allow all operations on users" ON users
  FOR ALL USING (true) WITH CHECK (true);

-- Animals table - allow all operations
CREATE POLICY "Allow all operations on animals" ON animals
  FOR ALL USING (true) WITH CHECK (true);

-- Quiz questions table - allow all operations
CREATE POLICY "Allow all operations on quiz_questions" ON quiz_questions
  FOR ALL USING (true) WITH CHECK (true);

-- User progress table - allow all operations
CREATE POLICY "Allow all operations on user_progress" ON user_progress
  FOR ALL USING (true) WITH CHECK (true);

-- Ensure all permissions are granted
GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO anon, authenticated, service_role;
GRANT ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA public TO anon, authenticated, service_role;
GRANT ALL PRIVILEGES ON ALL FUNCTIONS IN SCHEMA public TO anon, authenticated, service_role;
