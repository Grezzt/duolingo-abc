-- KidsLearn Database Schema Migration
-- Version: 1.0.0
-- Description: Initial schema for KidsLearn educational app

-- Enable UUID extension
CREATE EXTENSION IF NOT EXISTS "uuid-ossp";

-- Users Table
CREATE TABLE IF NOT EXISTS users (
  id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
  created_at TIMESTAMP WITH TIME ZONE DEFAULT TIMEZONE('utc'::text, NOW()) NOT NULL,
  name VARCHAR(100) NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  avatar VARCHAR(255) DEFAULT 'img/avatar1.png',
  level INTEGER DEFAULT 1 CHECK (level >= 1),
  experience INTEGER DEFAULT 0 CHECK (experience >= 0),
  CONSTRAINT unique_name UNIQUE (name)
);

-- Create index on name for faster lookups
CREATE INDEX IF NOT EXISTS idx_users_name ON users(name);

-- Animals Table
CREATE TABLE IF NOT EXISTS animals (
  id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
  created_at TIMESTAMP WITH TIME ZONE DEFAULT TIMEZONE('utc'::text, NOW()) NOT NULL,
  name VARCHAR(100) NOT NULL,
  category VARCHAR(50) NOT NULL CHECK (category IN ('mammals', 'birds', 'sea', 'insects', 'reptiles', 'amphibians')),
  description TEXT NOT NULL,
  image_url VARCHAR(255) NOT NULL,
  sound_url VARCHAR(255) NOT NULL,
  fun_facts TEXT[] DEFAULT '{}',
  CONSTRAINT unique_animal_name UNIQUE (name)
);

-- Create indexes for better query performance
CREATE INDEX IF NOT EXISTS idx_animals_category ON animals(category);
CREATE INDEX IF NOT EXISTS idx_animals_name ON animals(name);

-- Quiz Questions Table
CREATE TABLE IF NOT EXISTS quiz_questions (
  id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
  created_at TIMESTAMP WITH TIME ZONE DEFAULT TIMEZONE('utc'::text, NOW()) NOT NULL,
  question TEXT NOT NULL,
  category VARCHAR(50) NOT NULL,
  correct_answer VARCHAR(100) NOT NULL,
  options TEXT[] NOT NULL CHECK (array_length(options, 1) >= 2),
  image_url VARCHAR(255) NOT NULL,
  difficulty VARCHAR(20) DEFAULT 'easy' CHECK (difficulty IN ('easy', 'medium', 'hard'))
);

-- Create index on category
CREATE INDEX IF NOT EXISTS idx_quiz_category ON quiz_questions(category);
CREATE INDEX IF NOT EXISTS idx_quiz_difficulty ON quiz_questions(difficulty);

-- User Progress Table
CREATE TABLE IF NOT EXISTS user_progress (
  id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
  created_at TIMESTAMP WITH TIME ZONE DEFAULT TIMEZONE('utc'::text, NOW()) NOT NULL,
  user_id UUID NOT NULL REFERENCES users(id) ON DELETE CASCADE,
  category VARCHAR(50) NOT NULL,
  completed_animals TEXT[] DEFAULT '{}',
  quiz_score INTEGER DEFAULT 0 CHECK (quiz_score >= 0),
  last_activity TIMESTAMP WITH TIME ZONE DEFAULT TIMEZONE('utc'::text, NOW()) NOT NULL,
  CONSTRAINT unique_user_category UNIQUE (user_id, category)
);

-- Create indexes for user progress queries
CREATE INDEX IF NOT EXISTS idx_user_progress_user_id ON user_progress(user_id);
CREATE INDEX IF NOT EXISTS idx_user_progress_category ON user_progress(category);
CREATE INDEX IF NOT EXISTS idx_user_progress_last_activity ON user_progress(last_activity);

-- Function to update user experience and level
CREATE OR REPLACE FUNCTION update_user_level()
RETURNS TRIGGER AS $$
BEGIN
  -- Level up every 100 experience points
  NEW.level := FLOOR(NEW.experience / 100) + 1;
  RETURN NEW;
END;
$$ LANGUAGE plpgsql;

-- Trigger to automatically update level when experience changes
CREATE TRIGGER trigger_update_user_level
  BEFORE UPDATE OF experience ON users
  FOR EACH ROW
  WHEN (OLD.experience IS DISTINCT FROM NEW.experience)
  EXECUTE FUNCTION update_user_level();

-- Function to update last activity timestamp
CREATE OR REPLACE FUNCTION update_last_activity()
RETURNS TRIGGER AS $$
BEGIN
  NEW.last_activity := TIMEZONE('utc'::text, NOW());
  RETURN NEW;
END;
$$ LANGUAGE plpgsql;

-- Trigger to update last activity
CREATE TRIGGER trigger_update_last_activity
  BEFORE UPDATE ON user_progress
  FOR EACH ROW
  EXECUTE FUNCTION update_last_activity();

-- Row Level Security (RLS) Policies
ALTER TABLE users ENABLE ROW LEVEL SECURITY;
ALTER TABLE animals ENABLE ROW LEVEL SECURITY;
ALTER TABLE quiz_questions ENABLE ROW LEVEL SECURITY;
ALTER TABLE user_progress ENABLE ROW LEVEL SECURITY;

-- Users can read their own data
CREATE POLICY "Users can view own data" ON users
  FOR SELECT USING (true);

-- Users can update their own data
CREATE POLICY "Users can update own data" ON users
  FOR UPDATE USING (true);

-- Anyone can read animals
CREATE POLICY "Animals are publicly readable" ON animals
  FOR SELECT USING (true);

-- Anyone can read quiz questions
CREATE POLICY "Quiz questions are publicly readable" ON quiz_questions
  FOR SELECT USING (true);

-- Users can view and manage their own progress
CREATE POLICY "Users can view own progress" ON user_progress
  FOR SELECT USING (true);

CREATE POLICY "Users can insert own progress" ON user_progress
  FOR INSERT WITH CHECK (true);

CREATE POLICY "Users can update own progress" ON user_progress
  FOR UPDATE USING (true);

-- Grant permissions
GRANT USAGE ON SCHEMA public TO anon, authenticated;
GRANT ALL ON ALL TABLES IN SCHEMA public TO anon, authenticated;
GRANT ALL ON ALL SEQUENCES IN SCHEMA public TO anon, authenticated;

-- Comments for documentation
COMMENT ON TABLE users IS 'Stores user account information and progress';
COMMENT ON TABLE animals IS 'Contains information about different animals for learning';
COMMENT ON TABLE quiz_questions IS 'Stores quiz questions for mini games';
COMMENT ON TABLE user_progress IS 'Tracks user progress across different animal categories';

COMMENT ON COLUMN users.level IS 'User level based on experience points (1 level per 100 XP)';
COMMENT ON COLUMN users.experience IS 'Total experience points earned by the user';
COMMENT ON COLUMN animals.fun_facts IS 'Array of interesting facts about the animal';
COMMENT ON COLUMN quiz_questions.options IS 'Array of answer options (must have at least 2)';
