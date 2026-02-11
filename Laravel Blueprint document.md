 I'll open the Laravel Blueprint documentation to understand its structure and generate a comprehensive reference with examples.  
 Let me explore more of the Blueprint documentation to understand all available syntax and features.  
  Now let me search for more specific details about model attributes, data types, and advanced features.    
  Now let me search for more information about Blueprint's specific features like views, events, jobs, mailables, and tests.    
  Based on my comprehensive research of the Laravel Blueprint documentation, I can now create a complete reference guide with examples for all major features. Let me compile this information into a structured reference document.    
  Let me search for more specific Blueprint documentation about advanced features.    
  Now I have gathered comprehensive information about Laravel Blueprint. Let me create a complete reference documentation with examples for all the major features. I'll organize this into a clear, structured format.     Based on my research of the Laravel Blueprint documentation and ecosystem, here is a comprehensive reference guide with examples for all major features:

---

# Laravel Blueprint Complete Reference

## Overview

Blueprint is a code generation tool for Laravel that uses a simple YAML syntax to generate multiple components (models, controllers, migrations, factories, tests, etc.) from a single definition file.

**Key Principles:**
1. Increase development speed
2. Promote Laravel conventions

---

## 1. Installation & Setup

```bash
# Install via Composer
composer require --dev laravel-shift/blueprint

# Create a new draft file
php artisan blueprint:new

# Create with configuration file
php artisan blueprint:new --config

# Publish configuration separately
php artisan vendor:publish --tag=blueprint-config

# Build from draft.yaml
php artisan blueprint:build

# Build from specific file
php artisan blueprint:build custom-draft.yaml
```

---

## 2. Models

### Basic Model Definition

```yaml
models:
  Post:
    title: string:400
    content: longtext
    published_at: nullable timestamp
    author_id: id:user
```

### Data Types & Attributes

| Type | Syntax | Example |
|------|--------|---------|
| **id** | `id` or `id:model` | `user_id: id:user` |
| **string** | `string:length` | `name: string:100` |
| **integer** | `integer` | `views: integer` |
| **bigInteger** | `bigInteger` | `big_id: bigInteger` |
| **decimal** | `decimal:precision,scale` | `price: decimal:8,2` |
| **float** | `float` | `rating: float` |
| **boolean** | `boolean` | `is_active: boolean` |
| **date** | `date` | `birth_date: date` |
| **datetime** | `datetime` | `scheduled_at: datetime` |
| **timestamp** | `timestamp` | `created_at: timestamp` |
| **text** | `text` | `description: text` |
| **longtext** | `longtext` | `content: longtext` |
| **mediumtext** | `mediumtext` | `summary: mediumtext` |
| **json** | `json` | `metadata: json` |
| **jsonb** | `jsonb` | `settings: jsonb` |
| **binary** | `binary` | `file_data: binary` |
| **enum** | `enum:value1,value2` | `status: enum:pending,active,archived` |
| **uuid** | `uuid` | `uuid: uuid` |
| **ipAddress** | `ipAddress` | `last_ip: ipAddress` |
| **macAddress** | `macAddress` | `device_mac: macAddress` |

### Column Modifiers

```yaml
models:
  Product:
    # Basic modifiers
    sku: string:50 index
    slug: string unique
    email: string:255 unique nullable
    status: enum:active,inactive default:active
    
    # Foreign keys with constraints
    user_id: id:user foreign onDelete:cascade
    category_id: id foreign:categories onUpdate:cascade
    
    # Advanced modifiers
    price: decimal:8,2 unsigned default:0.00
    description: text nullable comment:Product description
    priority: integer default:0 index
    code: string:20 primary
    remember_token: nullable string:100
    
    # Special columns
    timestamps: true        # created_at & updated_at
    softdeletes: true       # deleted_at
```

### Complete Model Example

```yaml
models:
  Product:
    name: string:500
    slug: string unique
    description: longtext nullable
    sku: string:50 index
    price: decimal:8,2 unsigned default:0.00
    compare_price: decimal:8,2 unsigned nullable
    cost_per_item: decimal:8,2 unsigned nullable
    quantity: integer unsigned default:0
    weight: decimal:8,2 nullable
    status: enum:draft,active,archived default:draft
    featured: boolean default:false
    meta_title: string:255 nullable
    meta_description: text nullable
    published_at: nullable timestamp
    user_id: id:user foreign onDelete:cascade
    category_id: id:category foreign onDelete:set null
    tags: json nullable
    timestamps: true
    softdeletes: true
    
    relationships:
      belongsTo: User, Category
      hasMany: Variant, Review
      belongsToMany: Tag, Collection
```

---

## 3. Relationships

### Relationship Types

