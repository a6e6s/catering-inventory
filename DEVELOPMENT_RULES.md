# Development Rules & Standards

This document outlines the mandatory development standards for this project. All contributors must adhere to these rules to ensure code quality, maintainability, and consistency.

## 1. Filament v5 Architecture & Standards

### **Mandatory Rules**

#### **1.1. Filament Version Compliance**
*   All implementations must be fully compatible with **Filament v5**.
*   **DO NOT** use deprecated APIs from earlier versions (v2, v3, v4).
*   Follow the official Filament v5 folder structure and conventions.

#### **1.2. Namespaces & Structure**
*   Use correct and consistent namespaces:
    *   `App\Filament\Resources`
    *   `App\Filament\Pages`
    *   `App\Filament\Widgets`
    *   `App\Filament\RelationManagers`
*   Follow **PSR-4** autoloading standards.
*   **DO NOT** place Filament-related logic outside designated directories.

#### **1.3. Component Usage**
*   Use only **native Filament v5 components**.
*   **Avoid** custom Blade views unless explicitly approved.
*   **DO NOT** inject raw HTML, inline styles, or external UI frameworks.

#### **1.4. Code Style & Best Practices**
*   Follow **Laravel** and **Filament v5** coding standards.
*   Use **strict typing** where applicable.
*   Apply proper **dependency injection**.
*   Use **Enums** and **DTOs** when appropriate to structure data.
*   Keep components **modular** and **reusable**.

#### **1.5. Resource & Manager Design**
*   Structure Resources, Pages, and Relation Managers according to Filament v5 patterns.
*   **Separate concerns** between forms, tables, and actions.
*   **Avoid** placing business logic inside view components; move it to Models, Services, or Actions.

#### **1.6. Testing & Quality**
*   Write **feature** and **unit tests** for new Filament components.
*   Ensure compatibility with existing modules.
*   Perform code reviews before merging.

---

## 2. Localization & Internationalization

### **Mandatory Rules**

#### **2.1. Language Support**
*   Every new and existing resource page must support localization.
*   **Arabic translations** must be complete, accurate, and user-friendly (Right-to-Left support where applicable).

#### **2.2. Translation Implementation**
*   All labels, titles, buttons, messages, notifications, and placeholders **MUST** be translatable.
*   **Avoid hardcoded text** in components.
*   **No static or inline strings** are allowed in resources, forms, or tables.
*   Use Laravel's translation helpers (e.g., `__('key')` or `trans('key')`).
*   Store translations in `lang/` directory (e.g., `lang/en/messages.php`, `lang/ar/messages.php`).

---

## 3. Validation & Enforcement

*   **Reject** any implementation that:
    *   Uses outdated Filament versions.
    *   Breaks namespace conventions.
    *   Introduces custom UI outside Filament.
    *   Violates project architecture.
    *   Contains hardcoded strings instead of translation keys.

*   All code must pass automated linting and static analysis.

---

### **Expected Outcome**
*   A consistent, maintainable, and future-proof Filament v5 codebase.
*   Easier upgrades and reduced technical debt.
*   Improved developer collaboration and onboarding.
*   A fully localized application accessible to Arabic and English speaking users.
