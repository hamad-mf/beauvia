# Beauvia — White Minimalist Theme Conversion Guide

> **Objective:** Convert the entire Beauvia project from its current **dark/glassmorphism theme** to a **clean white minimalist theme**.  
> **Scope:** Color theme only — **DO NOT change layouts, component structure, or page logic.**  
> **Approach:** Page-by-page, incremental conversion. Each page/file can be done independently.

---

## ⚠️ IMPORTANT — Pre-Conversion Check

**Before touching ANY file, first check if it has already been converted.**

A page is **already converted** if it meets ALL of these criteria:
- ✅ Body/page background is **white** (`bg-white`) or very light (`bg-gray-50`)
- ✅ Primary text color is **dark** (`text-gray-900`, `text-gray-800`)
- ✅ No `bg-dark-*` or `bg-white/5` or `bg-white/10` glass-effect classes remain
- ✅ No `text-white` used as primary readable text on dark backgrounds
- ✅ Cards use light backgrounds (`bg-white`, `bg-gray-50`) with subtle shadows instead of glass-card effects
- ✅ Borders use light grays (`border-gray-200`, `border-gray-100`) instead of `border-white/*`

**If the page is already converted → SKIP IT. Move to the next file.**

---

## 🎨 Target Design Language

| Element | Current (Dark) | Target (White Minimalist) |
|---|---|---|
| **Page background** | `bg-dark-950` (#020617) | `bg-white` or `bg-gray-50` |
| **Card background** | `bg-white/5 backdrop-blur-xl border-white/10` (glass) | `bg-white shadow-sm border border-gray-200 rounded-2xl` |
| **Card hover** | `hover:bg-white/10 hover:border-white/20` | `hover:shadow-md hover:border-gray-300` |
| **Primary text** | `text-white` | `text-gray-900` |
| **Secondary text** | `text-dark-300`, `text-dark-400` | `text-gray-500`, `text-gray-600` |
| **Muted text** | `text-dark-500`, `text-dark-600` | `text-gray-400` |
| **Headings** | `text-white` | `text-gray-900` |
| **Links/Accents** | `text-primary-400` | `text-primary-600` |
| **Gradient text** | `from-primary-400 to-coral-400` | `from-primary-600 to-primary-500` (or just solid `text-primary-600`) |
| **Borders** | `border-white/5`, `border-white/10` | `border-gray-100`, `border-gray-200` |
| **Inputs** | `bg-white/5 border-white/10 text-white placeholder-dark-400` | `bg-white border-gray-300 text-gray-900 placeholder-gray-400` |
| **Buttons (primary)** | `bg-gradient-to-r from-primary-600 to-primary-500` | Keep as-is (accent colors stay) |
| **Buttons (secondary)** | `bg-white/10 text-white border-white/20` | `bg-gray-100 text-gray-700 border-gray-300` or `bg-white border-gray-300 text-gray-700` |
| **Nav scrolled bg** | `bg-dark-950/80 backdrop-blur-xl` | `bg-white/80 backdrop-blur-xl shadow-sm` |
| **Sidebar bg** | `bg-dark-900/50 backdrop-blur-xl border-white/5` | `bg-white border-gray-200` |
| **Dropdown bg** | `glass-card` (dark translucent) | `bg-white shadow-lg border border-gray-200` |
| **Badges** | `bg-primary-500/20 text-primary-300 border-primary-500/30` | `bg-primary-50 text-primary-700 border-primary-200` |
| **Scrollbar** | `track: #0f172a, thumb: #334155` | `track: #f9fafb, thumb: #d1d5db` |
| **Hero gradient bg** | `bg-hero-gradient` (dark purples) | `bg-gradient-to-br from-primary-50 via-white to-gray-50` |
| **Hero floating blobs** | `bg-primary-600/20`, `bg-coral-500/15` | `bg-primary-100/50`, `bg-pink-100/40` (softer, lighter) |
| **Bottom fade** | `from-dark-950 to-transparent` | `from-white to-transparent` |
| **Noise overlay** | Dark noise at 0.02 opacity | Remove or keep at 0.01 opacity with inverted overlay |

---

## 📁 File-by-File Conversion Checklist

Work through these files **in order** — start with global/shared files first (CSS, Tailwind config, layouts), then page-specific files.

### PART 1: Global Foundation (Do These First)

These files affect ALL pages. Convert them first.

---

#### 1.1 `tailwind.config.js`
**Path:** `d:\WORK\Beauvia\tailwind.config.js`

**Changes:**
- Update the `dark` color palette to work as light neutral grays (or simply stop using them and use Tailwind built-in `gray-*`)
- Update `hero-gradient` to a light gradient:
  ```js
  'hero-gradient': 'linear-gradient(135deg, #f5f3ff 0%, #ede9fe 50%, #f9fafb 100%)',
  ```
- Keep `primary` palette as-is (purple accents work in both themes)
- Keep `coral` as-is (accent color)
- Keep animations as-is (layout not changing)
- The `glow` keyframe can be toned down:
  ```js
  glow: {
      '0%': { boxShadow: '0 0 20px rgba(124, 58, 237, 0.1)' },
      '100%': { boxShadow: '0 0 40px rgba(124, 58, 237, 0.15)' },
  },
  ```

---

#### 1.2 `resources/css/app.css`
**Path:** `d:\WORK\Beauvia\resources\css\app.css`

**Current → Target changes:**

```css
/* ===== BASE LAYER ===== */
@layer base {
    body {
        /* OLD: @apply bg-dark-950 text-white font-sans antialiased; */
        @apply bg-white text-gray-900 font-sans antialiased;
    }
}

/* ===== COMPONENTS LAYER ===== */
@layer components {
    .glass-card {
        /* OLD: @apply bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl; */
        @apply bg-white border border-gray-200 rounded-2xl shadow-sm;
    }
    .glass-card-hover {
        /* OLD: @apply glass-card transition-all duration-300 hover:bg-white/10 hover:border-white/20 hover:shadow-xl hover:shadow-primary-600/10 hover:-translate-y-1; */
        @apply glass-card transition-all duration-300 hover:shadow-md hover:border-gray-300 hover:-translate-y-1;
    }
    .btn-primary {
        /* Keep as-is — purple gradient buttons still work on white */
    }
    .btn-secondary {
        /* OLD: @apply ... bg-white/10 text-white ... border-white/20 ... hover:bg-white/20 hover:border-white/30; */
        @apply inline-flex items-center justify-center px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl border border-gray-300 transition-all duration-300 hover:bg-gray-200 hover:border-gray-400;
    }
    .btn-coral {
        /* Keep as-is — coral gradient buttons still work on white */
    }
    .input-dark {
        /* OLD: @apply ... bg-white/5 border-white/10 ... text-white placeholder-dark-400 focus:border-primary-500 ...; */
        @apply w-full bg-white border border-gray-300 rounded-xl px-4 py-3 text-gray-900 placeholder-gray-400 focus:border-primary-500 focus:ring-1 focus:ring-primary-500 focus:outline-none transition-colors;
        /* NOTE: Consider renaming to .input-field in the future, but for now keep the class name to avoid layout breakage */
    }
    .badge {
        /* Keep as-is */
    }
    .section-title {
        /* Keep as-is (font-display text-3xl md:text-4xl font-bold) */
    }
    .section-subtitle {
        /* OLD: @apply text-dark-400 text-lg mt-2; */
        @apply text-gray-500 text-lg mt-2;
    }
    .gradient-text {
        /* OLD: @apply bg-gradient-to-r from-primary-400 to-coral-400 bg-clip-text text-transparent; */
        @apply bg-gradient-to-r from-primary-600 to-primary-500 bg-clip-text text-transparent;
    }
    .stat-card {
        /* Inherits from glass-card — no change needed beyond glass-card update */
    }
}

/* ===== SCROLLBAR ===== */
::-webkit-scrollbar { width: 8px; }
/* OLD: ::-webkit-scrollbar-track { background: #0f172a; } */
::-webkit-scrollbar-track { background: #f9fafb; }
/* OLD: ::-webkit-scrollbar-thumb { background: #334155; border-radius: 4px; } */
::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 4px; }
/* OLD: ::-webkit-scrollbar-thumb:hover { background: #475569; } */
::-webkit-scrollbar-thumb:hover { background: #9ca3af; }

/* ===== RATING STARS ===== */
.star-rating .star {
    /* OLD: @apply text-dark-600 ...; */
    @apply text-gray-300 transition-colors duration-150;
}
.star-rating .star.active {
    @apply text-yellow-400; /* Keep */
}

/* ===== NOISE OVERLAY ===== */
/* REMOVE the .noise-overlay::before block entirely, or change opacity to 0 */
/* It was designed for the dark theme and is unnecessary on white */
```

---

### PART 2: Layout Templates (Do These Second)

These are the structural wrappers used by all pages.

---

#### 2.1 `resources/views/layouts/app.blade.php` (Main public layout)
**Path:** `d:\WORK\Beauvia\resources\views\layouts\app.blade.php`

**Line-by-line changes:**

| Line/Area | Current | Target |
|---|---|---|
| `<body>` | `class="noise-overlay min-h-screen flex flex-col"` | `class="min-h-screen flex flex-col"` (remove noise-overlay) |
| Nav `bg-dark-950/80 backdrop-blur-xl border-b border-white/5` | Scrolled state background | `bg-white/80 backdrop-blur-xl border-b border-gray-200 shadow-sm` |
| Logo text | `text-white` | `text-gray-900` |
| Nav links | `text-dark-300 hover:text-white` | `text-gray-600 hover:text-gray-900` |
| Search input | `bg-white/5 border-white/10 text-white placeholder-dark-400` | `bg-gray-50 border-gray-300 text-gray-900 placeholder-gray-400` |
| Sign In link | `text-dark-300 hover:text-white` | `text-gray-600 hover:text-gray-900` |
| User dropdown trigger | `text-dark-300`, `text-dark-400` | `text-gray-600`, `text-gray-400` |
| Dropdown menu | `glass-card` | Remove `glass-card`, add `bg-white shadow-lg border border-gray-200 rounded-2xl` |
| Dropdown links | `text-dark-300 hover:text-white hover:bg-white/5` | `text-gray-600 hover:text-gray-900 hover:bg-gray-50` |
| Dropdown divider `<hr>` | `border-white/10` | `border-gray-100` |
| Mobile nav | `border-white/10` | `border-gray-200` |
| Mobile nav links | `text-dark-300 hover:text-white` | `text-gray-600 hover:text-gray-900` |
| Mobile nav "Get Started" | `text-primary-400` | `text-primary-600` |
| Success toast | `glass-card ... text-emerald-400` | `bg-white shadow-lg border border-gray-200 ... text-emerald-600` |
| Error toast | `glass-card ... text-red-400` | `bg-white shadow-lg border border-gray-200 ... text-red-600` |
| Footer | `border-white/5` | `border-gray-100` |
| Footer logo text | `text-white` | `text-gray-900` |
| Footer description | `text-dark-400` | `text-gray-500` |
| Footer headings | `text-white` | `text-gray-900` |
| Footer links | `text-dark-400 hover:text-white` | `text-gray-500 hover:text-gray-900` |
| Footer copyright | `text-dark-500` | `text-gray-400` |
| Footer divider | `border-white/5` | `border-gray-100` |

---

#### 2.2 `resources/views/layouts/dashboard.blade.php` (Dashboard layout)
**Path:** `d:\WORK\Beauvia\resources\views\layouts\dashboard.blade.php`

| Line/Area | Current | Target |
|---|---|---|
| `<body>` | `noise-overlay min-h-screen bg-dark-950 text-white` | `min-h-screen bg-gray-50 text-gray-900` |
| Sidebar | `bg-dark-900/50 backdrop-blur-xl border-r border-white/5` | `bg-white border-r border-gray-200` |
| Sidebar logo text | `text-white` | `text-gray-900` |
| Sidebar user name | `text-white` | `text-gray-900` |
| Sidebar user role | `text-dark-400` | `text-gray-500` |
| Sidebar sign out | `text-dark-400 hover:text-white` | `text-gray-500 hover:text-gray-900` |
| Sidebar bottom border | `border-white/5` | `border-gray-200` |
| Header | `bg-dark-950/80 backdrop-blur-xl border-b border-white/5` | `bg-white/80 backdrop-blur-xl border-b border-gray-200 shadow-sm` |
| Header title | `text-white` | `text-gray-900` |
| Header hamburger | `text-dark-400 hover:text-white` | `text-gray-500 hover:text-gray-900` |
| Header "Back to site" | `text-dark-400 hover:text-white` | `text-gray-500 hover:text-gray-900` |
| Mobile overlay | `bg-black/50` | `bg-black/20` (lighter overlay) |

---

#### 2.3 `resources/views/layouts/guest.blade.php` (Guest layout)
**Path:** `d:\WORK\Beauvia\resources\views\layouts\guest.blade.php`

Check for dark backgrounds and convert similarly.

---

#### 2.4 `resources/views/layouts/navigation.blade.php` (Breeze default nav)
**Path:** `d:\WORK\Beauvia\resources\views\layouts\navigation.blade.php`

This file already uses **light theme classes** (`bg-white`, `border-gray-100`, `text-gray-500`). 
**→ Likely already converted. Verify and SKIP if so.**

---

### PART 3: Reusable Components

---

#### 3.1 `resources/views/components/layouts/app.blade.php`
**Path:** `d:\WORK\Beauvia\resources\views\components\layouts\app.blade.php`

This is the **same content** as `layouts/app.blade.php` (Blade component version). Apply the SAME changes from Part 2.1.

#### 3.2 `resources/views/components/layouts/dashboard.blade.php`
**Path:** `d:\WORK\Beauvia\resources\views\components\layouts\dashboard.blade.php`

Same content as `layouts/dashboard.blade.php`. Apply the SAME changes from Part 2.2.

#### 3.3 Other Components
**Path:** `d:\WORK\Beauvia\resources\views\components\`

Files to check and convert if needed:

| File | Likely Status | Key Changes |
|---|---|---|
| `nav-link.blade.php` | Check | Dark text states → gray equivalents |
| `dropdown.blade.php` | Check | Background colors |
| `dropdown-link.blade.php` | Check | Hover states |
| `primary-button.blade.php` | Check | Usually fine (accent color) |
| `secondary-button.blade.php` | Check | Dark bg → light bg |
| `danger-button.blade.php` | Check | Usually fine (red accent) |
| `text-input.blade.php` | Check | Dark input styles → light |
| `input-label.blade.php` | Check | Text color |
| `input-error.blade.php` | Check | Error text color |
| `modal.blade.php` | Check | Background/overlay colors |
| `responsive-nav-link.blade.php` | Check | Text/hover colors |
| `application-logo.blade.php` | Check | SVG fill colors |

---

### PART 4: Public Pages

---

#### 4.1 `resources/views/home.blade.php` (Homepage)
**Path:** `d:\WORK\Beauvia\resources\views\home.blade.php`

| Section | Key Changes |
|---|---|
| **Hero** | `bg-hero-gradient` → `bg-gradient-to-br from-primary-50 via-white to-gray-50` |
| Hero blobs | `bg-primary-600/20` → `bg-primary-200/40`; `bg-coral-500/15` → `bg-pink-200/30` |
| Hero badge | `glass-card` → white card; `text-dark-300` → `text-gray-600` |
| Hero h1 | Inherits body text color (now dark) — should be fine |
| Hero subtitle | `text-dark-300` → `text-gray-500` |
| Bottom fade | `from-dark-950 to-transparent` → `from-white to-transparent` |
| Category section | `text-dark-300 group-hover:text-white` → `text-gray-600 group-hover:text-gray-900` |
| Shop cards | `from-primary-900/50 to-dark-800` placeholders → `from-primary-50 to-gray-100`; all `text-white` → `text-gray-900`; `text-dark-400` → `text-gray-500`; `border-white/5` → `border-gray-100` |
| Background section gradient | `via-primary-950/10` → `via-primary-50/30` |
| Freelancer cards | Same pattern as shop cards |
| How It Works icons | `from-primary-600/20 to-primary-800/20 border-primary-500/20` → `from-primary-50 to-primary-100 border-primary-200` |
| Steps | `text-white` → `text-gray-900`; `text-dark-400` → `text-gray-500` |
| Stats section | glass-card handles itself; `text-dark-400` → `text-gray-500` |
| CTA section | `text-dark-400` → `text-gray-500` |

---

#### 4.2 `resources/views/shops/index.blade.php` (Shops listing)
**Path:** `d:\WORK\Beauvia\resources\views\shops\index.blade.php`

| Element | Current | Target |
|---|---|---|
| Active filter badge | `bg-primary-600 text-white` | Keep (accent) |
| Inactive filter badge | `bg-white/5 text-dark-300 hover:bg-white/10 border-white/10` | `bg-gray-100 text-gray-600 hover:bg-gray-200 border-gray-200` |
| Sort text | `text-dark-400` | `text-gray-500` |
| Sort select | `bg-white/5 border-white/10 text-white` | `bg-white border-gray-300 text-gray-900` |
| Card placeholder bg | `from-primary-900/50 to-dark-800` | `from-primary-50 to-gray-100` |
| Card text-white headings | → `text-gray-900` |
| Card hover text | `group-hover:text-primary-300` | `group-hover:text-primary-600` |
| `text-dark-400`, `text-dark-500` | → `text-gray-500`, `text-gray-400` |
| Borders `border-white/5` | → `border-gray-100` |
| `text-primary-400` | → `text-primary-600` |
| Empty state `text-white` | → `text-gray-900` |

---

#### 4.3 `resources/views/shops/show.blade.php` (Shop detail)
**Path:** `d:\WORK\Beauvia\resources\views\shops\show.blade.php`

Apply the same pattern: all `text-white` → `text-gray-900`, `text-dark-*` → `text-gray-*`, `bg-white/*` glass → `bg-white shadow-sm border-gray-200`, `border-white/*` → `border-gray-*`.

---

#### 4.4 `resources/views/freelancers/index.blade.php` (Freelancers listing)
**Path:** `d:\WORK\Beauvia\resources\views\freelancers\index.blade.php`

Same pattern as shops/index.

---

#### 4.5 `resources/views/freelancers/show.blade.php` (Freelancer detail)
**Path:** `d:\WORK\Beauvia\resources\views\freelancers\show.blade.php`

Same pattern as shops/show.

---

#### 4.6 `resources/views/bookings/create.blade.php` (Booking form)
**Path:** `d:\WORK\Beauvia\resources\views\bookings\create.blade.php`

Focus on: form inputs, card backgrounds, text colors.

#### 4.7 `resources/views/bookings/confirmation.blade.php` (Booking confirmation)
**Path:** `d:\WORK\Beauvia\resources\views\bookings\confirmation.blade.php`

Focus on: confirmation card, status colors, text colors.

---

### PART 5: Auth Pages

---

#### 5.1 `resources/views/auth/login.blade.php`
**Path:** `d:\WORK\Beauvia\resources\views\auth\login.blade.php`

| Element | Current | Target |
|---|---|---|
| Heading | `text-white` | `text-gray-900` |
| Subtitle | `text-dark-400` | `text-gray-500` |
| Card | `glass-card` | Handled by CSS update |
| Labels | `text-dark-300` | `text-gray-700` |
| Input | `input-dark` | Handled by CSS update |
| Error text | `text-red-400` | `text-red-600` |
| Checkbox | `border-white/20 bg-white/5` | `border-gray-300 bg-white` |
| Remember text | `text-dark-300` | `text-gray-600` |
| Forgot link | `text-primary-400` | `text-primary-600` |
| Bottom text | `text-dark-400` | `text-gray-500` |
| Create link | `text-primary-400` | `text-primary-600` |
| Demo section | `text-dark-400`, `text-primary-400` | `text-gray-500`, `text-primary-600` |
| Demo buttons | `bg-white/5 text-dark-300 hover:bg-white/10` | `bg-gray-100 text-gray-600 hover:bg-gray-200` |

---

#### 5.2 `resources/views/auth/register.blade.php`
Same pattern as login.

#### 5.3 `resources/views/auth/forgot-password.blade.php`
Same pattern.

#### 5.4 `resources/views/auth/reset-password.blade.php`
Same pattern.

#### 5.5 `resources/views/auth/confirm-password.blade.php`
Same pattern.

#### 5.6 `resources/views/auth/verify-email.blade.php`
Same pattern.

---

### PART 6: Dashboard Pages

---

#### 6.1 All Dashboard Sidebar Navigation Links (appears in each dashboard page)
Common pattern in all dashboard blade files:

| Current | Target |
|---|---|
| Active: `bg-primary-600/20 text-primary-300` | `bg-primary-50 text-primary-700` |
| Inactive: `text-dark-300 hover:text-white hover:bg-white/5` | `text-gray-600 hover:text-gray-900 hover:bg-gray-50` |

---

#### 6.2 `resources/views/dashboard/shop/index.blade.php`
#### 6.3 `resources/views/dashboard/shop/bookings.blade.php`
#### 6.4 `resources/views/dashboard/shop/services.blade.php`
#### 6.5 `resources/views/dashboard/shop/setup.blade.php`
#### 6.6 `resources/views/dashboard/freelancer/index.blade.php`
#### 6.7 `resources/views/dashboard/freelancer/bookings.blade.php`
#### 6.8 `resources/views/dashboard/freelancer/services.blade.php`
#### 6.9 `resources/views/dashboard/freelancer/setup.blade.php`
#### 6.10 `resources/views/dashboard/customer/index.blade.php`
#### 6.11 `resources/views/dashboard/customer/bookings.blade.php`
#### 6.12 `resources/views/dashboard.blade.php`

**Common changes for ALL dashboard pages:**

| Element | Current | Target |
|---|---|---|
| `glass-card p-5/p-6` | Dark glass cards | White cards with shadow (handled by CSS) |
| Stat labels | `text-dark-400` | `text-gray-500` |
| Stat values | `text-white` | `text-gray-900` |
| Card headings | `text-white` | `text-gray-900` |
| View all links | `text-primary-400` | `text-primary-600` |
| List items bg | `bg-white/5` | `bg-gray-50` |
| Item text | `text-white`, `text-dark-400` | `text-gray-900`, `text-gray-500` |
| Review text | `text-dark-300` | `text-gray-600` |
| Empty states | `text-dark-400` | `text-gray-500` |
| Inactive star | `text-dark-600` | `text-gray-300` |

---

### PART 7: Profile Pages

---

#### 7.1 `resources/views/profile/edit.blade.php`
#### 7.2 `resources/views/profile/partials/update-profile-information-form.blade.php`
#### 7.3 `resources/views/profile/partials/update-password-form.blade.php`
#### 7.4 `resources/views/profile/partials/delete-user-form.blade.php`

Check if these use the custom dark classes or Laravel Breeze default light classes. If they use Breeze defaults, they may already be light.

---

### PART 8: `resources/views/welcome.blade.php` (Laravel default welcome page)

This is the **Laravel default welcome page** and is NOT part of the Beauvia app. It can be:
- **Deleted** (if not used), or
- **Ignored** (it has its own self-contained styles)

---

## 🔍 Quick Search & Replace Reference

Use these regex/search patterns in your editor to find remaining dark theme classes across all `.blade.php` files:

```
# Find dark background classes
text-white(?!/)
bg-dark-
text-dark-
border-white/
bg-white/5
bg-white/10
bg-white/20
hover:bg-white/
hover:text-white
hover:border-white/
glass-card  (check if CSS was already updated)
noise-overlay
bg-hero-gradient  (check if tailwind config was already updated)
from-dark-
to-dark-
```

After converting each file, search for these patterns in the file to make sure none remain.

---

## ✅ Conversion Progress Tracker

Use this checklist to track which files have been converted:

- [ ] `tailwind.config.js`
- [ ] `resources/css/app.css`
- [ ] **Layouts**
  - [ ] `resources/views/layouts/app.blade.php`
  - [ ] `resources/views/layouts/dashboard.blade.php`
  - [ ] `resources/views/layouts/guest.blade.php`
  - [ ] `resources/views/layouts/navigation.blade.php`
- [ ] **Component Layouts**
  - [ ] `resources/views/components/layouts/app.blade.php`
  - [ ] `resources/views/components/layouts/dashboard.blade.php`
- [ ] **Components**
  - [ ] `resources/views/components/nav-link.blade.php`
  - [ ] `resources/views/components/dropdown.blade.php`
  - [ ] `resources/views/components/dropdown-link.blade.php`
  - [ ] `resources/views/components/primary-button.blade.php`
  - [ ] `resources/views/components/secondary-button.blade.php`
  - [ ] `resources/views/components/danger-button.blade.php`
  - [ ] `resources/views/components/text-input.blade.php`
  - [ ] `resources/views/components/input-label.blade.php`
  - [ ] `resources/views/components/input-error.blade.php`
  - [ ] `resources/views/components/modal.blade.php`
  - [ ] `resources/views/components/responsive-nav-link.blade.php`
  - [ ] `resources/views/components/application-logo.blade.php`
  - [ ] `resources/views/components/auth-session-status.blade.php`
- [ ] **Public Pages**
  - [ ] `resources/views/home.blade.php`
  - [ ] `resources/views/shops/index.blade.php`
  - [ ] `resources/views/shops/show.blade.php`
  - [ ] `resources/views/freelancers/index.blade.php`
  - [ ] `resources/views/freelancers/show.blade.php`
  - [ ] `resources/views/bookings/create.blade.php`
  - [ ] `resources/views/bookings/confirmation.blade.php`
- [ ] **Auth Pages**
  - [ ] `resources/views/auth/login.blade.php`
  - [ ] `resources/views/auth/register.blade.php`
  - [ ] `resources/views/auth/forgot-password.blade.php`
  - [ ] `resources/views/auth/reset-password.blade.php`
  - [ ] `resources/views/auth/confirm-password.blade.php`
  - [ ] `resources/views/auth/verify-email.blade.php`
- [ ] **Dashboard Pages**
  - [ ] `resources/views/dashboard.blade.php`
  - [ ] `resources/views/dashboard/customer/index.blade.php`
  - [ ] `resources/views/dashboard/customer/bookings.blade.php`
  - [ ] `resources/views/dashboard/shop/index.blade.php`
  - [ ] `resources/views/dashboard/shop/bookings.blade.php`
  - [ ] `resources/views/dashboard/shop/services.blade.php`
  - [ ] `resources/views/dashboard/shop/setup.blade.php`
  - [ ] `resources/views/dashboard/freelancer/index.blade.php`
  - [ ] `resources/views/dashboard/freelancer/bookings.blade.php`
  - [ ] `resources/views/dashboard/freelancer/services.blade.php`
  - [ ] `resources/views/dashboard/freelancer/setup.blade.php`
- [ ] **Profile Pages**
  - [ ] `resources/views/profile/edit.blade.php`
  - [ ] `resources/views/profile/partials/update-profile-information-form.blade.php`
  - [ ] `resources/views/profile/partials/update-password-form.blade.php`
  - [ ] `resources/views/profile/partials/delete-user-form.blade.php`

---

## 🚫 DO NOT Change

- **Layouts / Structure** — Keep all HTML structure, grids, flex layouts exactly as-is
- **JavaScript logic** — Don't touch Alpine.js directives, form handling, etc.
- **Routes / Controllers** — No backend changes
- **Icons / SVGs** — Keep all icons, only change `currentColor` inheritance via parent text color
- **Animations** — Keep all animations (float, glow, slide-up, fade-in)
- **Font families** — Keep Inter and Plus Jakarta Sans
- **Primary purple color palette** — Keep as-is, just use darker shades (600/700) instead of lighter (300/400) for contrast on white
- **Coral accent palette** — Keep as-is

---

## 💡 Tips for AI Assistants

1. **Always check first** — Before editing any file, read it and check if it already uses light theme classes
2. **Start with global files** — CSS and layouts affect everything; don't convert page files before globals
3. **Test after each part** — Run `npm run dev` and visually check in browser after each section
4. **Search for stragglers** — After converting a file, grep for `text-white`, `bg-dark-`, `text-dark-`, `border-white/` to catch any missed classes
5. **Don't change class names** — Keep `.glass-card`, `.input-dark`, `.btn-secondary` etc. — just change their definitions in CSS. This prevents breaking pages that haven't been converted yet
6. **Badge colors** — Status badges (emerald for success, yellow for pending, red for cancelled) should keep their color but shift from `/20` dark-mode opacity to `/10` or use lighter variants like `bg-emerald-50 text-emerald-700`
