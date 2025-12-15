import { supabase } from '@/lib/supabase';
import { Database } from '@/types/database';

type AnimalRow = Database['public']['Tables']['animals']['Row'];
type QuizRow = Database['public']['Tables']['quiz_questions']['Row'];
type ProgressRow = Database['public']['Tables']['user_progress']['Row'];
type ProgressInsert = Database['public']['Tables']['user_progress']['Insert'];

export interface Animal {
  id: string;
  name: string;
  category: string;
  description: string;
  image_url: string;
  sound_url: string;
  fun_facts: string[];
}

export const animalService = {
  async getAnimalsByCategory(category: string): Promise<Animal[]> {
    const { data, error } = await supabase
      .from('animals')
      .select<'*', AnimalRow>('*')
      .eq('category', category)
      .order('name');

    if (error) throw error;
    return data || [];
  },

  async getAllAnimals(): Promise<Animal[]> {
    const { data, error } = await supabase
      .from('animals')
      .select<'*', AnimalRow>('*')
      .order('category, name');

    if (error) throw error;
    return data || [];
  },

  async getAnimalById(id: string): Promise<Animal | null> {
    const { data, error } = await supabase
      .from('animals')
      .select<'*', AnimalRow>('*')
      .eq('id', id)
      .single();

    if (error) throw error;
    return data;
  },
};

export interface QuizQuestion {
  id: string;
  question: string;
  category: string;
  correct_answer: string;
  options: string[];
  image_url: string;
  difficulty: string;
}

export const quizService = {
  async getQuizzesByCategory(category: string): Promise<QuizQuestion[]> {
    const { data, error } = await supabase
      .from('quiz_questions')
      .select<'*', QuizRow>('*')
      .eq('category', category);

    if (error) throw error;
    return data || [];
  },

  async getRandomQuiz(category?: string): Promise<QuizQuestion | null> {
    let query = supabase.from('quiz_questions').select<'*', QuizRow>('*');

    if (category) {
      query = query.eq('category', category);
    }

    const { data, error } = await query;

    if (error || !data || data.length === 0) return null;

    // Get random question
    const randomIndex = Math.floor(Math.random() * data.length);
    return data[randomIndex];
  },
};

export interface UserProgress {
  id: string;
  user_id: string;
  category: string;
  completed_animals: string[];
  quiz_score: number;
  last_activity: string;
}

export const progressService = {
  async getUserProgress(userId: string): Promise<UserProgress[]> {
    const { data, error } = await supabase
      .from('user_progress')
      .select<'*', ProgressRow>('*')
      .eq('user_id', userId);

    if (error) throw error;
    return data || [];
  },

  async updateProgress(
    userId: string,
    category: string,
    updates: Partial<UserProgress>
  ): Promise<void> {
    const { error } = await supabase
      .from('user_progress')
      .upsert({
        user_id: userId,
        category,
        ...updates,
      } as any);

    if (error) throw error;
  },

  async markAnimalCompleted(
    userId: string,
    category: string,
    animalName: string
  ): Promise<void> {
    // Get current progress
    const { data: existing } = await supabase
      .from('user_progress')
      .select<'completed_animals', Pick<ProgressRow, 'completed_animals'>>('completed_animals')
      .eq('user_id', userId)
      .eq('category', category)
      .single();

    const progressData = existing as Pick<ProgressRow, 'completed_animals'> | null;
    const completedAnimals = progressData?.completed_animals || [];
    if (!completedAnimals.includes(animalName)) {
      completedAnimals.push(animalName);
    }

    await this.updateProgress(userId, category, { completed_animals: completedAnimals });
  },
};
