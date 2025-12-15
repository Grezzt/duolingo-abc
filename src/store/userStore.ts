import { create } from 'zustand';
import { persist } from 'zustand/middleware';

export interface User {
  id: string;
  name: string;
  avatar: string;
  level: number;
  experience: number;
}

interface UserStore {
  user: User | null;
  setUser: (user: User | null) => void;
  updateExperience: (points: number) => void;
  logout: () => void;
}

export const useUserStore = create<UserStore>()(
  persist(
    (set) => ({
      user: null,
      setUser: (user) => set({ user }),
      updateExperience: (points) =>
        set((state) => {
          if (!state.user) return state;
          const newExperience = state.user.experience + points;
          const newLevel = Math.floor(newExperience / 100) + 1;
          return {
            user: {
              ...state.user,
              experience: newExperience,
              level: newLevel,
            },
          };
        }),
      logout: () => set({ user: null }),
    }),
    {
      name: 'user-storage',
    }
  )
);
