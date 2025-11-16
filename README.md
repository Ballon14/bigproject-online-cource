# SPK Online Courses - Decision Support System

A web-based Decision Support System (DSS) application for recommending online courses using the **SAW (Simple Additive Weighting)** method. Built with Laravel 10, this application helps users make informed decisions when selecting online courses based on multiple criteria.

## 🚀 Features

### Core Functionality

-   **Course Management**: Full CRUD operations for managing online courses
-   **SAW Calculation**: Automated ranking calculation using Simple Additive Weighting method
-   **Multi-Criteria Decision Making**: Evaluate courses based on:
    -   Cost (lower is better)
    -   Rating (higher is better)
    -   Duration (lower is better)
    -   Flexibility (higher is better)
    -   Certificate quality (higher is better)
    -   Last update frequency (higher is better)
-   **Real-time Ranking**: Dynamic course ranking based on weighted criteria
-   **Normalization Matrix**: Visual representation of normalized decision matrix
-   **Detailed Results**: Comprehensive ranking results with normalization details

### User Features

-   **User Authentication**: Secure login and registration system
-   **User Profile Management**: Edit profile and account settings
-   **Dashboard**: Overview with statistics and course charts
-   **Responsive Design**: Mobile-friendly interface with card views
-   **Interactive UI**: Modern UI with Alpine.js for dynamic interactions
-   **Data Visualization**: Chart.js integration for course cost visualization

## 📋 Prerequisites

Before you begin, ensure you have the following installed:

-   **PHP** >= 8.1
-   **Composer** (PHP dependency manager)
-   **Node.js** and **npm** (for frontend assets)
-   **MySQL** or **PostgreSQL** (database)
-   **Web Server** (Apache/Nginx) or PHP built-in server

## 🛠️ Installation

### 1. Clone the Repository

```bash
git clone <repository-url>
cd bigproject
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install Node Dependencies

```bash
npm install
```

### 4. Environment Configuration

```bash
cp .env.example .env
php artisan key:generate
```

Edit the `.env` file and configure your database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

### 5. Run Database Migrations

```bash
php artisan migrate
```

### 6. (Optional) Seed Sample Data

```bash
php artisan db:seed
```

### 7. Build Frontend Assets

```bash
npm run build
```

For development with hot reload:

```bash
npm run dev
```

### 8. Start the Development Server

```bash
php artisan serve
```

The application will be available at `http://localhost:8000`

## 📁 Project Structure

```
bigproject/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── CourseController.php    # Main course and calculation logic
│   │       └── UserController.php     # Authentication and user management
│   └── Models/
│       ├── Course.php                 # Course model
│       ├── Calculation.php            # Calculation model
│       ├── CalculationResult.php      # Calculation result model
│       └── User.php                   # User model
├── database/
│   ├── migrations/                    # Database migrations
│   └── seeders/                      # Database seeders
├── resources/
│   ├── views/                         # Blade templates
│   │   ├── components/                # Reusable components
│   │   ├── dashboard.blade.php        # Main dashboard
│   │   ├── input-data.blade.php       # Add course form
│   │   ├── data-kursus.blade.php      # Course list
│   │   ├── perhitungan.blade.php      # SAW calculation page
│   │   └── result.blade.php           # Ranking results
│   ├── css/
│   │   └── app.css                    # Tailwind CSS
│   └── js/
│       └── app.js                     # JavaScript entry point
└── routes/
    └── web.php                        # Application routes
```

## 🎯 Usage

### 1. Register/Login

-   Navigate to the login page
-   Register a new account or login with existing credentials

### 2. Add Courses

-   Go to **Input Data** from the sidebar
-   Fill in course details:
    -   Course Name
    -   Cost (in thousands of rupiah)
    -   Rating (0.0 - 5.0)
    -   Duration (in hours)
    -   Flexibility (1-5)
    -   Certificate quality (1-5)
    -   Last update level (1-5)
-   Click **Save New Course**

### 3. View All Courses

-   Navigate to **Data Courses**
-   View, edit, or delete existing courses
-   Courses are paginated for better performance

### 4. Calculate SAW Ranking

-   Go to **Calculation** page
-   Enter criteria weights for each factor:
    -   Cost weight
    -   Rating weight
    -   Duration weight
    -   Flexibility weight
    -   Certificate weight
    -   Last update weight
