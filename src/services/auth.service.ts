import { supabase, supabaseAdmin } from '@/lib/supabase';
import { Database } from '@/types/database';
import bcrypt from 'bcryptjs';

type User = Database['public']['Tables']['users']['Row'];
type UserInsert = Database['public']['Tables']['users']['Insert'];
type UserUpdate = Database['public']['Tables']['users']['Update'];

export interface RegisterData {
  name: string;
  password: string;
  avatar: string;
}

export interface LoginData {
  name: string;
  password: string;
}

export const authService = {
  async register(data: RegisterData) {
    try {
      // Check if user already exists
      const { data: existingUser } = await supabase
        .from('users')
        .select('id')
        .eq('name', data.name)
        .single();

      if (existingUser) {
        throw new Error('Username already exists');
      }

      // Hash password (in real app, this should be done server-side)
      const passwordHash = await bcrypt.hash(data.password, 10);

      // Create user
      const { data: newUser, error } = await supabase
        .from('users')
        .insert([
          {
            name: data.name,
            password_hash: passwordHash,
            avatar: data.avatar,
          },
        ] as any)
        .select()
        .single();

      if (error) throw error;

      const userData = newUser as User;
      return {
        id: userData.id,
        name: userData.name,
        avatar: userData.avatar,
        level: userData.level,
        experience: userData.experience,
      };
    } catch (error: any) {
      throw new Error(error.message || 'Registration failed');
    }
  },

  async login(data: LoginData) {
    try {
      // Get user by name
      const { data: user, error } = await supabase
        .from('users')
        .select('*')
        .eq('name', data.name)
        .single<User>();

      if (error || !user) {
        throw new Error('Invalid username or password');
      }

      // Verify password (in real app, this should be done server-side)
      const userData = user as User;
      const isValid = await bcrypt.compare(data.password, userData.password_hash);

      if (!isValid) {
        throw new Error('Invalid username or password');
      }

      return {
        id: userData.id,
        name: userData.name,
        avatar: userData.avatar,
        level: userData.level,
        experience: userData.experience,
      };
    } catch (error: any) {
      throw new Error(error.message || 'Login failed');
    }
  },

  async updateUser(userId: string, updates: Partial<RegisterData>) {
    try {
      // Build update object
      const updateFields: Record<string, any> = {};
      if (updates.name) updateFields.name = updates.name;
      if (updates.avatar) updateFields.avatar = updates.avatar;
      if (updates.password) {
        updateFields.password_hash = await bcrypt.hash(updates.password, 10);
      }

      // Perform update - using type assertion to bypass Supabase type inference issue
      const updateQuery: any = supabaseAdmin.from('users');
      const result: any = await updateQuery
        .update(updateFields)
        .eq('id', userId)
        .select()
        .single();

      if (result.error) throw result.error;

      const userData = result.data as User;
      return {
        id: userData.id,
        name: userData.name,
        avatar: userData.avatar,
        level: userData.level,
        experience: userData.experience,
      };
    } catch (error: any) {
      throw new Error(error.message || 'Update failed');
    }
  },
};
