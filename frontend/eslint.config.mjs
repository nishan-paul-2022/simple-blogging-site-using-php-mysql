import { dirname } from "path";
import { fileURLToPath } from "url";
import { FlatCompat } from "@eslint/eslintrc";

const __filename = fileURLToPath(import.meta.url);
const __dirname = dirname(__filename);

const compat = new FlatCompat({
  baseDirectory: __dirname,
});

const eslintConfig = [
  // Base ignores
  {
    ignores: [
      ".next/*",
      "node_modules/*",
      "out/*",
      "build/*",
      "dist/*",
      "public/*",
      "*.config.js",
      "*.config.mjs",
      "*.config.ts",
      ".env*",
    ],
  },
  // Basic Next.js configuration via compat (safely)
  ...compat.extends("next/core-web-vitals", "prettier"),
  // Explicitly match TS files since they weren't being picked up
  {
    files: ["**/*.ts", "**/*.tsx"],
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
