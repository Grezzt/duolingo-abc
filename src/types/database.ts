export type Json =
  | string
  | number
  | boolean
  | null
  | { [key: string]: Json | undefined }
  | Json[]

export interface Database {
  public: {
    Tables: {
      users: {
        Row: {
          id: string
          created_at: string
          name: string
          password_hash: string
          avatar: string
          level: number
          experience: number
        }
        Insert: {
          id?: string
          created_at?: string
          name: string
          password_hash: string
          avatar?: string
          level?: number
          experience?: number
        }
        Update: {
          id?: string
          created_at?: string
          name?: string
          password_hash?: string
          avatar?: string
          level?: number
          experience?: number
        }
      }
      animals: {
        Row: {
          id: string
          created_at: string
          name: string
          category: string
          description: string
          image_url: string
          sound_url: string
          fun_facts: string[]
        }
        Insert: {
          id?: string
          created_at?: string
          name: string
          category: string
          description: string
          image_url: string
          sound_url: string
          fun_facts?: string[]
        }
        Update: {
          id?: string
          created_at?: string
          name?: string
          category?: string
          description?: string
          image_url?: string
          sound_url?: string
          fun_facts?: string[]
        }
      }
      quiz_questions: {
        Row: {
          id: string
          created_at: string
          question: string
          category: string
          correct_answer: string
          options: string[]
          image_url: string
          difficulty: string
        }
        Insert: {
          id?: string
          created_at?: string
          question: string
          category: string
          correct_answer: string
          options: string[]
          image_url: string
          difficulty?: string
        }
        Update: {
          id?: string
          created_at?: string
          question?: string
          category?: string
          correct_answer?: string
          options?: string[]
          image_url?: string
          difficulty?: string
        }
      }
      user_progress: {
        Row: {
          id: string
          created_at: string
          user_id: string
          category: string
          completed_animals: string[]
          quiz_score: number
          last_activity: string
        }
        Insert: {
          id?: string
          created_at?: string
          user_id: string
          category: string
          completed_animals?: string[]
          quiz_score?: number
          last_activity?: string
        }
        Update: {
          id?: string
          created_at?: string
          user_id?: string
          category?: string
          completed_animals?: string[]
          quiz_score?: number
          last_activity?: string
        }
      }
    }
    Views: {
      [_ in never]: never
    }
    Functions: {
      [_ in never]: never
    }
    Enums: {
      [_ in never]: never
    }
  }
}