-   Total weights will be normalized to 100%
-   Click **Calculate SAW**
-   View the results including:
    -   Initial Decision Matrix
    -   Normalization Matrix
    -   Final Ranking

### 5. View Detailed Results

-   After calculation, click **View Detailed Ranking Results**
-   See comprehensive ranking with:
    -   Criteria weights used
    -   Course rankings
    -   Normalization matrix details
    -   SAW scores

## 🔬 SAW Method Explanation

The **Simple Additive Weighting (SAW)** method is a multi-criteria decision-making technique that:

1. **Normalizes** the decision matrix:

    - **Benefit criteria** (higher is better): `Rij = Xij / Max(Xij)`
    - **Cost criteria** (lower is better): `Rij = Min(Xij) / Xij`

2. **Calculates** the final score:

    - `Vi = Σ (Rij × Wj)`
    - Where:
        - `Vi` = Final score for alternative i
        - `Rij` = Normalized value
        - `Wj` = Weight for criteria j

3. **Ranks** alternatives based on the final score (higher is better)

## 🛡️ Security Features

-   **Authentication**: Laravel's built-in authentication system
-   **CSRF Protection**: All forms protected with CSRF tokens
-   **Input Validation**: Server-side validation for all inputs
-   **SQL Injection Prevention**: Eloquent ORM with parameter binding
-   **XSS Protection**: Blade templating engine auto-escapes output

## 🎨 Technologies Used

### Backend

-   **Laravel 10**: PHP framework
-   **MySQL/PostgreSQL**: Database
-   **Eloquent ORM**: Database abstraction

### Frontend

-   **Tailwind CSS**: Utility-first CSS framework
-   **Alpine.js**: Lightweight JavaScript framework
-   **Chart.js**: Data visualization library
-   **Font Awesome**: Icon library
-   **Vite**: Build tool and dev server

## 📊 Database Schema

### Tables

-   **users**: User accounts and authentication
-   **courses**: Course data (name, cost, rating, duration, etc.)
-   **calculations**: SAW calculation records with criteria weights
-   **calculation_results**: Individual course rankings and scores

## 🔧 Configuration

### Environment Variables

Key environment variables in `.env`:

-   `APP_NAME`: Application name
-   `APP_ENV`: Environment (local, production)
-   `APP_DEBUG`: Debug mode
-   `DB_*`: Database configuration
-   `SESSION_DRIVER`: Session storage driver

## 🧪 Testing

Run the test suite:

```bash
php artisan test
```

## 📝 API Routes

### Authentication Routes

-   `GET /login` - Login page
-   `POST /login` - Process login
-   `GET /register` - Registration page
-   `POST /register` - Process registration
-   `POST /logout` - Logout

### Course Routes (Protected)

-   `GET /dashboard` - Dashboard
-   `GET /input-data` - Add course form
-   `POST /input-data` - Store new course
-   `GET /all-data` - List all courses
-   `GET /all-data/{id}/edit` - Edit course
-   `PUT /all-data/{id}/update` - Update course
-   `DELETE /all-data/{id}/delete` - Delete course

### Calculation Routes (Protected)

-   `GET /perhitungan` - SAW calculation page
-   `POST /perhitungan` - Process calculation
-   `GET /result` - View ranking results

### User Routes (Protected)

-   `GET /user-detail` - User profile
-   `GET /user-detail/edit` - Edit profile
-   `PUT /user-detail` - Update profile

## 🚀 Deployment

### Production Build

```bash
# Build assets for production
npm run build

# Optimize Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Server Requirements

-   PHP >= 8.1
-   MySQL >= 5.7 or PostgreSQL >= 10
-   Web server (Apache/Nginx)
-   Composer
-   Node.js and npm

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 👤 Author

**Your Name**

-   GitHub: [@yourusername](https://github.com/yourusername)

## 🙏 Acknowledgments

-   Laravel framework
-   Tailwind CSS
-   Alpine.js
-   Chart.js
-   Font Awesome

## 📞 Support

For support, email your-email@example.com or open an issue in the repository.

---

**Note**: This application is designed for educational purposes and demonstrates the implementation of the SAW (Simple Additive Weighting) method in a web-based decision support system.
