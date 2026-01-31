# PLAN-custom-dashboard.md

> **Goal:** Replace Filament Dashboard with Custom Design (Alpine.js + Tailwind) for Admin & Mitra roles.

## 1. Overview
User wants to migrate the Admin and Mitra dashboards from the standard Filament UI to a custom, modern design provided in `plan/design/admin.html`. The new design uses Tailwind CSS and Alpine.js. This involves creating a new layout system, migrating auth redirection, and rebuilding dashboard widgets using Livewire.

## 2. Project Type
**TYPE:** WEB (Laravel + Livewire)

## 3. Success Criteria
*   [ ] Admin triggers login → Redirects to new Custom Dashboard (`/admin/dashboard`).
*   [ ] Mitra triggers login → Redirects to new Custom Dashboard (`/mitra/dashboard`) or shared view with different data.
*   [ ] New Layout matches `admin.html` (Sidebar, Header, Dark Mode).
*   [ ] Dashboard Stats (Cards) display real data (User count, Order count, etc.).
*   [ ] Sidebar navigation fully functional (Responsive mobile + desktop).
*   [ ] Filament dependency minimized/removed for the Dashboard view.

## 4. Tech Stack
*   **Backend:** Laravel 11
*   **Frontend:** Blade Components, Tailwind CSS (Custom Config), Alpine.js (Interactivity)
*   **State Management:** Livewire (Real-time updates for stats/tables)
*   **Icons:** FontAwesome (as per design)

## 5. File Structure
```
resources/
├── css/
│   └── admin.css (Custom Tailwind directives if needed)
├── views/
│   ├── layouts/
│   │   └── dashboard.blade.php  <-- Master Layout (Sidebar + Header)
│   ├── components/
│   │   ├── admin/
│   │   │   ├── sidebar.blade.php
│   │   │   ├── header.blade.php
│   │   │   └── stat-card.blade.php
│   ├── livewire/
│   │   ├── admin/
│   │   │   └── dashboard.php    <-- Admin Logic
│   │   ├── mitra/
│   │   │   └── dashboard.php    <-- Mitra Logic
```

## 6. Task Breakdown

### Phase 1: Foundation & Layout
| ID | Task | Agent | Input | Output | Verify |
|----|------|-------|-------|--------|--------|
| 1.1 | Setup Layout Blade | `frontend-specialist` | `admin.html` | `layouts/dashboard.blade.php` | Page renders structure correctly |
| 1.2 | Extract Sidebar Component | `frontend-specialist` | `layouts/dashboard.blade.php` | `components/dashboard/sidebar.blade.php` | Sidebar renders & toggles |
| 1.3 | Extract Header Component | `frontend-specialist` | `layouts/dashboard.blade.php` | `components/dashboard/header.blade.php` | Header renders & toggles dark mode |
| 1.4 | Setup Routes & Controller | `backend-specialist` | `routes/web.php` | New Routes `/admin/dashboard`, `/mitra/dashboard` | Routes accessible by auth users |

### Phase 2: Dashboard Logic (Livewire)
| ID | Task | Agent | Input | Output | Verify |
|----|------|-------|-------|--------|--------|
| 2.1 | Create Admin Dashboard Component | `backend-specialist` | `Admin\Dashboard.php` | Livewire Component | Renders inside layout |
| 2.2 | Implement Stats Logic | `backend-specialist` | DB (Users, Orders) | Stats Data (Count, Sum) | Real numbers match DB |
| 2.3 | Create Recent Partners Table | `backend-specialist` | DB (Users) | Livewire Table View | Table confirms real users |
| 2.4 | Create Mitra Dashboard Component | `backend-specialist` | `Mitra\Dashboard.php` | Livewire Component | Renders specific Mitra data |

### Phase 3: Integration & Polish
| ID | Task | Agent | Input | Output | Verify |
|----|------|-------|-------|--------|--------|
| 3.1 | Update Auth Redirects | `backend-specialist` | `GoogleAuthController`, `Login.php` | Redirect to new routes | Login -> Custom Dashboard |
| 3.2 | Fix Responsive/Dark Mode | `frontend-specialist` | UI Check | CSS fixes | Mobile menu works, Dark mode persists |
| 3.3 | Active Menu Highlighting | `frontend-specialist` | `sidebar.blade.php` | Dynamic CSS classes | Current menu item is orange |

### Phase 4: Cleanup & Deprecation
| ID | Task | Agent | Input | Output | Verify |
|----|------|-------|-------|--------|--------|
| 4.1 | Disable Filament Routes | `backend-specialist` | `AdminPanelProvider.php` | Disabled/Commented Panel | Filament url returns 404/Redirect |
| 4.2 | Backup Filament Resources | `backend-specialist` | `app/Filament/*` | `backup/filament_resources/` | Zip/Folder created |
| 4.3 | Delete Filament Files | `backend-specialist` | `app/Filament/*` | Cleaned `app/` folder | No orphaned Filament files |
| 4.4 | Remove Filament Assets | `backend-specialist` | `public/` | Cleaned public assets | No unused vendor assets |

## 7. Phase X: Verification
*   [ ] **Lint Check:** PHP & Blade syntax valid.
*   [ ] **Mobile Test:** Sidebar opens/closes on phone.
*   [ ] **Dark Mode:** Toggles correctly and saves preference.
*   [ ] **Data Accuracy:** Stats on dashboard reflect database counts.
*   [ ] **Auth:** Admin sees Admin Data, Mitra sees Mitra Data.

---
**Plan Status:** READY
