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
        // Primary brand colors (keep existing)
        primary: {
          DEFAULT: "#0066FF",
          dark: "#0052CC",
          light: "#E8F5FF",
        },
        secondary: "#FF9500",
        success: "#00CC66",
        danger: "#FF3366",

        // Sorted brand colors (NEW - for user UI)
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
      },

      borderRadius: {
        'sorted': '1rem',      // 16px - standard card radius
        'sorted-lg': '1.5rem', // 24px - large card radius
      },

      boxShadow: {
        'sorted': '0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px -1px rgba(0, 0, 0, 0.1)',
        'sorted-md': '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1)',
        'sorted-lg': '0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1)',
      },

      animation: {
        'fade-in': 'fadeIn 0.3s ease-in-out',
        'slide-in': 'slideIn 0.3s ease-out',
        'slide-up': 'slideUp 0.3s ease-out',
      },

      keyframes: {
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
      },
    },
  },

  plugins: [
    require("flowbite/plugin"),
  ],
};