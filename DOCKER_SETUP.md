# ImoleAfrica LMS - Docker Setup Guide

This guide will help you set up PostgreSQL and Redis using Docker for the ImoleAfrica Learning Management System.

## Prerequisites

- Docker Desktop installed ([Download here](https://www.docker.com/products/docker-desktop))
- Docker Compose (included with Docker Desktop)
- PHP 8.2+ with PostgreSQL extensions

## Services Included

### 1. PostgreSQL 16
- **Port**: 5432
- **Database**: imole_lms
- **Username**: imole_user
- **Password**: imole_password
- **Container**: `imole_postgres`

### 2. Redis 7
- **Port**: 6379
- **Password**: imole_redis_password
- **Container**: `imole_redis`
- **Used for**: Cache, Sessions, Queues

### 3. PgAdmin 4 (Optional)
- **Port**: 5050
- **URL**: http://localhost:5050
- **Email**: admin@imoleafrica.com
- **Password**: admin_password
- **Container**: `imole_pgadmin`

## Quick Start

### 1. Start Docker Services

```bash
# Start all services in detached mode
docker-compose up -d

# Check if services are running
docker-compose ps

# View logs
docker-compose logs -f
```

### 2. Install PHP PostgreSQL Extension

**Windows (XAMPP/WAMP):**
1. Open `php.ini`
2. Uncomment: `extension=pdo_pgsql` and `extension=pgsql`
3. Restart Apache/PHP

**macOS (Homebrew):**
```bash
pecl install pdo_pgsql
```

**Linux (Ubuntu/Debian):**
```bash
sudo apt-get install php8.2-pgsql
```

### 3. Verify Database Connection

```bash
# Test connection
php artisan tinker

# In tinker, run:
DB::connection()->getPdo();
```

### 4. Run Migrations

```bash
# Clear config cache
php artisan config:clear

# Run migrations
php artisan migrate:fresh --seed
```

## Useful Docker Commands

### Managing Services

```bash
# Stop all services
docker-compose down

# Stop and remove volumes (WARNING: deletes all data)
docker-compose down -v

# Restart a specific service
docker-compose restart postgres
docker-compose restart redis

# View service logs
docker-compose logs postgres
docker-compose logs redis
```

### Database Management

```bash
# Access PostgreSQL CLI
docker exec -it imole_postgres psql -U imole_user -d imole_lms

# Create a database backup
docker exec imole_postgres pg_dump -U imole_user imole_lms > backup.sql

# Restore from backup
docker exec -i imole_postgres psql -U imole_user -d imole_lms < backup.sql
```

### Redis Management

```bash
# Access Redis CLI
docker exec -it imole_redis redis-cli -a imole_redis_password

# Common Redis commands:
# PING - Test connection
# KEYS * - List all keys
# FLUSHALL - Clear all cache (use carefully!)
# INFO - Server information
```

## PgAdmin Setup

1. Open browser: http://localhost:5050
2. Login with:
   - Email: `admin@imoleafrica.com`
   - Password: `admin_password`
3. Add server:
   - Name: `ImoleAfrica LMS`
   - Host: `postgres` (Docker network name)
   - Port: `5432`
   - Database: `imole_lms`
   - Username: `imole_user`
   - Password: `imole_password`

## Environment Variables

All configuration is in `.env` file. Key variables:

```env
# PostgreSQL
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=imole_lms
DB_USERNAME=imole_user
DB_PASSWORD=imole_password

# Redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=imole_redis_password
REDIS_PORT=6379

CACHE_STORE=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis
```

## Production Recommendations

### Security
1. Change default passwords in `.env`
2. Don't expose PostgreSQL/Redis ports publicly
3. Use environment-specific `.env` files
4. Enable SSL/TLS for database connections

### Performance
```env
# Redis optimizations
REDIS_PREFIX=imole_
CACHE_PREFIX=imole_cache

# Queue workers
QUEUE_CONNECTION=redis
```

### Backup Strategy
```bash
# Daily backup cron job
0 2 * * * docker exec imole_postgres pg_dump -U imole_user imole_lms > /backups/imole_$(date +\%Y\%m\%d).sql
```

## Troubleshooting

### Connection Refused
```bash
# Check if services are running
docker-compose ps

# Restart services
docker-compose restart
```

### Can't Connect to PostgreSQL
```bash
# Check PostgreSQL logs
docker-compose logs postgres

# Verify PostgreSQL is accepting connections
docker exec imole_postgres pg_isready -U imole_user
```

### Redis Authentication Failed
```bash
# Verify Redis password matches .env
docker exec imole_redis redis-cli -a imole_redis_password PING
```

### Port Already in Use
```bash
# Find what's using the port (Windows)
netstat -ano | findstr :5432

# Change ports in docker-compose.yml
# Example: "5433:5432" instead of "5432:5432"
```

## Health Checks

Both PostgreSQL and Redis have health checks configured:

```bash
# Check container health
docker inspect imole_postgres | grep -A 10 Health
docker inspect imole_redis | grep -A 10 Health
```

## Data Persistence

Data is persisted in Docker volumes:
- `postgres_data` - PostgreSQL database files
- `redis_data` - Redis RDB snapshots
- `pgadmin_data` - PgAdmin settings

**Location (Windows)**: `\\wsl$\docker-desktop-data\data\docker\volumes\`

## Next Steps

1. ✅ Start Docker services: `docker-compose up -d`
2. ✅ Verify `.env` configuration
3. ✅ Run migrations: `php artisan migrate:fresh --seed`
4. ✅ Test Redis cache: `php artisan cache:clear`
5. ✅ Access PgAdmin: http://localhost:5050

## Support

For issues:
- Check logs: `docker-compose logs -f`
- Restart services: `docker-compose restart`
- Full reset: `docker-compose down -v && docker-compose up -d`
