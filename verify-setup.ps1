# Installation Verification Script for KidsLearn
# Run this after setup to verify everything is configured correctly

Write-Host "🎓 KidsLearn Installation Verification" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

$allPassed = $true

# Function to check and report
function Test-Requirement {
    param($Name, $Command, $MinVersion)

    Write-Host "Checking $Name... " -NoNewline

    try {
        $output = Invoke-Expression $Command 2>&1
        if ($LASTEXITCODE -eq 0 -or $output) {
            Write-Host "✅ Installed" -ForegroundColor Green
            if ($output) {
                Write-Host "   Version: $output" -ForegroundColor Gray
            }
            return $true
        }
    } catch {
        Write-Host "❌ Not found" -ForegroundColor Red
        return $false
    }

    Write-Host "❌ Not found" -ForegroundColor Red
    return $false
}

# Check Node.js
Write-Host "`n📦 Checking Prerequisites..." -ForegroundColor Yellow
$nodeOk = Test-Requirement "Node.js" "node --version" "18.0.0"
$npmOk = Test-Requirement "npm" "npm --version" "9.0.0"

# Check project files
Write-Host "`n📁 Checking Project Files..." -ForegroundColor Yellow

$requiredFiles = @(
    "package.json",
    "next.config.js",
    "tsconfig.json",
    "tailwind.config.ts",
    ".env.local.example"
)

foreach ($file in $requiredFiles) {
    if (Test-Path $file) {
        Write-Host "✅ $file" -ForegroundColor Green
    } else {
        Write-Host "❌ $file missing" -ForegroundColor Red
        $allPassed = $false
    }
}

# Check for .env.local
Write-Host "`n🔐 Checking Environment Configuration..." -ForegroundColor Yellow
if (Test-Path ".env.local") {
    Write-Host "✅ .env.local exists" -ForegroundColor Green

    $envContent = Get-Content ".env.local" -Raw

    if ($envContent -match "NEXT_PUBLIC_SUPABASE_URL=.+") {
        Write-Host "✅ SUPABASE_URL configured" -ForegroundColor Green
    } else {
        Write-Host "⚠️  SUPABASE_URL not configured" -ForegroundColor Yellow
    }

    if ($envContent -match "NEXT_PUBLIC_SUPABASE_ANON_KEY=.+") {
        Write-Host "✅ SUPABASE_ANON_KEY configured" -ForegroundColor Green
    } else {
        Write-Host "⚠️  SUPABASE_ANON_KEY not configured" -ForegroundColor Yellow
    }

    if ($envContent -match "SUPABASE_SERVICE_ROLE_KEY=.+") {
        Write-Host "✅ SUPABASE_SERVICE_ROLE_KEY configured" -ForegroundColor Green
    } else {
        Write-Host "⚠️  SUPABASE_SERVICE_ROLE_KEY not configured" -ForegroundColor Yellow
    }
} else {
    Write-Host "❌ .env.local not found" -ForegroundColor Red
    Write-Host "   Run: copy .env.local.example .env.local" -ForegroundColor Gray
    $allPassed = $false
}

# Check directories
Write-Host "`n📂 Checking Directory Structure..." -ForegroundColor Yellow

$requiredDirs = @(
    "src",
    "src/app",
    "src/services",
    "src/store",
    "src/lib",
    "src/types",
    "supabase",
    "supabase/migrations",
    "supabase/seeds",
    "scripts",
    "public",
    "public/img",
    "public/sound"
)

foreach ($dir in $requiredDirs) {
    if (Test-Path $dir) {
        Write-Host "✅ $dir" -ForegroundColor Green
    } else {
        Write-Host "❌ $dir missing" -ForegroundColor Red
        $allPassed = $false
    }
}