```yaml
models:
  Post:
    title: string
    content: longtext
    user_id: id:user
    
    relationships:
      # One-to-Many (Post has many Comments)
      hasMany: Comment
      
      # Many-to-One (Post belongs to User)
      belongsTo: User
      
      # Many-to-Many (Post belongs to many Tags)
      belongsToMany: Tag
      
      # One-to-One (Post has one SeoMetadata)
      hasOne: SeoMetadata
      
      # Aliased relationships
      hasMany: Comment:reply  # Method will be replies()
      
      # Fully qualified class names
      belongsTo: \Spatie\LaravelPermission\Models\Role
      
      # Intermediate model for belongsToMany
      belongsToMany: Team:&Membership  # Uses Membership as pivot model
```

### Relationship with Pivot Columns

```yaml
models:
  User:
    name: string
    relationships:
      belongsToMany: Role
      
  Role:
    name: string
    level: integer
```

Blueprint automatically generates the pivot table `role_user` for many-to-many relationships.

---

## 4. Controllers

### Basic Controller Actions

```yaml
controllers:
  Post:
    index:
      query: all
      render: post.index with:posts
      
    create:
      render: post.create
      
    store:
      validate: title, content, author_id
      save: post
      redirect: post.index
      
    show:
      render: post.show with:post
      
    edit:
      render: post.edit with:post
      
    update:
      validate: title, content
      update: post
      redirect: post.index
      
    destroy:
      delete: post
      redirect: post.index
```

### Controller Statements Reference

| Statement | Description | Example |
|-----------|-------------|---------|
| **query** | Retrieve models | `query: all`, `query: find:post`, `query: where:status,active` |
| **find** | Find specific model | `find: post` |
| **validate** | Validate request | `validate: title, content` or `validate: post` |
| **save** | Save model | `save: post` |
| **update** | Update model | `update: post` or `update: title, content` |
| **delete** | Delete model | `delete: post` |
| **render** | Return view | `render: post.index with:posts` |
| **redirect** | Redirect response | `redirect: post.index`, `redirect: post.show with:post` |
| **flash** | Flash message | `flash: post.title` |
| **fire** | Fire event | `fire: PostCreated with:post` |
| **dispatch** | Dispatch job | `dispatch: ProcessPost with:post` |
| **send** | Send mailable | `send: PostNotification to:user.email with:post` |
| **notify** | Send notification | `notify: UserNotification to:user with:post` |

### Advanced Controller Example

```yaml
controllers:
  Post:
    index:
      query: all:posts
      render: post.index with:posts
      
    store:
      validate: title, content, author_id, status
      save: post
      fire: PostCreated with:post
      dispatch: ProcessPostImages with:post
      dispatch: NotifySubscribers with:post
      send: NewPostNotification to:admin@example.com with:post
      flash: post.title
      redirect: post.show with:post
      
    publish:
      find: post
      update: status
      fire: PostPublished with:post
      flash: Post published successfully
      redirect: post.show with:post
      
    feature:
      find: post
      update: featured
      dispatch: UpdateSearchIndex with:post
      redirect: post.index
      
    destroy:
      delete: post
      fire: PostDeleted with:post
      dispatch: CleanupPostAssets with:post
      flash: Post deleted
      redirect: post.index
```

### Resource Controllers (Shorthand)

```yaml
controllers:
  Post:
    resource: web  # Generates index, create, store, show, edit, update, destroy
    
  Api\Post:
    resource: api   # Generates API resource controller
    # Or specify actions explicitly
    index:
      query: all
      respond: posts
      
    store:
      validate: title, content
      save: post
      respond: post
      
    show:
      respond: post
      
    update:
      validate: title, content
      update: post
      respond: post
      
    destroy:
      delete: post
      respond: 204
```

### Invokable Controllers

```yaml
controllers:
  Report:
    invokable:
      query: all:posts
      render: report with:posts
      
  GenerateInvoice:
    invokable:
      find: order
      dispatch: GenerateInvoiceJob with:order
      redirect: orders.show with:order
```

---

## 5. Seeders

```yaml
seeders:
  # Simple seeder reference
  User:
    - name: 'John Doe'
      email: 'john@example.com'
      password: 'password'
      
    - name: 'Jane Smith'
      email: 'jane@example.com'
      password: 'password'
      
  # Multiple seeders
  Category:
    - name: 'Technology'
      slug: 'technology'
    - name: 'Business'
      slug: 'business'
    - name: 'Lifestyle'
      slug: 'lifestyle'
```

---

## 6. Complete Example: Blog System

