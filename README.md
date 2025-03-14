# Data Bank Project

A Laravel 12 and Livewire 3.6 application for uploading and sharing datasets.

## System Requirements

- PHP 8.2+
- MySQL 5.7+ or MariaDB 10.3+
- Composer 2.0+
- Node.js 16+ and NPM
- Git

## Installation Steps

### Step 1: Clone the Repository

```bash
git clone <repository-url>
cd data-bank
```

### Step 2: Install Dependencies

```bash
composer install
npm install
```

### Step 3: Environment Setup

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### Step 4: Configure Database

Edit the `.env` file and update the database connection settings:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=databank
DB_USERNAME=root
DB_PASSWORD=your_password
```

### Step 5: Run Migrations and Seeders

```bash
php artisan migrate
php artisan db:seed
```

### Step 6: Storage Setup

```bash
# Create symbolic link for storage
php artisan storage:link
```

### Step 7: Build Assets

```bash
npm run dev
# OR for production
npm run build
```

### Step 8: Start the Development Server

```bash
php artisan serve
```

Your application should now be running at `http://localhost:8000`

## OS-Specific Instructions

### Windows

1. Make sure you have [XAMPP](https://www.apachefriends.org/download.html) (with PHP 8.2) or [Laragon](https://laragon.org/download/index.html) installed for easy PHP, MySQL setup
2. If using XAMPP, start Apache and MySQL services from the XAMPP Control Panel
3. For file permissions issues, run commands in an elevated command prompt (Run as Administrator)

### macOS

1. We recommend using [Homebrew](https://brew.sh/) to install PHP and MySQL:
```bash
brew install php@8.2
brew install mysql
brew services start mysql
```
2. Set up your MySQL root password:
```bash
mysql_secure_installation
```

### Linux (Ubuntu/Debian)

1. Install required packages:
```bash
sudo apt update
sudo apt install php8.2 php8.2-cli php8.2-common php8.2-mysql php8.2-zip php8.2-gd php8.2-mbstring php8.2-curl php8.2-xml php8.2-bcmath
sudo apt install mysql-server
```
2. Configure MySQL:
```bash
sudo mysql_secure_installation
```

## Usage

### Login
Navigate to `http://localhost:8000/login` and use the following credentials:
- Email: admin@example.com
- Password: password

### Dashboard
From the dashboard, you can:
- View all datasets
- Filter datasets by skill, industry, or year
- Search for specific datasets
- Upload new datasets
- Download existing datasets

## Troubleshooting

### Common Issues

1. **Storage Permission Issues**
   ```bash
   # On Linux/macOS
   chmod -R 775 storage bootstrap/cache
   ```

2. **Database Connection Issues**
    - Make sure your MySQL service is running
    - Verify the credentials in your `.env` file

3. **Livewire Issues**
    - Clear view cache:
   ```bash
   php artisan view:clear
   ```

4. **File Upload Issues**
    - Check PHP configuration for file upload limits (`php.ini`)
    - Make sure storage directory is writable

## Additional Commands

```bash
# Clear application cache
php artisan cache:clear

# Clear config cache
php artisan config:clear

# Clear route cache
php artisan route:clear

# Clear view cache
php artisan view:clear
```

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
