# Instructions for Claude AI - Theme Conversion Task

## Your Task
Convert a Laravel Blade file from **dark/glassmorphism theme** to **clean white minimalist theme**.

---

## ⚠️ CRITICAL RULES

### DO:
✅ Change color-related Tailwind CSS classes only
✅ Follow the conversion guide mappings exactly
✅ Keep ALL HTML structure unchanged
✅ Keep ALL Alpine.js directives (x-data, x-show, @click, etc.) unchanged
✅ Keep ALL PHP/Blade syntax ({{ }}, @if, @foreach, etc.) unchanged
✅ Keep ALL JavaScript logic unchanged
✅ Return the COMPLETE file with all content

### DO NOT:
❌ Change HTML structure or layout
❌ Remove or modify Alpine.js directives
❌ Remove or modify PHP/Blade logic
❌ Change component names or slots
❌ Add new features or functionality
❌ Modify form inputs or validation
❌ Change route names or URLs

---

## 🎨 Conversion Reference Guide

### Background Colors
| Current (Dark) | Convert To (White) |
|---|---|
| `bg-dark-950` | `bg-white` or `bg-gray-50` |
| `bg-dark-900` | `bg-white` |
| `bg-dark-800` | `bg-gray-100` |
| `bg-white/5` | `bg-gray-50` or `bg-white` |
| `bg-white/10` | `bg-gray-100` |
| `bg-white/20` | `bg-gray-200` |
| `noise-overlay` | Remove this class |

### Text Colors
| Current (Dark) | Convert To (White) |
|---|---|
| `text-white` | `text-gray-900` |
| `text-dark-300` | `text-gray-600` |
| `text-dark-400` | `text-gray-500` |
| `text-dark-500` | `text-gray-400` |
| `text-dark-600` | `text-gray-300` |
| `text-primary-400` | `text-primary-600` |
| `text-primary-300` | `text-primary-700` |

### Border Colors
| Current (Dark) | Convert To (White) |
|---|---|
| `border-white/5` | `border-gray-100` |
| `border-white/10` | `border-gray-200` |
| `border-white/20` | `border-gray-300` |

### Hover States
| Current (Dark) | Convert To (White) |
|---|---|
| `hover:text-white` | `hover:text-gray-900` |
| `hover:bg-white/5` | `hover:bg-gray-50` |
| `hover:bg-white/10` | `hover:bg-gray-100` |
| `hover:border-white/20` | `hover:border-gray-300` |

### Special Cases
| Current (Dark) | Convert To (White) |
|---|---|
| `bg-primary-600/20 text-primary-300` (active state) | `bg-primary-50 text-primary-700` |
| `backdrop-blur-xl border-white/5` (nav/header) | `backdrop-blur-xl border-gray-200 shadow-sm` |
| `glass-card` | Keep as-is (CSS handles it) |
| `input-dark` | Keep as-is (CSS handles it) |
| `btn-primary` | Keep as-is (accent colors stay) |
| `btn-secondary` | Keep as-is (CSS handles it) |

### Badge/Status Colors
| Current (Dark) | Convert To (White) |
|---|---|
| `bg-emerald-500/20 text-emerald-300` | `bg-emerald-50 text-emerald-700` |
| `bg-yellow-500/20 text-yellow-300` | `bg-yellow-50 text-yellow-700` |
| `bg-red-500/20 text-red-300` | `bg-red-50 text-red-700` |
| `bg-primary-500/20 text-primary-300` | `bg-primary-50 text-primary-700` |

---

## 📋 Step-by-Step Process

### Step 1: Read the File
- Understand the structure
- Identify all color-related classes

### Step 2: Apply Conversions
- Go through the file line by line
- Replace dark theme classes with white theme equivalents
- Use the reference guide above

### Step 3: Verify
Check that you've converted:
- [ ] All `bg-dark-*` classes
- [ ] All `text-dark-*` classes
- [ ] All `bg-white/5`, `bg-white/10`, `bg-white/20`
- [ ] All `border-white/*` classes
- [ ] All `text-white` (except on buttons/badges)
- [ ] Removed `noise-overlay` class
- [ ] All hover states

### Step 4: Final Check
- [ ] HTML structure unchanged
- [ ] Alpine.js directives intact
- [ ] PHP/Blade syntax intact
- [ ] All content present
- [ ] No syntax errors

---

## 💡 Common Patterns

### Pattern 1: Sidebar Navigation Links
```blade
<!-- BEFORE (Dark) -->
<a href="..." class="text-dark-300 hover:text-white hover:bg-white/5">

<!-- AFTER (White) -->
<a href="..." class="text-gray-600 hover:text-gray-900 hover:bg-gray-50">
```

