#!/bin/bash
docker-compose down
docker-compose up -d --build
docker exec -it kanboard_app php artisan config:clear
docker exec -it kanboard_app php artisan migrate --force
