#!/bin/bash

echo "Setting up audio captcha..."
mkdir -p ../storage/app/captcha/letters/
python3 ../gen.py ../storage/app/captcha/letters/

echo "Building docker image..."
# docker-compose build

echo "Copying environment files..."
cp ../.env.example ../.env
echo "Done!"

echo "Starting docker container..."
docker-compose up -d
echo "Container started!"
echo "For subsequent runs, simply execute docker-compose up -d at the root of the repository. This script is no longer needed."
echo "When updating the site, run git pull, rebuild all containers with docker-compose build, then run docker-compose up -d afterwards."