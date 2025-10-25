# Catalogs Package

A Laravel package for managing catalogs with polymorphic relationships, allowing you to categorize and organize any model in your application.

## Features

- 📁 **Flexible Catalog Management** - Create and manage catalogs with hierarchical organization
- 🔗 **Polymorphic Relationships** - Attach catalogs to any model in your application
- 🎨 **SEO Friendly** - Built-in support for meta titles, descriptions, and keywords
- 📸 **Image Support** - Upload and manage catalog images
- 🔢 **Custom Ordering** - Control the display order of catalogs and related models
- 👥 **User Tracking** - Track who created and updated each catalog
- 🗑️ **Soft Deletes** - Safely delete catalogs with the ability to restore
- 🚦 **Status Management** - Enable/disable catalogs with status control
- 🔐 **Policy Based Authorization** - Built-in policies for catalog management
- 🌐 **API Ready** - RESTful API routes included

## Requirements

- PHP ^8.2
- Laravel ^8.12|^9.0|^10.0|^11.0|^12.0

## Installation

### 1. Install via Composer

```bash
composer require mortezaa97/catalogs
```

### 2. Publish Configuration (Optional)

```bash
php artisan vendor:publish --provider="Mortezaa97\Catalogs\CatalogsServiceProvider" --tag="config"
```

### 3. Publish Migrations (Optional)

If you want to customize the migrations:

```bash
php artisan vendor:publish --provider="Mortezaa97\Catalogs\CatalogsServiceProvider" --tag="migrations"
```

### 4. Run Migrations

```bash
php artisan migrate
```

## Database Structure

### Catalogs Table

The main catalogs table includes:

- `id` - Primary key
- `title` - Catalog title
- `slug` - URL-friendly slug
- `desc` - Long text description
- `image` - Image path
- `page_title` - Custom page title
- `meta_title` - SEO meta title
- `meta_desc` - SEO meta description
- `meta_keywords` - JSON array of keywords
- `order` - Display order (default: 0)
- `status` - Active/Inactive status
- `created_by` - Foreign key to users table
- `updated_by` - Foreign key to users table
- `deleted_at` - Soft delete timestamp
- `created_at` / `updated_at` - Timestamps

### Model Has Catalogs Table

Polymorphic pivot table for attaching catalogs to models:

- `id` - Primary key
- `catalog_id` - Foreign key to catalogs table
- `model_id` - Polymorphic ID
- `model_type` - Polymorphic type
- `created_at` / `updated_at` - Timestamps

Unique constraint on `[catalog_id, model_id, model_type]`

## Usage

### Basic Usage

#### Creating a Catalog

```php
use Mortezaa97\Catalogs\Models\Catalog;

$catalog = Catalog::create([
    'title' => 'Electronics',
    'slug' => 'electronics',
    'desc' => 'All electronic products',
    'image' => 'path/to/image.jpg',
    'page_title' => 'Electronics | MyStore',
    'meta_title' => 'Buy Electronics Online',
    'meta_desc' => 'Shop the latest electronics',
    'meta_keywords' => ['electronics', 'gadgets', 'tech'],
    'order' => 1,
    'status' => 1,
    'created_by' => auth()->id(),
]);
```

#### Retrieving Catalogs

```php
// Get all catalogs (ordered by created_at desc)
$catalogs = Catalog::all();

// Get active catalogs
$activeCatalogs = Catalog::where('status', 1)->get();

// Get catalog by slug
$catalog = Catalog::where('slug', 'electronics')->first();
```

### Working with Polymorphic Relationships

#### Attach a Catalog to a Model

```php
use Mortezaa97\Catalogs\Models\ModelHasCatalog;

// Attach a product to a catalog
ModelHasCatalog::create([
    'catalog_id' => $catalog->id,
    'model_id' => $product->id,
    'model_type' => get_class($product),
]);
```

#### Using in Your Models

Add the relationship to your model:

```php
use Illuminate\Database\Eloquent\Model;
use Mortezaa97\Catalogs\Models\Catalog;

class Product extends Model
{
    public function catalogs()
    {
        return $this->morphToMany(
            Catalog::class,
            'model',
            'model_has_catalogs'
        )->withTimestamps();
    }
}
```

Then use it:

```php
// Get all catalogs for a product
$catalogs = $product->catalogs;

// Get all products in a catalog
$products = $catalog->products;

// Attach a product to a catalog
$product->catalogs()->attach($catalog->id);

// Detach a product from a catalog
$product->catalogs()->detach($catalog->id);

// Sync catalogs for a product
$product->catalogs()->sync([1, 2, 3]);
```

### Using the Facade

```php
use Catalogs;

// Use the facade for custom functionality
// (Extend the main Catalogs class as needed)
```

## API Routes

The package includes API route scaffolding. You can define your routes in:

```
packages/mortezaa97/catalogs/routes/api.php
```

## Authorization

The package includes built-in policies:

- `CatalogPolicy` - For catalog CRUD operations
- `ModelHasCatalogPolicy` - For managing catalog relationships

### Gates

The policies are automatically registered with Laravel's Gate system:

```php
// Check if user can view catalog
if (Gate::allows('view', $catalog)) {
    // User can view
}

// Check if user can create catalog
if (Gate::allows('create', Catalog::class)) {
    // User can create
}
```

## Configuration

After publishing the config file, you can customize settings in `config/catalogs.php`:

```php
return [
    // Add your custom configuration here
];
```

## Models

### Catalog Model

Main model for catalogs with:
- Soft deletes support
- Automatic ordering by created_at
- Relationships to User (created_by, updated_by)
- Polymorphic relationship to products (or any model)

### ModelHasCatalog Model

Pivot model for polymorphic relationships with:
- Automatic ordering by created_at
- Relationship to Catalog

## Testing

Run the test suite:

```bash
composer test
```

Generate coverage report:

```bash
composer test-coverage
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email mortezajafari76@gmail.com instead of using the issue tracker.

## Credits

- [Morteza Jafari](https://github.com/mortezaa97)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Support

For support, please open an issue on GitHub or contact mortezajafari76@gmail.com.

