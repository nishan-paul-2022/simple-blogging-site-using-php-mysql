#!/bin/bash

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo -e "${YELLOW}=== Blog Platform Initialization ===${NC}\n"

# Check Docker
if ! command -v docker &> /dev/null; then
    echo -e "${RED}Docker is not installed${NC}"
    exit 1
fi

echo -e "${GREEN}✓ Docker is installed${NC}"

# Check Docker Compose
if ! command -v docker-compose &> /dev/null; then
    echo -e "${RED}Docker Compose is not installed${NC}"
    exit 1
fi

echo -e "${GREEN}✓ Docker Compose is installed${NC}\n"

# Build images
echo -e "${YELLOW}Building Docker images...${NC}"
docker-compose build

if [ $? -eq 0 ]; then
    echo -e "${GREEN}✓ Docker images built successfully${NC}\n"
else
    echo -e "${RED}✗ Failed to build Docker images${NC}"
    exit 1
fi

# Start services
echo -e "${YELLOW}Starting services...${NC}"
docker-compose up -d

if [ $? -eq 0 ]; then
    echo -e "${GREEN}✓ Services started successfully${NC}\n"
else
    echo -e "${RED}✗ Failed to start services${NC}"
    exit 1
fi

# Wait for services to be ready
echo -e "${YELLOW}Waiting for services to be ready...${NC}"
sleep 10

# Run migrations
echo -e "${YELLOW}Running database migrations...${NC}"
docker-compose exec -T app-backend php artisan migrate --force

if [ $? -eq 0 ]; then
    echo -e "${GREEN}✓ Migrations completed${NC}\n"
else
    echo -e "${YELLOW}⚠ Migrations skipped (database might already be initialized)${NC}\n"
fi

# Display information
echo -e "${GREEN}=== Setup Complete ===${NC}\n"
echo -e "Frontend: ${YELLOW}http://localhost:3000${NC}"
echo -e "API: ${YELLOW}http://localhost:8000/api${NC}"
echo -e "Database: ${YELLOW}localhost:3306${NC}"
echo -e "\nDatabase Credentials:"
echo -e "Username: ${YELLOW}blog_user${NC}"
echo -e "Password: ${YELLOW}blog_password${NC}"
echo -e "Database: ${YELLOW}blog_db${NC}"
echo -e "\nTo view logs: ${YELLOW}docker-compose logs -f${NC}"
echo -e "To stop services: ${YELLOW}docker-compose down${NC}\n"
