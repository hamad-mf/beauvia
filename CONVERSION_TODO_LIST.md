# Theme Conversion TODO List
## Files That Need White Minimalist Theme Conversion

**Total: 19 files remaining**

---

## ✅ ALREADY CONVERTED (7 files) - SKIP THESE
- ✅ `resources/views/home.blade.php`
- ✅ `resources/views/shops/index.blade.php`
- ✅ `resources/views/shops/show.blade.php`
- ✅ `resources/views/freelancers/index.blade.php`
- ✅ `resources/views/freelancers/show.blade.php`
- ✅ `resources/views/auth/login.blade.php`
- ✅ `resources/views/auth/register.blade.php`

---

## 🔴 PRIORITY 1: LAYOUTS (Convert These First - They Affect Multiple Pages)

### 1. Dashboard Layout (CRITICAL - Affects all 11 dashboard pages)
**File:** `resources/views/layouts/dashboard.blade.php`
**Impact:** Once converted, all dashboard pages will inherit the light theme foundation
**Status:** ❌ NOT CONVERTED

### 2. Dashboard Component Layout (Same as above, component version)
**File:** `resources/views/components/layouts/dashboard.blade.php`
**Impact:** Component version of dashboard layout
**Status:** ❌ NOT CONVERTED

---

## 🟡 PRIORITY 2: BOOKING PAGES (2 files)

### 3. Booking Create Page
**File:** `resources/views/bookings/create.blade.php`
**Status:** ❌ NOT CONVERTED

### 4. Booking Confirmation Page
**File:** `resources/views/bookings/confirmation.blade.php`
**Status:** ❌ NOT CONVERTED

---

## 🟡 PRIORITY 3: AUTH PAGES (4 files)

### 5. Forgot Password Page
**File:** `resources/views/auth/forgot-password.blade.php`
**Status:** ❌ NOT CONVERTED

### 6. Reset Password Page
**File:** `resources/views/auth/reset-password.blade.php`
**Status:** ❌ NOT CONVERTED

### 7. Confirm Password Page
**File:** `resources/views/auth/confirm-password.blade.php`
**Status:** ❌ NOT CONVERTED

### 8. Verify Email Page
**File:** `resources/views/auth/verify-email.blade.php`
**Status:** ❌ NOT CONVERTED

---

## 🟢 PRIORITY 4: CUSTOMER DASHBOARD (3 files)

### 9. Customer Dashboard Index
**File:** `resources/views/dashboard/customer/index.blade.php`
**Status:** ❌ NOT CONVERTED

### 10. Customer Bookings Page
**File:** `resources/views/dashboard/customer/bookings.blade.php`
**Status:** ❌ NOT CONVERTED

### 11. Main Dashboard Page (Fallback)
**File:** `resources/views/dashboard.blade.php`
**Status:** ❌ NOT CONVERTED

---

## 🟢 PRIORITY 5: SHOP OWNER DASHBOARD (4 files)

### 12. Shop Dashboard Index
**File:** `resources/views/dashboard/shop/index.blade.php`
**Status:** ❌ NOT CONVERTED

### 13. Shop Bookings Management
**File:** `resources/views/dashboard/shop/bookings.blade.php`
**Status:** ❌ NOT CONVERTED

### 14. Shop Services Management
**File:** `resources/views/dashboard/shop/services.blade.php`
**Status:** ❌ NOT CONVERTED

### 15. Shop Setup Page
**File:** `resources/views/dashboard/shop/setup.blade.php`
**Status:** ❌ NOT CONVERTED

---

## 🟢 PRIORITY 6: FREELANCER DASHBOARD (4 files)

### 16. Freelancer Dashboard Index
**File:** `resources/views/dashboard/freelancer/index.blade.php`
**Status:** ❌ NOT CONVERTED

### 17. Freelancer Bookings Management
**File:** `resources/views/dashboard/freelancer/bookings.blade.php`
**Status:** ❌ NOT CONVERTED

### 18. Freelancer Services Management
**File:** `resources/views/dashboard/freelancer/services.blade.php`
**Status:** ❌ NOT CONVERTED

### 19. Freelancer Setup Page
**File:** `resources/views/dashboard/freelancer/setup.blade.php`
**Status:** ❌ NOT CONVERTED

---

## 🔵 PRIORITY 7: PROFILE PAGES (2 files - May already be light)

### 20. Profile Edit Page
**File:** `resources/views/profile/edit.blade.php`
**Status:** ❌ NEEDS VERIFICATION (might already be light from Breeze)

### 21. Profile Partials (Check all 3)
**Files:**
- `resources/views/profile/partials/update-profile-information-form.blade.php`
- `resources/views/profile/partials/update-password-form.blade.php`
- `resources/views/profile/partials/delete-user-form.blade.php`
**Status:** ❌ NEEDS VERIFICATION (might already be light from Breeze)

---

## 📋 CONVERSION WORKFLOW FOR ANOTHER AI

### Instructions to Give Another Claude AI:

```
I need you to convert this Laravel Blade file from dark theme to white minimalist theme.

**Reference Guide:** [Paste the THEME_CONVERSION_GUIDE.md content here]

**File to Convert:** [Paste the file content here]

**File Path:** [e.g., resources/views/dashboard/shop/index.blade.php]

**Instructions:**
1. Follow the conversion guide exactly
2. Replace all dark theme classes with white minimalist equivalents
3. Keep all HTML structure, Alpine.js directives, and logic unchanged
4. Only change color-related Tailwind classes
5. Return the complete converted file content

**Key Changes:**
- bg-dark-* → bg-white or bg-gray-50
- text-white → text-gray-900
- text-dark-300/400 → text-gray-500/600
- bg-white/5, bg-white/10 → bg-gray-50 or bg-white with shadow
- border-white/5, border-white/10 → border-gray-100, border-gray-200
- glass-card effects → handled by CSS (keep class name)
- Remove noise-overlay class
```

---

## 📊 PROGRESS TRACKER

**Completed:** 7/26 pages (27%)
**Remaining:** 19/26 pages (73%)

### By Category:
- ✅ Public Pages: 5/7 (71%)
- ✅ Auth Pages: 2/6 (33%)
- ❌ Booking Pages: 0/2 (0%)
- ❌ Dashboard Pages: 0/11 (0%)
- ❌ Profile Pages: 0/2 (0%)

---

## 🎯 RECOMMENDED ORDER

**Start with Priority 1 (Layouts) first!** Converting the dashboard layout will make all dashboard pages inherit the light foundation, making individual page conversions easier.

1. Convert `resources/views/layouts/dashboard.blade.php` (CRITICAL)
2. Convert `resources/views/components/layouts/dashboard.blade.php` (Same as #1)
3. Then proceed with Priority 2-7 in any order

---

## ✅ VERIFICATION CHECKLIST (After Each Conversion)

After converting each file, verify:
- [ ] No `bg-dark-*` classes remain
- [ ] No `text-dark-*` classes remain
- [ ] No `bg-white/5` or `bg-white/10` remain
- [ ] No `border-white/5` or `border-white/10` remain
- [ ] No `text-white` on primary text (only on buttons/badges)
- [ ] No `noise-overlay` class
- [ ] All text is readable (dark text on light backgrounds)
- [ ] Cards use `bg-white` with `shadow-sm` and `border-gray-200`

---

## 📝 NOTES

- The global CSS (`resources/css/app.css`) and Tailwind config are already converted ✅
- The main public layout (`resources/views/layouts/app.blade.php`) is already converted ✅
- Components in `resources/views/components/` may need checking but are lower priority
- Profile pages might already be light (from Laravel Breeze defaults)
