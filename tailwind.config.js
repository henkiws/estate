import defaultTheme from "tailwindcss/defaultTheme";

/** @type {import('tailwindcss').Config} */
export default {
  darkMode: "class",

  content: [
    "./resources/views/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",

    "./storage/framework/views/*.php",
    "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",

    // Flowbite components
    "./node_modules/flowbite/**/*.js",
  ],

  theme: {
    extend: {
      colors: {
        // ============================================
        // PLYFORM BRAND COLORS (NEW REDESIGN)
        // ============================================
        'plyform-mint': '#DDEECD',
        'plyform-dark': '#1E1C1C',
        'plyform-yellow': '#E6FF4B',
        'plyform-orange': '#FF3600',
        'plyform-purple': '#5E17EB',
        'plyform-red': '#f86b6b',
        
        // Plyform semantic aliases for consistency
        'plyform': {
          mint: '#DDEECD',
          dark: '#1E1C1C',
          yellow: '#E6FF4B',
          'yellow-dark': '#d4f039', // Darker yellow for hover states
          orange: '#FF3600',
          purple: '#5E17EB',
          red: '#f86b6b',
        },

        // ============================================
        // EXISTING PRIMARY BRAND COLORS (ADMIN/AGENCY)
        // ============================================
        primary: {
          DEFAULT: "#0066FF",
          dark: "#0052CC",
          light: "#E8F5FF",
        },
        secondary: "#FF9500",
        success: "#00CC66",
        danger: "#FF3366",

        // ============================================
        // SORTED BRAND COLORS (USER UI)
        // ============================================
        teal: {
          50: '#f0fdfa',
          100: '#ccfbf1',
          200: '#99f6e4',
          300: '#5eead4',
          400: '#2dd4bf',
          500: '#14b8a6',  // Main Sorted brand color
          600: '#0d9488',
          700: '#0f766e',
          800: '#115e59',
          900: '#134e4a',
          950: '#042f2e',
        },

        // Additional Sorted accent colors
        'sorted-purple': '#8b5cf6',
        'sorted-lavender': '#f3e8ff',
        'sorted-lightblue': '#dbeafe',
        'sorted-amber': '#fef3c7',
        'sorted-orange': '#fed7aa',
        'sorted-red': '#f86b6b',
      },

      fontFamily: {
        sans: [
          "Inter",
          "-apple-system",
          "BlinkMacSystemFont",
          "Segoe UI",
          "Roboto",
          "Helvetica Neue",
          "Arial",
          "sans-serif",
          ...defaultTheme.fontFamily.sans,
        ],
        // Add Garet font for plyform pages
        garet: ['Garet', 'Inter', ...defaultTheme.fontFamily.sans],
      },

      borderRadius: {
        'sorted': '1rem',      // 16px - standard card radius
        'sorted-lg': '1.5rem', // 24px - large card radius
        'plyform': '1rem',     // Plyform standard radius
        'plyform-lg': '1.5rem', // Plyform large radius
      },

      boxShadow: {
        // Existing Sorted shadows
        'sorted': '0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px -1px rgba(0, 0, 0, 0.1)',
        'sorted-md': '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1)',
        'sorted-lg': '0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1)',
        
        // Plyform brand shadows
        'plyform': '0 10px 40px rgba(30, 28, 28, 0.1)',
        'plyform-lg': '0 20px 60px rgba(30, 28, 28, 0.15)',
        'plyform-yellow': '0 10px 30px rgba(230, 255, 75, 0.3)',
        'plyform-purple': '0 10px 30px rgba(94, 23, 235, 0.3)',
      },

      backgroundImage: {
        'gradient-plyform': 'linear-gradient(135deg, #DDEECD 0%, #E6FF4B 100%)',
        'gradient-plyform-dark': 'linear-gradient(135deg, #1E1C1C 0%, #5E17EB 100%)',
        'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
      },

      animation: {
        // Existing animations
        'fade-in': 'fadeIn 0.3s ease-in-out',
        'slide-in': 'slideIn 0.3s ease-out',
        'slide-up': 'slideUp 0.3s ease-out',
        
        // Plyform animations
        'float': 'float 3s ease-in-out infinite',
        'float-delay-1': 'float 3s ease-in-out 0.5s infinite',
        'float-delay-2': 'float 3s ease-in-out 1s infinite',
        'fadeIn': 'fadeIn 0.6s ease-out',
        'slideInRight': 'slideInRight 0.3s ease-out',
        'pulse-glow': 'pulse-glow 2s ease-in-out infinite',
      },

      keyframes: {
        // Existing keyframes
        fadeIn: {
          '0%': { opacity: '0' },
          '100%': { opacity: '1' },
        },
        slideIn: {
          '0%': { transform: 'translateX(-100%)' },
          '100%': { transform: 'translateX(0)' },
        },
        slideUp: {
          '0%': { transform: 'translateY(20px)', opacity: '0' },
          '100%': { transform: 'translateY(0)', opacity: '1' },
        },
        
        // Plyform keyframes
        float: {
          '0%, 100%': { transform: 'translateY(0px)' },
          '50%': { transform: 'translateY(-10px)' },
        },
        slideInRight: {
          'from': { transform: 'translateX(100%)' },
          'to': { transform: 'translateX(0)' },
        },
        'pulse-glow': {
          '0%, 100%': { 
            boxShadow: '0 0 20px rgba(230, 255, 75, 0.3)' 
          },
          '50%': { 
            boxShadow: '0 0 40px rgba(230, 255, 75, 0.5)' 
          },
        },
      },
    },
  },

  plugins: [
    require("flowbite/plugin"),
  ],
};