# Check node_modules
Write-Host "`n📦 Checking Dependencies..." -ForegroundColor Yellow
if (Test-Path "node_modules") {
    Write-Host "✅ node_modules installed" -ForegroundColor Green

    # Count packages
    $packageCount = (Get-ChildItem "node_modules" -Directory).Count
    Write-Host "   $packageCount packages installed" -ForegroundColor Gray
} else {
    Write-Host "❌ node_modules not found" -ForegroundColor Red
    Write-Host "   Run: npm install" -ForegroundColor Gray
    $allPassed = $false
}

# Check for package.json dependencies
if (Test-Path "package.json") {
    Write-Host "`n📋 Checking Key Dependencies..." -ForegroundColor Yellow
    $packageJson = Get-Content "package.json" | ConvertFrom-Json

    $keyDeps = @("next", "react", "react-dom", "@supabase/supabase-js", "zustand", "bcryptjs")

    foreach ($dep in $keyDeps) {
        if ($packageJson.dependencies.$dep) {
            Write-Host "✅ $dep" -ForegroundColor Green
        } else {
            Write-Host "❌ $dep missing from package.json" -ForegroundColor Red
            $allPassed = $false
        }
    }
}

# Check TypeScript files
Write-Host "`n📘 Checking Source Files..." -ForegroundColor Yellow

$keyFiles = @(
    "src/app/page.tsx",
    "src/app/layout.tsx",
    "src/app/login/page.tsx",
    "src/app/register/page.tsx",
    "src/app/dashboard/page.tsx",
    "src/services/auth.service.ts",
    "src/services/data.service.ts",
    "src/store/userStore.ts",
    "src/lib/supabase.ts"
)

foreach ($file in $keyFiles) {
    if (Test-Path $file) {
        Write-Host "✅ $file" -ForegroundColor Green
    } else {
        Write-Host "❌ $file missing" -ForegroundColor Red
        $allPassed = $false
    }
}

# Check database files
Write-Host "`n🗄️ Checking Database Files..." -ForegroundColor Yellow

if (Test-Path "supabase/migrations/001_initial_schema.sql") {
    Write-Host "✅ Migration file exists" -ForegroundColor Green
} else {
    Write-Host "❌ Migration file missing" -ForegroundColor Red
    $allPassed = $false
}

if (Test-Path "supabase/seeds/001_seed_data.sql") {
    Write-Host "✅ Seed file exists" -ForegroundColor Green
} else {
    Write-Host "❌ Seed file missing" -ForegroundColor Red
    $allPassed = $false
}

# Summary
Write-Host "`n" -NoNewline
Write-Host "========================================" -ForegroundColor Cyan
if ($allPassed -and $nodeOk -and $npmOk) {
    Write-Host "✅ All checks passed!" -ForegroundColor Green
    Write-Host ""
    Write-Host "🚀 Next Steps:" -ForegroundColor Yellow
    Write-Host "   1. Configure .env.local with your Supabase credentials"
    Write-Host "   2. Run migrations in Supabase SQL Editor"
    Write-Host "   3. Seed the database"
    Write-Host "   4. Run: npm run dev"
    Write-Host ""
    Write-Host "📖 For detailed instructions, see SETUP.md" -ForegroundColor Gray
} else {
    Write-Host "⚠️  Some checks failed" -ForegroundColor Yellow
    Write-Host ""
    Write-Host "🔧 To fix:" -ForegroundColor Yellow

    if (-not $nodeOk) {
        Write-Host "   • Install Node.js from https://nodejs.org" -ForegroundColor Gray
    }

    if (!(Test-Path "node_modules")) {
        Write-Host "   • Run: npm install" -ForegroundColor Gray
    }

    if (!(Test-Path ".env.local")) {
        Write-Host "   • Run: copy .env.local.example .env.local" -ForegroundColor Gray
        Write-Host "   • Then edit .env.local with your Supabase credentials" -ForegroundColor Gray
    }

    Write-Host ""
    Write-Host "📖 See SETUP.md for complete instructions" -ForegroundColor Gray
}

Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""
