/** @type {import('tailwindcss').Config} */
export default {
  content: ['./index.html', './src/**/*.{ts,tsx}'],
  theme: {
    extend: {
      colors: {
        brand: {
          green: '#43E08B',
          'green-dark': '#2ecb75',
          text: '#0F172A',
          secondary: '#475569',
          surface: '#F8FAFC',
          card: '#FFFFFF',
          mint: '#EAFBF2',
          border: '#DDEFE5',
        },
      },
      boxShadow: {
        soft: '0 20px 50px rgba(15, 23, 42, 0.08)',
        card: '0 12px 30px rgba(15, 23, 42, 0.06)',
      },
      borderRadius: {
        '4xl': '2rem',
      },
      fontFamily: {
        sans: ['Inter', 'sans-serif'],
      },
    },
  },
  plugins: [],
};