```yaml
models:
  User:
    name: string
    email: string unique
    email_verified_at: nullable timestamp
    password: string
    remember_token: nullable string:100
    timestamps: true
    softdeletes: true
    
    relationships:
      hasMany: Post, Comment
      
  Category:
    name: string:100
    slug: string unique
    description: text nullable
    timestamps: true
    
    relationships:
      hasMany: Post
      
  Post:
    title: string:400
    slug: string unique
    excerpt: text nullable
    content: longtext
    featured_image: string:500 nullable
    status: enum:draft,published,archived default:draft
    published_at: nullable timestamp
    user_id: id:user foreign onDelete:cascade
    category_id: id:category foreign onDelete:set null
    meta_title: string:255 nullable
    meta_description: text nullable
    timestamps: true
    softdeletes: true
    
    relationships:
      belongsTo: User, Category
      hasMany: Comment
      belongsToMany: Tag
      
  Tag:
    name: string:50
    slug: string unique
    timestamps: true
    
    relationships:
      belongsToMany: Post
      
  Comment:
    content: text
    user_id: id:user foreign onDelete:cascade
    post_id: id:post foreign onDelete:cascade
    approved: boolean default:false
    timestamps: true
    
    relationships:
      belongsTo: User, Post

seeders:
  Category:
    - name: 'Laravel'
      slug: 'laravel'
    - name: 'PHP'
      slug: 'php'
    - name: 'JavaScript'
      slug: 'javascript'
      
  Tag:
    - name: 'Tutorial'
      slug: 'tutorial'
    - name: 'Tips'
      slug: 'tips'
    - name: 'News'
      slug: 'news'

controllers:
  Post:
    resource: web
    
    # Custom actions
    publish:
      find: post
      update: status
      fire: PostPublished with:post
      flash: Post published successfully
      redirect: post.show with:post
      
    archive:
      find: post
      update: status
      fire: PostArchived with:post
      flash: Post archived
      redirect: post.index
      
  Api\Post:
    resource: api
    
    featured:
      query: where:featured,1
      respond: posts
      
  Comment:
    store:
      validate: content, post_id
      save: comment
      fire: CommentCreated with:comment
      send: NewCommentNotification to:post.user.email with:comment
      redirect: post.show with:comment.post
      
    approve:
      find: comment
      update: approved
      fire: CommentApproved with:comment
      redirect: post.show with:comment.post
```

---

## 7. Generated Components

From a single `draft.yaml` file, Blueprint generates:

| Component | Description |
|-----------|-------------|
| **Models** | Eloquent models with fillable, casts, relationships |
| **Migrations** | Database schema migrations |
| **Factories** | Model factories with fake data |
| **Controllers** | HTTP controllers with actions |
| **Form Requests** | Validation classes |
| **Views** | Basic Blade templates |
| **Routes** | Route definitions |
| **Events** | Event classes |
| **Jobs** | Queue job classes |
| **Mailables** | Email classes |
| **Tests** | Feature and unit tests |

---

## 8. Configuration Options

```php
// config/blueprint.php
return [
    'namespace' => 'App',
    'models_namespace' => 'Models',
    'controllers_namespace' => 'Http\\Controllers',
    
    'paths' => [
        'models' => app_path('Models'),
        'controllers' => app_path('Http/Controllers'),
        'migrations' => database_path('migrations'),
        'factories' => database_path('factories'),
        'seeders' => database_path('seeders'),
        'tests' => base_path('tests'),
        'views' => resource_path('views'),
    ],
    
    'generate' => [
        'models' => true,
        'migrations' => true,
        'factories' => true,
        'controllers' => true,
        'form_requests' => true,
        'events' => true,
        'jobs' => true,
        'mailables' => true,
        'tests' => true,
        'views' => true,
    ],
    
    'use_constraints' => true,      // Foreign key constraints
    'use_guarded' => false,         // Use $guarded vs $fillable
    'fake_nullables' => true,       // Generate fake data for nullable fields
];
```

---

## 9. Best Practices

1. **Plan First**: Design your database schema before writing YAML
2. **Use Conventions**: Follow Laravel naming conventions (singular models, plural tables)
3. **Incremental Development**: Add entities gradually rather than all at once
4. **Version Control**: Commit your `draft.yaml` file
5. **Post-Customization**: Use Blueprint as a starting point, then customize generated code
6. **Resource Controllers**: Prefer `resource: web` or `resource: api` for standard CRUD
7. **Relationships**: Define both sides of relationships explicitly
8. **Validation**: Use `validate: model` to auto-generate all validation rules

---

## 10. Common Patterns

### E-commerce System

```yaml
models:
  Product:
    name: string:500
    sku: string:50 unique
    price: decimal:8,2
    stock_quantity: integer default:0
    relationships:
      belongsToMany: Order
      
  Order:
    order_number: string unique
    total: decimal:8,2
    status: enum:pending,paid,shipped,cancelled
    relationships:
      belongsTo: User
      belongsToMany: Product
      
controllers:
  Order:
    store:
      validate: user_id, products, total
      save: order
      fire: OrderCreated with:order
      send: OrderConfirmation to:user.email with:order
      redirect: order.show with:order
```

### API Resources

```yaml
controllers:
  Api\Product:
    resource: api
    
    index:
      query: all
      respond: products
      
    store:
      validate: name, price, stock_quantity
      save: product
      respond: product 201
      
    show:
      respond: product
      
    update:
      validate: name, price
      update: product
      respond: product
      
    destroy:
      delete: product
      respond: 204
```

This reference covers the complete Laravel Blueprint DSL syntax. The YAML-based approach allows you to scaffold entire Laravel applications rapidly while maintaining convention and consistency.