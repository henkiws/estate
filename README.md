# 🏢 Laravel Real Estate Agency Management Platform

A comprehensive Laravel-based real estate agency management system with subscription billing, property management, and multi-agency support.

![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=flat-square&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat-square&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=flat-square&logo=mysql)
![Stripe](https://img.shields.io/badge/Stripe-Integrated-008CDD?style=flat-square&logo=stripe)

## 📋 Table of Contents

- [Features](#-features)
- [Requirements](#-requirements)
- [Installation](#-installation)
- [Configuration](#-configuration)
- [Subscription Plans](#-subscription-plans)
- [Database Structure](#-database-structure)
- [Testing](#-testing)
- [Stripe Integration](#-stripe-integration)
- [Property Management](#-property-management)
- [Security](#-security)
- [Troubleshooting](#-troubleshooting)
- [Contributing](#-contributing)
- [License](#-license)

## ✨ Features

### 🏢 Agency Management
- Multi-agency support with approval workflow
- Agency status management (pending, approved, suspended)
- Business information and contact details
- Document uploads and verification
- Agency-specific branding and customization

### 👥 Agent Management
- Multiple agents per agency
- Role-based permissions
- Agent profiles and contact information
- Performance tracking

### 🏠 Property Management
- Comprehensive property listings (Sale & Rental)
- 60+ property fields including:
  - Property identification and location
  - Detailed specifications (bedrooms, bathrooms, parking)
  - Pricing for sales and rentals
  - Property features and amenities
  - Marketing content and descriptions
- Image gallery with multiple photos per property
- Advanced search and filtering
- Property status management
- Virtual tours and video links

### 💳 Subscription System
- Three-tier subscription plans
- Stripe payment integration
- Monthly and annual billing cycles
- Automatic subscription management
- Webhook handling for payment events
- Transaction logging
- Secure payment processing

### 🔒 Security Features
- Agency approval before subscription access
- Stripe webhook signature verification
- Duplicate subscription prevention
- Role-based access control
- Secure file uploads

## 📦 Requirements

- PHP 8.2 or higher
- Composer 2.x
- MySQL 8.0 or higher
- Node.js 18.x or higher
- NPM or Yarn
- Laravel 11.x
- Stripe Account (for payments)

## 🚀 Installation

### Method 1: Quick Install (Recommended)

```bash
# Clone the repository
git clone <repository-url>
cd laravel-app

# Run the installation script
chmod +x install.sh
./install.sh
```

### Method 2: Manual Installation

```bash
# 1. Install PHP dependencies
composer install

# 2. Install Node dependencies
npm install

# 3. Create environment file
cp .env.example .env

# 4. Generate application key
php artisan key:generate

# 5. Configure database in .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password

# 6. Configure Stripe in .env
STRIPE_KEY=your_stripe_publishable_key
STRIPE_SECRET=your_stripe_secret_key
STRIPE_WEBHOOK_SECRET=your_stripe_webhook_secret

# 7. Run migrations
php artisan migrate

# 8. Seed database (optional)
php artisan db:seed

# 9. Build assets
npm run build

# 10. Start development server
php artisan serve
```

## ⚙️ Configuration

### Environment Variables

Key environment variables to configure:

```env
# Application
APP_NAME="Real Estate Platform"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=real_estate_db
DB_USERNAME=root
DB_PASSWORD=

# Stripe Configuration
STRIPE_KEY=pk_test_your_publishable_key
STRIPE_SECRET=sk_test_your_secret_key
STRIPE_WEBHOOK_SECRET=whsec_your_webhook_secret

# Subscription Plans (Price IDs from Stripe)
STRIPE_STARTER_PRICE=price_starter_monthly
STRIPE_PROFESSIONAL_PRICE=price_professional_monthly
STRIPE_ENTERPRISE_PRICE=price_enterprise_monthly

# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### Stripe Setup

1. Create a Stripe account at https://stripe.com
2. Get your API keys from Dashboard → Developers → API keys
3. Create subscription products and prices:
   - **Starter Plan**: $49 AUD/month
   - **Professional Plan**: $99 AUD/month
   - **Enterprise Plan**: $199 AUD/month
4. Set up webhook endpoint: `https://yourdomain.com/stripe/webhook`
5. Add webhook secret to `.env`

## 💰 Subscription Plans

### Starter Plan - $49 AUD/month
- Up to 5 agents
- 50 property listings
- 10 GB storage
- Email support
- Basic analytics

### Professional Plan - $99 AUD/month
- Up to 20 agents
- 200 property listings
- 50 GB storage
- Priority email support
- Advanced analytics
- Custom branding
- API access

### Enterprise Plan - $199 AUD/month
- Unlimited agents
- Unlimited property listings
- 200 GB storage
- 24/7 phone & email support
- Advanced analytics & reporting
- White-label solution
- Dedicated account manager
- API access
- Custom integrations

## 🗄️ Database Structure

### Key Tables

#### `agencies`
- Agency business information
- Status and approval workflow
- Contact details
- ABN/ACN validation

#### `agents`
- Agent profiles
- Agency relationships
- Contact information
- License numbers

#### `properties`
- Property listings
- Sale and rental information
- Specifications and features
- Location data
- Pricing information

#### `property_images`
- Property photo galleries
- Image metadata
- Primary image designation

#### `subscriptions`
- Active subscriptions
- Stripe subscription IDs
- Billing periods
- Plan information

#### `subscription_transactions`
- Payment history
- Transaction details
- Stripe event tracking

## 🧪 Testing

### Run Tests

```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature

# Run with coverage
php artisan test --coverage
```

### Test Stripe Integration

Use Stripe test cards:

```
# Successful payment
4242 4242 4242 4242

# Requires authentication
4000 0025 0000 3155

# Declined card
4000 0000 0000 9995

# Expired card: Use any past date
# CVC: Any 3 digits
# ZIP: Any 5 digits
```

### Webhook Testing

```bash
# Install Stripe CLI
# Forward webhooks to local server
stripe listen --forward-to localhost:8000/stripe/webhook

# Trigger test events
stripe trigger payment_intent.succeeded
stripe trigger customer.subscription.created
```

## 🔌 Stripe Integration

### Key Features

1. **Subscription Creation**
   - Checkout session creation
   - Plan selection
   - Success/cancel URLs

2. **Webhook Handling**
   - `checkout.session.completed` - New subscription
   - `customer.subscription.updated` - Subscription changes
   - `customer.subscription.deleted` - Cancellations
   - `invoice.payment_succeeded` - Successful payments
   - `invoice.payment_failed` - Failed payments

3. **Security**
   - Webhook signature verification
   - Agency status validation
   - Duplicate subscription prevention

### Routes

```php
// Subscription routes
Route::get('/subscription/plans', [SubscriptionController::class, 'plans']);
Route::post('/subscription/checkout', [SubscriptionController::class, 'checkout']);
Route::get('/subscription/success', [SubscriptionController::class, 'success']);
Route::get('/subscription/cancel', [SubscriptionController::class, 'cancel']);
Route::post('/stripe/webhook', [StripeWebhookController::class, 'handleWebhook']);
```

## 🏠 Property Management

### Property Types
- **Sale**: Properties for purchase
- **Rent**: Rental properties

### Property Features

**Basic Information:**
- Property ID, Title, Description
- Property Type (House, Apartment, Villa, etc.)
- Listing Type (Sale/Rent)
- Status (Active, Pending, Sold, Rented)

**Location:**
- Street Address
- Suburb, State, Postcode, Country
- Latitude/Longitude coordinates

**Specifications:**
- Bedrooms, Bathrooms
- Parking Spaces
- Land Size, Floor Size
- Year Built, Property Age

**Pricing:**
- Sale: Price, Price Display, Negotiable
- Rent: Rent Amount, Rent Period, Bond, Available Date

**Features:**
- Air Conditioning, Heating, Pool
- Garage, Alarm System, Balcony
- Garden, Gym, Study Room

**Marketing:**
- Headline, Marketing Description
- Video URL, Virtual Tour URL
- Featured Property

### Property Images
- Multiple images per property
- Primary image designation
- Automatic thumbnail generation
- Secure file storage

## 🔒 Security

### Best Practices Implemented

1. **Authentication & Authorization**
   - Laravel Breeze authentication
   - Role-based access control
   - Agency-specific data isolation

2. **Payment Security**
   - PCI-compliant Stripe integration
   - No credit card data stored
   - Webhook signature verification

3. **Data Protection**
   - SQL injection prevention (Eloquent ORM)
   - XSS protection (Blade templating)
   - CSRF protection (Laravel middleware)
   - Secure password hashing

4. **File Uploads**
   - Validated file types
   - Size restrictions
   - Secure storage paths
   - Sanitized filenames

5. **API Security**
   - Rate limiting
   - API token authentication
   - Request validation

## 🐛 Troubleshooting

### Common Issues

#### Stripe Webhook Not Working
```bash
# Check webhook secret in .env
STRIPE_WEBHOOK_SECRET=whsec_xxx

# Verify webhook endpoint is publicly accessible
# Check Stripe dashboard for webhook delivery attempts
# Review webhook logs: php artisan log:tail
```

#### Database Migration Errors
```bash
# Reset database
php artisan migrate:fresh

# Run migrations step by step
php artisan migrate --step

# Check specific migration
php artisan migrate:status
```

#### Asset Compilation Issues
```bash
# Clear cache
npm run build
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Rebuild
npm install
npm run build
```

#### Permission Errors
```bash
# Fix storage permissions
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### Debug Mode

Enable detailed error messages in development:

```env
APP_DEBUG=true
APP_ENV=local
```

**⚠️ Never enable debug mode in production!**

## 📝 API Documentation

### Authentication
```bash
# Get API token
POST /api/login
{
  "email": "user@example.com",
  "password": "password"
}
```

### Properties API
```bash
# List properties
GET /api/properties

# Get single property
GET /api/properties/{id}

# Create property
POST /api/properties

# Update property
PUT /api/properties/{id}

# Delete property
DELETE /api/properties/{id}
```

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

### Coding Standards
- Follow PSR-12 coding standards
- Write tests for new features
- Update documentation
- Follow Laravel best practices

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🙏 Acknowledgments

- [Laravel](https://laravel.com) - The PHP Framework
- [Stripe](https://stripe.com) - Payment Processing
- [Tailwind CSS](https://tailwindcss.com) - CSS Framework
- [Alpine.js](https://alpinejs.dev) - JavaScript Framework

## 📞 Support

For support, email support@example.com or join our Slack channel.

## 🗺️ Roadmap

- [ ] Advanced property search filters
- [ ] Property comparison tool
- [ ] CRM integration
- [ ] Mobile app (iOS/Android)
- [ ] Email marketing automation
- [ ] Advanced analytics dashboard
- [ ] Multi-language support
- [ ] Third-party integrations (Domain, REA)
- [ ] Automated property valuations
- [ ] Lead management system

---

**Built with ❤️ using Laravel**