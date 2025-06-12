# HRMS Quick Setup for New Organization
# PowerShell script for automated HRMS setup

Write-Host ""
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "   HRMS Quick Organization Setup" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

# Function to get user input with validation
function Get-UserInput {
    param(
        [string]$Prompt,
        [string]$Default = "",
        [bool]$Required = $true
    )

    do {
        if ($Default) {
            $input = Read-Host "$Prompt [$Default]"
            if (-not $input) { $input = $Default }
        } else {
            $input = Read-Host $Prompt
        }

        if ($Required -and -not $input) {
            Write-Host "This field is required!" -ForegroundColor Red
        }
    } while ($Required -and -not $input)

    return $input
}

# Get organization details
Write-Host "Please provide your organization details:" -ForegroundColor Yellow
Write-Host ""

$companyName = Get-UserInput "Company Name"
$companyCode = Get-UserInput "Company Code (e.g., ACME)" ([regex]::Replace($companyName.Substring(0, [Math]::Min(6, $companyName.Length)), '[^a-zA-Z0-9]', '').ToUpper())
$adminEmail = Get-UserInput "Admin Email"
$adminPassword = Get-UserInput "Admin Password (min 8 characters)"
$companyPhone = Get-UserInput "Phone Number" "+1234567890"
$companyAddress = Get-UserInput "Company Address"
$companyWebsite = Get-UserInput "Website" "https://example.com" $false

Write-Host ""
Write-Host "========================================" -ForegroundColor Green
Write-Host "   Setting up $companyName" -ForegroundColor Green
Write-Host "========================================" -ForegroundColor Green
Write-Host ""

try {
    # Check if .env exists
    Write-Host "[1/6] Setting up environment..." -ForegroundColor Blue
    if (-not (Test-Path ".env")) {
        Copy-Item ".env.example" ".env"
        Write-Host "Environment file created" -ForegroundColor Green
    } else {
        Write-Host "Environment file already exists" -ForegroundColor Yellow
    }

    # Generate app key
    Write-Host "[2/6] Generating application key..." -ForegroundColor Blue
    php artisan key:generate --force
    if ($LASTEXITCODE -ne 0) { throw "Failed to generate application key" }

    # Run migrations
    Write-Host "[3/6] Setting up database..." -ForegroundColor Blue
    php artisan migrate --force
    if ($LASTEXITCODE -ne 0) { throw "Failed to run database migrations" }

    # Setup organization
    Write-Host "[4/6] Setting up organization..." -ForegroundColor Blue
    $setupArgs = @(
        "organization:setup",
        "--company-name=`"$companyName`"",
        "--company-code=`"$companyCode`"",
        "--admin-email=`"$adminEmail`"",
        "--admin-password=`"$adminPassword`"",
        "--phone=`"$companyPhone`"",
        "--address=`"$companyAddress`""
    )

    if ($companyWebsite) {
        $setupArgs += "--website=`"$companyWebsite`""
    }

    $setupArgs += @("--clear-demo", "--no-interaction")

    & php artisan $setupArgs
    if ($LASTEXITCODE -ne 0) { throw "Failed to setup organization" }

    # Optimize application
    Write-Host "[5/6] Optimizing application..." -ForegroundColor Blue
    php artisan optimize
    if ($LASTEXITCODE -ne 0) { throw "Failed to optimize application" }

    # Success message
    Write-Host "[6/6] Setup complete!" -ForegroundColor Green
    Write-Host ""
    Write-Host "========================================" -ForegroundColor Green
    Write-Host "   $companyName HRMS Ready!" -ForegroundColor Green
    Write-Host "========================================" -ForegroundColor Green
    Write-Host ""
    Write-Host "Your HRMS system is now configured and ready to use!" -ForegroundColor Green
    Write-Host ""
    Write-Host "🌐 Admin Login URL: " -NoNewline -ForegroundColor Cyan
    Write-Host "http://localhost:8000/admin/login" -ForegroundColor White
    Write-Host "📧 Email: " -NoNewline -ForegroundColor Cyan
    Write-Host $adminEmail -ForegroundColor White
    Write-Host "🔑 Password: " -NoNewline -ForegroundColor Cyan
    Write-Host "[Your configured password]" -ForegroundColor White
    Write-Host ""
    Write-Host "👥 Employee Portal: " -NoNewline -ForegroundColor Cyan
    Write-Host "http://localhost:8000/employee/login" -ForegroundColor White
    Write-Host "🏢 Public Careers Page: " -NoNewline -ForegroundColor Cyan
    Write-Host "http://localhost:8000/careers" -ForegroundColor White
    Write-Host ""
    Write-Host "To start the development server:" -ForegroundColor Yellow
    Write-Host "php artisan serve" -ForegroundColor White
    Write-Host ""
    Write-Host "Next Steps:" -ForegroundColor Yellow
    Write-Host "1. Upload your company logo via Admin Dashboard" -ForegroundColor White
    Write-Host "2. Customize departments and job families" -ForegroundColor White
    Write-Host "3. Configure payroll settings" -ForegroundColor White
    Write-Host "4. Start adding employees!" -ForegroundColor White
    Write-Host ""

} catch {
    Write-Host ""
    Write-Host "❌ Setup failed: $($_.Exception.Message)" -ForegroundColor Red
    Write-Host ""
    Write-Host "Troubleshooting tips:" -ForegroundColor Yellow
    Write-Host "1. Ensure PHP and Composer are installed and in PATH" -ForegroundColor White
    Write-Host "2. Check database connection in .env file" -ForegroundColor White
    Write-Host "3. Verify file permissions for storage/ directory" -ForegroundColor White
    Write-Host "4. Run 'php artisan optimize:clear' to clear caches" -ForegroundColor White
    Write-Host ""
    exit 1
}

Write-Host "Press any key to continue..." -ForegroundColor Gray
$null = $Host.UI.RawUI.ReadKey("NoEcho,IncludeKeyDown")
