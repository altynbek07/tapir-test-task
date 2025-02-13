# Vehicle Request Service

This service handles vehicle requests and integrates with a CRM system through queue-based processing.

## Requirements

- Docker
- Docker Compose

## Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/altynbek07/tapir-test-task.git
   ```
2. **Copy environment file:**
   ```bash
   cp .env.example .env
   ```
3. **Start the project using Laravel Sail:**
   ```bash
   ./vendor/bin/sail up -d
   ```
4. **Install dependencies:**
   ```bash
   ./vendor/bin/sail composer install
   ```
5. **Generate application key:**
   ```bash
   ./vendor/bin/sail artisan key:generate
   ```
6. **Run migrations:**
   ```bash
   ./vendor/bin/sail artisan migrate
   ```

## Features

### API Routes

- **POST** `/api/import` - Import vehicles from the CSV file
- **GET** `/api/stock` - Get all vehicles from the database
- **POST** `/api/requests` - Create a new vehicle request

### Events

- `VehicleRequestCreated` - Fired when a new vehicle request is created

### Listeners

- `SendCreatedVehicleRequestToCrm` - Handles sending vehicle request data to the CRM system when a new vehicle request is created
  - Located in: `app/Listeners/VehicleRequest/SendCreatedVehicleRequestToCrm.php`
  - Dispatches `SendVehicleRequestToCrmJob` to the queue

- `SendCreatedVehicleRequestNotification` - Sends a notification to the admin when a new vehicle request is created
  - Located in: `app/Listeners/VehicleRequest/SendCreatedVehicleRequestNotification.php`
  - Sends `NewVehicleRequestNotification` to the admin

### Jobs

- `SendVehicleRequestToCrmJob` - Processes vehicle request data and sends it to the CRM
  - Located in: `app/Jobs/SendVehicleRequestToCrmJob.php`
  - Uses queue for asynchronous processing

## Queue Processing

The project uses Laravel Horizon for queue management. To start the queue worker:
```bash
./vendor/bin/sail artisan horizon
```

## Environment Configuration

Key environment variables:
```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=tapir
DB_USERNAME=sail
DB_PASSWORD=password
QUEUE_CONNECTION=redis
REDIS_CLIENT=phpredis
REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379
TAPIR_CRM_URL=https://crm.tapir.ws/api/crm
TAPIR_ADMIN_EMAIL=admin@tapir.ws
```

## Testing

Run tests using:
```bash
./vendor/bin/sail artisan test
```

## License

This project is licensed under the MIT License.

