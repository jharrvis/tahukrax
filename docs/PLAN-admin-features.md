# PLAN-admin-features.md

> **Goal:** Rebuild Admin Features (Products, Orders, Partners, Settings) using Livewire + Tailwind to replace deleted Filament resources.

## 1. Overview
Following the successful migration of the Dashboard Home, we need to rebuild the CRUD and Management pages for the admin panel. These will be implemented as Livewire components extending the new `layouts.dashboard`.

## 2. Success Criteria
*   [ ] **Products:** CRUD for Packages and Add-ons.
*   [ ] **Orders:** List view (Datatable) and Detail view (Status updates, Invoice).
*   [ ] **Partners:** list view and Detail view (Approval workflow).
*   [ ] **Shipping:** CRUD for Shipping Rates (Ongkir).
*   [ ] **Navigation:** Sidebar links are functional.

## 3. Tech Stack
*   **Base:** Laravel 11 + Livewire
*   **UI:** Tailwind CSS + Alpine.js
*   **Tables:** Custom Livewire Tables (Search, Pagination, Sort).
*   **Forms:** Livewire Forms with Real-time Validation.

## 4. Task Breakdown

### Phase 1: Product Management (Prioritas: Tinggi)
| ID | Task | Component | Input | Output | Verify |
|----|------|-----------|-------|--------|--------|
| 1.1 | Packages List | `Admin\Product\PackageIndex` | DB: `packages` | Table with Edit/Delete | List renders |
| 1.2 | Package Form | `Admin\Product\PackageForm` | Form Data | Create/Update Package | Data saved |
| 1.3 | Add-on List | `Admin\Product\AddonIndex` | DB: `addons` | Table with Edit/Delete | List renders |
| 1.4 | Add-on Form | `Admin\Product\AddonForm` | Form Data | Create/Update Add-on | Data saved |

### Phase 2: Order Management (Prioritas: Tinggi)
| ID | Task | Component | Input | Output | Verify |
|----|------|-----------|-------|--------|--------|
| 2.1 | Order List | `Admin\Order\OrderIndex` | DB: `orders` | Filterable Table | Sort/Search works |
| 2.2 | Order Detail | `Admin\Order\OrderDetail` | Order ID | View Details + Actions | Status updates work |

### Phase 3: Partner Management (Prioritas: Sedang)
| ID | Task | Component | Input | Output | Verify |
|----|------|-----------|-------|--------|--------|
| 3.1 | Partner List | `Admin\Partner\PartnerIndex` | DB: `partnerships` | Table with Status | List renders |
| 3.2 | Partner Detail | `Admin\Partner\PartnerDetail` | Partnership ID | Profile + Approval | Actions work |

### Phase 4: System Settings (Prioritas: Rendah)
| ID | Task | Component | Input | Output | Verify |
|----|------|-----------|-------|--------|--------|
| 4.1 | Shipping Rates | `Admin\Setting\ShippingRate` | DB: `shipping_rates` | CRUD Table | Rates updatable |

## 5. Implementation Strategy
We will tackle these phases sequentially. Each "Index" page will use a reusable `components/table` structure to maintain consistency.

---
**Plan Status:** DRAFT
