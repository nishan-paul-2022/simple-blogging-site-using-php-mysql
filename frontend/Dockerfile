FROM node:20-alpine

WORKDIR /app

# Copy package files
COPY package.json package-lock.json* ./

# Install dependencies (use npm ci when lockfile exists, fallback otherwise)
RUN if [ -f package-lock.json ]; then \
			npm ci --prefer-offline --no-audit; \
		else \
			npm install --no-audit; \
		fi

# Copy application files
COPY . .

# Expose port
EXPOSE 3000

# Run development server
CMD ["npm", "run", "dev"]