### Pattern 2: Active Navigation State
```blade
<!-- BEFORE (Dark) -->
<a href="..." class="bg-primary-600/20 text-primary-300">

<!-- AFTER (White) -->
<a href="..." class="bg-primary-50 text-primary-700">
```

### Pattern 3: Card Backgrounds
```blade
<!-- BEFORE (Dark) -->
<div class="glass-card p-5">
  <p class="text-dark-400">Label</p>
  <p class="text-white">Value</p>
</div>

<!-- AFTER (White) -->
<div class="glass-card p-5">
  <p class="text-gray-500">Label</p>
  <p class="text-gray-900">Value</p>
</div>
```

### Pattern 4: Body/Container
```blade
<!-- BEFORE (Dark) -->
<body class="noise-overlay min-h-screen bg-dark-950 text-white">

<!-- AFTER (White) -->
<body class="min-h-screen bg-gray-50 text-gray-900">
```

### Pattern 5: Header/Navigation Bar
```blade
<!-- BEFORE (Dark) -->
<header class="bg-dark-950/80 backdrop-blur-xl border-b border-white/5">

<!-- AFTER (White) -->
<header class="bg-white/80 backdrop-blur-xl border-b border-gray-200 shadow-sm">
```

### Pattern 6: Sidebar
```blade
<!-- BEFORE (Dark) -->
<aside class="bg-dark-900/50 backdrop-blur-xl border-r border-white/5">

<!-- AFTER (White) -->
<aside class="bg-white border-r border-gray-200">
```

### Pattern 7: Form Labels
```blade
<!-- BEFORE (Dark) -->
<label class="text-dark-300 text-sm mb-2 block">

<!-- AFTER (White) -->
<label class="text-gray-700 text-sm mb-2 block">
```

### Pattern 8: Empty States
```blade
<!-- BEFORE (Dark) -->
<p class="text-dark-400 text-center py-8">No items yet</p>

<!-- AFTER (White) -->
<p class="text-gray-500 text-center py-8">No items yet</p>
```

---

## 🚫 What NOT to Change

### Keep These Classes As-Is:
- `glass-card` (CSS handles the conversion)
- `input-dark` (CSS handles the conversion)
- `btn-primary` (accent colors work on both themes)
- `btn-secondary` (CSS handles the conversion)
- `btn-coral` (accent colors work on both themes)
- `gradient-text` (CSS handles the conversion)
- All animation classes (`animate-*`)
- All layout classes (`flex`, `grid`, `p-*`, `m-*`, etc.)
- All sizing classes (`w-*`, `h-*`, `max-w-*`, etc.)
- All positioning classes (`absolute`, `relative`, `fixed`, etc.)

### Keep These Elements Unchanged:
- All `{{ }}` PHP echo statements
- All `@if`, `@foreach`, `@forelse`, `@empty` Blade directives
- All `x-data`, `x-show`, `x-if`, `@click` Alpine.js directives
- All `href`, `action`, `method` attributes
- All form inputs and their names
- All SVG icons
- All route names

---

## ✅ Output Format

Return ONLY the converted file content. Do not include:
- Explanations
- Comments about what you changed
- File path headers
- Markdown code blocks (unless the original file had them)

Just return the raw converted Blade file content, ready to paste directly into the file.

---

## 📝 Example Conversion

### Input File:
```blade
<x-layouts.dashboard title="Shop Dashboard">
    <x-slot:sidebar>
        <a href="{{ route('shop.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm bg-primary-600/20 text-primary-300">
            Overview
        </a>
        <a href="{{ route('shop.bookings') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-dark-300 hover:text-white hover:bg-white/5">
            Bookings
        </a>
    </x-slot:sidebar>

    <div class="glass-card p-5">
        <p class="text-dark-400 text-sm mb-1">Today's Bookings</p>
        <p class="text-2xl font-display font-bold text-white">{{ $todayBookings }}</p>
    </div>
</x-layouts.dashboard>
```

### Output (Converted):
```blade
<x-layouts.dashboard title="Shop Dashboard">
    <x-slot:sidebar>
        <a href="{{ route('shop.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm bg-primary-50 text-primary-700">
            Overview
        </a>
        <a href="{{ route('shop.bookings') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-50">
            Bookings
        </a>
    </x-slot:sidebar>

    <div class="glass-card p-5">
        <p class="text-gray-500 text-sm mb-1">Today's Bookings</p>
        <p class="text-2xl font-display font-bold text-gray-900">{{ $todayBookings }}</p>
    </div>
</x-layouts.dashboard>
```

---

## 🎯 Ready to Start?

When you receive a file to convert:
1. Read it carefully
2. Apply the conversions from the reference guide
3. Verify using the checklist
4. Return the complete converted file

Good luck! 🚀
