import nextCoreWebVitals from "eslint-config-next/core-web-vitals";
import prettierConfig from "eslint-config-prettier/flat";
import prettierPlugin from "eslint-plugin-prettier";

const eslintConfig = [
  // Base ignores
  {
    ignores: [
      ".next/**",
      "node_modules/**",
      "out/**",
      "build/**",
      "dist/**",
      "public/**",
      "*.config.js",
      "*.config.mjs",
      "*.config.ts",
      ".env*",
    ],
  },
  ...nextCoreWebVitals,
  prettierConfig,
  // Explicitly match TS files since they weren't being picked up
  {
    files: ["**/*.ts", "**/*.tsx"],
    plugins: {
      prettier: prettierPlugin,
    },
    rules: {
      "prettier/prettier": [
        "error",
        {
          "endOfLine": "auto",
        },
      ],
      "react/react-in-jsx-scope": "off",
      "react/prop-types": "off",
      "react/no-unescaped-entities": "error",
      "@next/next/no-img-element": "error",
    },
  },
];

export default eslintConfig;
