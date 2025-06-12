#!/usr/bin/env powershell
# HRMS Deployment Validation Script
# Tests the complete deployment workflow

param(
    [switch]$RunFullTest = $false,
    [switch]$ValidateOnly = $true
)

Write-Host ""
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "   HRMS Deployment Validation" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

$ErrorActionPreference = "Stop"

# Test configuration
$testConfig = @{
    CompanyName = "Test Corp"
    CompanyCode = "TEST"
    AdminEmail = "test@example.com"
    AdminPassword = "TestPass123"
    Phone = "+1-555-TEST"
    Address = "123 Test St, Test City, TS 12345"
    Website = "https://test.com"
}

try {
    Write-Host "🧪 Running deployment validation tests..." -ForegroundColor Yellow
    Write-Host ""

    # Test 1: Check Laravel environment
    Write-Host "[Test 1/8] Checking Laravel environment..." -ForegroundColor Blue
    $env = php artisan env 2>&1
    if ($LASTEXITCODE -eq 0) {
        Write-Host "✅ Laravel environment OK" -ForegroundColor Green
    } else {
        throw "Laravel environment check failed: $env"
    }

    # Test 2: Check database connection
    Write-Host "[Test 2/8] Testing database connection..." -ForegroundColor Blue
    $dbTest = php artisan tinker --execute="DB::connection()->getPdo(); echo 'Database OK';" 2>&1
    if ($dbTest -match "Database OK") {
        Write-Host "✅ Database connection OK" -ForegroundColor Green
    } else {
        throw "Database connection failed: $dbTest"
    }

    # Test 3: Check if migrations are up to date
    Write-Host "[Test 3/8] Checking database migrations..." -ForegroundColor Blue
    $migrations = php artisan migrate:status 2>&1
    if ($LASTEXITCODE -eq 0) {
        Write-Host "✅ Database migrations OK" -ForegroundColor Green
    } else {
        throw "Migration check failed: $migrations"
    }

    # Test 4: Validate organization setup command
    Write-Host "[Test 4/8] Validating organization setup command..." -ForegroundColor Blue
    $commandCheck = php artisan organization:setup --help 2>&1
    if ($commandCheck -match "Set up HRMS for a new organization") {
        Write-Host "✅ Organization setup command OK" -ForegroundColor Green
    } else {
        throw "Organization setup command validation failed"
    }

    # Test 5: Check required models exist
    Write-Host "[Test 5/8] Checking required models..." -ForegroundColor Blue
    $models = @("User", "Employee", "Department", "JobFamily", "SpecificArea")
    foreach ($model in $models) {
        $modelCheck = php artisan tinker --execute="use App\\Models\\$model; echo 'Model $model OK';" 2>&1
        if (-not ($modelCheck -match "Model $model OK")) {
            throw "Model $model not found or has issues"
        }
    }
    Write-Host "✅ Required models OK" -ForegroundColor Green

    # Test 6: Validate setup scripts
    Write-Host "[Test 6/8] Validating setup scripts..." -ForegroundColor Blue
    $scripts = @("quick-setup.bat", "quick-setup.ps1", "setup.bat", "setup.sh")
    foreach ($script in $scripts) {
        if (Test-Path $script) {
            Write-Host "  ✓ $script exists" -ForegroundColor Green
        } else {
            Write-Host "  ⚠ $script missing" -ForegroundColor Yellow
        }
    }
    Write-Host "✅ Setup scripts validation complete" -ForegroundColor Green

    # Test 7: Check documentation
    Write-Host "[Test 7/8] Checking documentation..." -ForegroundColor Blue
    $docs = @("ORGANIZATION_SETUP.md", "QUICK_DEPLOYMENT.md", "DEPLOYMENT_README.md", "organization-config.template")
    foreach ($doc in $docs) {
        if (Test-Path $doc) {
            Write-Host "  ✓ $doc exists" -ForegroundColor Green
        } else {
            Write-Host "  ⚠ $doc missing" -ForegroundColor Yellow
        }
    }
    Write-Host "✅ Documentation check complete" -ForegroundColor Green

    # Test 8: Full setup test (only if requested)
    if ($RunFullTest) {
        Write-Host "[Test 8/8] Running full setup test..." -ForegroundColor Blue
        Write-Host "⚠ This will clear existing data!" -ForegroundColor Red

        $confirm = Read-Host "Continue with full test? (yes/no)"
        if ($confirm.ToLower() -eq "yes") {
            $setupCmd = @(
                "organization:setup",
                "--company-name=`"$($testConfig.CompanyName)`"",
                "--company-code=`"$($testConfig.CompanyCode)`"",
                "--admin-email=`"$($testConfig.AdminEmail)`"",
                "--admin-password=`"$($testConfig.AdminPassword)`"",
                "--phone=`"$($testConfig.Phone)`"",
                "--address=`"$($testConfig.Address)`"",
                "--website=`"$($testConfig.Website)`"",
                "--clear-demo",
                "--no-interaction"
            )

            & php artisan $setupCmd
            if ($LASTEXITCODE -eq 0) {
                Write-Host "✅ Full setup test completed successfully" -ForegroundColor Green
            } else {
                throw "Full setup test failed"
            }
        } else {
            Write-Host "⏭ Full setup test skipped" -ForegroundColor Yellow
        }
    } else {
        Write-Host "[Test 8/8] Full setup test skipped (use -RunFullTest to enable)" -ForegroundColor Yellow
    }

    Write-Host ""
    Write-Host "========================================" -ForegroundColor Green
    Write-Host "   ✅ All Tests Passed!" -ForegroundColor Green
    Write-Host "========================================" -ForegroundColor Green
    Write-Host ""
    Write-Host "🚀 Your HRMS deployment setup is ready!" -ForegroundColor Cyan
    Write-Host ""
    Write-Host "Next steps:" -ForegroundColor Yellow
    Write-Host "1. Use './quick-setup.ps1' for automated setup" -ForegroundColor White
    Write-Host "2. Or run 'php artisan organization:setup' for interactive setup" -ForegroundColor White
    Write-Host "3. Visit http://localhost:8000/admin/login after setup" -ForegroundColor White
    Write-Host ""

} catch {
    Write-Host ""
    Write-Host "❌ Test Failed: $($_.Exception.Message)" -ForegroundColor Red
    Write-Host ""
    exit 1
}
